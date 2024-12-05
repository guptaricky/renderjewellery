<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            // 'shipping_address_id' => 'required|exists:user_addresses,id',
            // 'billing_address_id' => 'required|exists:user_addresses,id',
            'payment_method' => 'required|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Calculate order totals
            $totalAmount = 0;
            $items = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $items[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->title,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                    'attributes' => json_encode([
                        'weight' => $product->weight,
                        'dimensions' => $product->dimensions,
                    ]),
                ];
            }

            // Create the order
            $order = Orders::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => $request->user_id,
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'final_total' => $totalAmount, // Adjust if there are discounts or taxes
                'shipping_address_id' => $request->shipping_address_id,
                'billing_address_id' => $request->billing_address_id,
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
                'currency' => 'USD',
            ]);

            // Create order items
            foreach ($items as $item) {
                $order->items()->create($item);
            }

            // Commit the transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully!',
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ], 201);

        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create order.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function orderList()
    {
        $orders = Orders::with('user')->orderBy('created_at','DESC')->get();
        return view('orders/orderList',[
            'orders' => $orders
        ]);
    }
}