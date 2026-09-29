@extends('layouts.site')

@section('title', 'Products | Coco Cakes')

@section('content')
    <section class="page-section">
        <div class="container admin-container">
            <div class="admin-page-header">
                <div>
                    <p class="eyebrow">Admin</p>
                    <h1 class="section-title mb-0">Products</h1>
                </div>
                <a class="order-button" href="{{ route('admin.products.create') }}">Add Product</a>
            </div>

            @if (session('success'))
                <div class="success-message" role="alert">{{ session('success') }}</div>
            @endif

            <div class="admin-card table-responsive">
                <table class="table admin-table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Added by</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="fw-semibold">{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->user->name }}</td>
                                <td>{{ $product->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="admin-empty" colspan="4">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
