<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function requests(Request $request): View
    {
        $orders = $request->user()
            ->orders()
            ->with(['product', 'pet'])
            ->latest()
            ->get();

        return view('customer.requests', [
            'orders' => $orders,
        ]);
    }

    public function favorites(): View
    {
        $favorites = [
            'Custom Pet Cake',
            'Birthday Cake',
            'Number Cake',
        ];

        return view('customer.favorites', [
            'favorites' => $favorites,
        ]);
    }
}
