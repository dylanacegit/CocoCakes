<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
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
        $products = Product::orderBy('name')->get();

        return view('orders.create', [
            'products' => $products,
            'productOptions' => $products->mapWithKeys(
                fn (Product $product): array => [(string) $product->id => $product->options ?? []]
            ),
            'pets' => $request->user()->pets()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                Rule::exists('products', 'id')->whereNull('deleted_at'),
            ],
            'email' => ['required', 'email', 'max:255'],
            'pet_id' => [
                'required',
                Rule::exists('pets', 'id')->where(
                    fn (Builder $query): Builder => $query->where('user_id', $request->user()->id)
                ),
            ],
            'flavor' => ['required', 'string', 'max:100'],
            'size' => ['required', 'string', Rule::in(['4-inch', '6-inch'])],
            'pickup_date' => ['required', 'date', 'after_or_equal:today'],
            'special_instructions' => ['nullable', 'string', 'max:500'],
        ]);

        $pet = $request->user()->pets()->findOrFail($validated['pet_id']);
        $product = Product::findOrFail($validated['product_id']);
        $options = $product->options ?? [];

        if (! in_array($validated['flavor'], $options['flavors'] ?? [], true)) {
            throw ValidationException::withMessages([
                'flavor' => 'Choose a flavor available for the selected product.',
            ]);
        }

        if (! in_array($validated['size'], $options['sizes'] ?? [], true)) {
            throw ValidationException::withMessages([
                'size' => 'Choose a size available for the selected product.',
            ]);
        }

        $validated['customer_name'] = $request->user()->name;
        $validated['pet_name'] = $pet->name;
        $validated['pet_type'] = $pet->type;

        $request->user()
            ->orders()
            ->create($validated);

        return to_route('customer.requests')
            ->with('success', 'Your cake request has been submitted.');
    }
}
