@extends('layouts.site')

@section('title', 'My Pets | Coco Cakes')

@section('content')
    <section class="page-section">
        <div class="container admin-container">
            <div class="admin-page-header">
                <div>
                    <p class="eyebrow">Pet Profiles</p>
                    <h1 class="section-title mb-0">My Pets</h1>
                </div>
                <a class="order-button" href="{{ route('customer.pets.create') }}">Add Pet</a>
            </div>

            @if (session('success'))
                <div class="success-message" role="alert">{{ session('success') }}</div>
            @endif

            <div class="admin-card table-responsive">
                <table class="table admin-table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Breed</th>
                            <th>Age</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pets as $pet)
                            <tr>
                                <td class="fw-semibold">{{ $pet->name }}</td>
                                <td>{{ $pet->type }}</td>
                                <td>{{ $pet->breed }}</td>
                                <td>{{ $pet->age }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="admin-empty" colspan="4">You have not added a pet yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
