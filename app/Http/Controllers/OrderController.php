<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        // print_r($request->user_id);
   
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'payment_method' => 'required|string',
            // 'items' => 'required|array',
            // 'items.*.product_id' => 'required|exists:products,id',
            // 'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 400);
        }
        try {
            // Start a database transaction
            DB::beginTransaction();

            $cartItems = Cart::where('user_id', $request->user_id)->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty.',
                ], 400);
            }

            // Calculate order totals
            $totalAmount = 0;
            $items = [];

            foreach ($cartItems as $cartItem) {
                $product = Product::findOrFail($cartItem->product_id);
                $subtotal = $product->price * $cartItem->quantity;
                $totalAmount += $subtotal;
    
                $items[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->title,
                    'price' => $product->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $subtotal,
                ];
            }

            // Razorpay order creation
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $razorpayOrder = $api->order->create([
                'receipt' => strtoupper(uniqid('ORD-')), // Optional: To add human-readable context for your reference
                'amount' => $totalAmount * 100, // Amount in paise
                'currency' => 'INR',
            ]);

            // Create the order in the database
            $order = Orders::create([
                'order_number' => $razorpayOrder['id'], // Using Razorpay's order_id as the sole identifier
                'user_id' => $request->user_id,
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'final_total' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
                'currency' => 'INR',
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }

            // Soft delete the cart items after order is created
            Cart::where('user_id', $request->user_id)->delete();

            // Commit the transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully!',
                'order_number' => $order->order_number,
                'razorpay_order_id' => $razorpayOrder['id'],
            ], 201);
            // return redirect()->route('orders.order-summary', ['order_id' => $order->order_number]);


        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create order.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function showOrderSummary($orderNumber)
    {
        // Fetch the order from the database
        $order = Orders::with('user')->where('order_number', $orderNumber)->firstOrFail();
        $cart = Cart::with('product')->where('user_id', Auth::user()->id)->get();
        $total = $cart->sum(fn($item) => $item->product->price * $item->quantity);
        return view('orders/order-summary', ['order' => $order,'cart' => $cart, 'total' => $total]);
    }

    public function orderList()
    {
        $orders = Orders::with('user')->orderBy('created_at','DESC')->get();
        return view('orders/orderList',[
            'orders' => $orders
        ]);
    }

    public function verifyPayment(Request $request)
    {
        $signature = $request->razorpay_signature;
        $paymentId = $request->razorpay_payment_id;
        $orderId = $request->razorpay_order_id;

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $attributes = [
            'razorpay_signature' => $signature,
            'razorpay_payment_id' => $paymentId,
            'razorpay_order_id' => $orderId
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);

            $order = Orders::where('order_number', $orderId)->first();
            $order->update(['status' => 'confirmed']);

            return response()->json(['success' => 'Payment verified successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Payment verification failed in verifyPayment api!', 'errormessage' => $e]);
        }
    }
}