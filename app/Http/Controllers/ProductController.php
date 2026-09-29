<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('user')
            ->latest()
            ->get();

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
            'options' => ['nullable', 'array'],
            'options.*' => ['nullable', 'string', 'max:255'],
        ]);

        // Generate a unique slug for the product
        $baseSlug = Str::slug($validated['name']) ?: 'product';
        $slug = $baseSlug;
        $suffix = 2;

        while (Product::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $suffix;
            $suffix++;
        }

        $validated['slug'] = $slug;

        $validated['options'] = array_values(
            array_filter($validated['options'] ?? [])
        );

        $request->user()
            ->products()
            ->create($validated);

        // Redirect to the product index page with a success message
        return to_route('admin.products.index')
            ->with('success', 'Product added successfully.');
    }
}
