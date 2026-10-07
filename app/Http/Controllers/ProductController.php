<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('user')
            ->latest()
            ->paginate(5);

        return view('admin.products.index', [
            'products' => $products,
        ]);
    }

    // Show the form for creating a new product
    public function create(): View
    {
        return view('admin.products.create');
    }

    // Store a newly created product in storage
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'image' => ['nullable', 'string', 'max:255'],
            'flavors' => ['required', 'array'],
            'flavors.0' => ['required', 'string', 'max:100'],
            'flavors.*' => ['nullable', 'string', 'max:100'],
            'sizes' => ['required', 'array', 'size:2'],
            'sizes.*' => ['required', 'distinct', Rule::in(['4-inch', '6-inch'])],
        ]);

        // Generate a unique slug for the product
        $baseSlug = Str::slug($validated['name']) ?: 'product';
        $slug = $baseSlug;
        $suffix = 2;

        while (Product::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        $validated['slug'] = $slug;

        $validated['options'] = [
            'flavors' => array_values(array_filter($validated['flavors'])),
            'sizes' => array_values($validated['sizes']),
        ];

        unset($validated['flavors'], $validated['sizes']);

        $request->user()
            ->products()
            ->create($validated);

        // Redirect to the product index page with a success message
        return to_route('admin.products.index')
            ->with('success', 'Product added successfully.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'image' => ['nullable', 'string', 'max:255'],
            'flavors' => ['required', 'array'],
            'flavors.0' => ['required', 'string', 'max:100'],
            'flavors.*' => ['nullable', 'string', 'max:100'],
            'sizes' => ['required', 'array', 'size:2'],
            'sizes.*' => [
                'required',
                'distinct',
                Rule::in(['4-inch', '6-inch']),
            ],
        ]);

        $validated['options'] = [
            'flavors' => array_values(
                array_filter($validated['flavors'])
            ),
            'sizes' => array_values($validated['sizes']),
        ];

        unset($validated['flavors'], $validated['sizes']);

        $product->update($validated);

        return to_route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return to_route('admin.products.index')
            ->with('success', 'Product moved to trash successfully.');
    }

    public function trash(): View
    {
        $products = Product::onlyTrashed()
            ->with('user')
            ->latest('deleted_at')
            ->paginate(5);

        return view('admin.products.trash', [
            'products' => $products,
        ]);
    }

    public function restore(Product $product): RedirectResponse
    {
        abort_unless($product->trashed(), 404);

        $product->restore();

        return to_route('admin.products.trash')
            ->with('success', 'Product restored successfully.');
    }

    public function forceDelete(Product $product): RedirectResponse
    {
        abort_unless($product->trashed(), 404);

        if ($product->orders()->exists()) {
            return to_route('admin.products.trash')
                ->with('error', 'This product cannot be permanently deleted because it has cake requests.');
        }

        $product->forceDelete();

        return to_route('admin.products.trash')
            ->with('success', 'Product permanently deleted.');
    }
}
