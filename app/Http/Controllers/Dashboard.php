<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Dashboard extends Controller
{
    public function adminDashboard(Request $request): View
    {
        $orders = Orders::where('payment_status', 'paid')->orderBy('created_at', 'DESC')->get();
        $products = Product::with('productdesign')->orderBy('created_at', 'DESC')->get();
        // $designers = User::orderBy('created_at','DESC')->get();

        $roleCounts = Role::withCount(['users'])->get();
        // dd($roleCounts);
        return view('dashboard.adminDashboard', [
            'user' => $request->user(),
            'orders' => $orders,
            'products' => $products,
            'roleCounts' => $roleCounts
        ]);
    }

    public function userDashboard(Request $request): View
    {
        $orders = Orders::where('payment_status', 'paid')->orderBy('created_at', 'DESC')->get();
        // $products = Product::orderBy('created_at', 'DESC')->get();
        $products = Product::with(['category', 'subcategory'])
            ->orderBy('created_at', 'DESC')
            ->get();
        // $designers = User::orderBy('created_at','DESC')->get();

        $roleCounts = Role::withCount(['users'])->get();
        // dd($roleCounts);
        return view('dashboard.userDashboard', [
            'user' => $request->user(),
            'orders' => $orders,
            'products' => $products,
            'roleCounts' => $roleCounts
        ]);
    }
}
