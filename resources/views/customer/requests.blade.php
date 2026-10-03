@extends('layouts.site')

@section('title', 'My Cake Requests | Coco Cakes')

@section('content')
    <section class="page-section">
        <div class="container admin-container">
            <div class="admin-page-header">
                <div>
                    <p class="eyebrow">Cake Requests</p>
                    <h1 class="section-title mb-0">My Cake Requests</h1>
                </div>
            </div>

            @if (session('success'))
                <div class="success-message" role="alert">{{ session('success') }}</div>
            @endif

            <div class="admin-card table-responsive">
                <table class="table admin-table align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Pet</th>
                            <th>Flavor</th>
                            <th>Size</th>
                            <th>Pickup date</th>
                            <th>Instructions</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td class="fw-semibold">{{ $order->product->name }}</td>
                                <td>{{ $order->pet?->name ?? $order->pet_name }}</td>
                                <td>{{ $order->flavor ?: '—' }}</td>
                                <td>{{ $order->size ?: '—' }}</td>
                                <td>{{ $order->pickup_date->format('M d, Y') }}</td>
                                <td>{{ $order->special_instructions ?: '—' }}</td>
                                <td><span class="status-badge">{{ ucfirst($order->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td class="admin-empty" colspan="7">You have no cake requests yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
