<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with(['user', 'product', 'pet'])
            ->latest()
            ->get();

        return view('admin.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function create(Request $request): View
    {
        return view('orders.create', [
            'products' => Product::orderBy('name')->get(),
            'pets' => $request->user()->pets()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'customer_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'pet_id' => [
                'required',
                Rule::exists('pets', 'id')->where(
                    fn (Builder $query): Builder => $query->where('user_id', $request->user()->id)
                ),
            ],
            'pickup_date' => ['required', 'date', 'after_or_equal:today'],
            'special_instructions' => ['nullable', 'string', 'max:500'],
        ]);

        $pet = $request->user()->pets()->findOrFail($validated['pet_id']);
        $validated['pet_name'] = $pet->name;
        $validated['pet_type'] = $pet->type;

        $request->user()
            ->orders()
            ->create($validated);

        return to_route('customer.requests')
            ->with('success', 'Your cake request has been submitted.');
    }
}
