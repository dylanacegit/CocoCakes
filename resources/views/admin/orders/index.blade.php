@extends('layouts.site')

@section('title', 'Orders | Coco Cakes')

@section('content')
    <section class="page-section">
        <div class="container admin-container">
            <div class="admin-page-header">
                <div>
                    <p class="eyebrow">Admin</p>
                    <h1 class="section-title mb-0">Orders</h1>
                </div>
            </div>

            <div class="admin-card table-responsive">
                <table class="table admin-table align-middle">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Pet</th>
                            <th>Pickup date</th>
                            <th>Instructions</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td class="fw-semibold">{{ $order->user->name }}</td>
                                <td>{{ $order->product->name }}</td>
                                <td>
                                    {{ $order->pet?->name ?? $order->pet_name }}
                                    — {{ $order->pet?->type ?? $order->pet_type }}
                                </td>
                                <td>{{ $order->pickup_date->format('M d, Y') }}</td>
                                <td>{{ $order->special_instructions }}</td>
                                <td><span class="status-badge">{{ ucfirst($order->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td class="admin-empty" colspan="6">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
