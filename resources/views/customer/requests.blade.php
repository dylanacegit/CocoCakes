<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Cake Requests
        </h2>
    </x-slot>

    <div class="py-12">
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="mt-4 table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Pet</th>
                <th>Pickup Date</th>
                <th>Instructions</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ $order->pet?->name ?? $order->pet_name }}</td>
                    <td>{{ $order->pickup_date->format('M d, Y') }}</td>
                    <td>{{ $order->special_instructions }}</td>
                    <td>{{ $order->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">You have no cake requests yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>    </div>
</x-app-layout>
