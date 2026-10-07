@extends('layouts.site')

@section('title', 'Product Trash | Coco Cakes')

@section('content')
    <section class="page-section">
        <div class="container admin-container">
            <div class="admin-page-header">
                <div>
                    <p class="eyebrow">Admin</p>
                    <h1 class="section-title mb-0">Product Trash</h1>
                </div>
                <a class="admin-toolbar-button" href="{{ route('admin.products.index') }}">
                    Back to Products
                </a>
            </div>

            @if (session('success'))
                <div class="success-message" role="alert">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="error-message" role="alert">{{ session('error') }}</div>
            @endif

            <div class="admin-card table-responsive">
                <table class="table admin-table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Added by</th>
                            <th>Deleted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="fw-semibold">{{ $product->name }}</td>
                                <td>{{ $product->user->name }}</td>
                                <td>{{ $product->deleted_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="admin-row-actions">
                                        <form class="admin-action-form" method="POST"
                                            action="{{ route('admin.products.restore', $product) }}">
                                            @csrf
                                            @method('PATCH')

                                            <button class="admin-action-button admin-action-restore" type="submit">
                                                Restore
                                            </button>
                                        </form>

                                        <form class="admin-action-form" method="POST"
                                            action="{{ route('admin.products.force-delete', $product) }}"
                                            onsubmit="return confirm('Permanently delete this product? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="admin-action-button admin-action-permanent" type="submit">
                                                Delete Permanently
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="admin-empty" colspan="4">The product trash is empty.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($products->hasPages())
                <div class="menu-pagination">
                    {{ $products->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
