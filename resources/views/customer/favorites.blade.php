@extends('layouts.site')

@section('title', 'Saved Cakes | Coco Cakes')

@section('content')
    <section class="page-section">
        <div class="container admin-container">
            <div class="admin-page-header">
                <div>
                    <p class="eyebrow">Your Favorites</p>
                    <h1 class="section-title mb-0">Saved Cakes</h1>
                </div>
            </div>

            <div class="row g-4">
                @forelse ($favorites as $favorite)
                    <div class="col-md-6 col-lg-4">
                        <article class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="card-title h5">{{ $favorite }}</h2>
                                <p class="card-text">You saved this cake for a future pet celebration.</p>
                                <a class="btn order-button" href="{{ route('menu') }}">View Menu</a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="admin-card admin-empty">You have no saved cakes yet.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
