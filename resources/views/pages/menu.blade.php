@extends('layouts.site')

@section('title', 'Menu | Coco Cakes')

@section('content')
    <section class="page-section menu-page">
        <div class="container">
            <header class="menu-header">
                <div class="menu-header-copy">
                    <p class="eyebrow">Coco Cakes Menu</p>

                    <h1>Treats made for happy celebrations.</h1>

                    <p class="page-intro mb-0">
                        Browse our pet-friendly cake and treat options. Each order can be
                        personalized for your pet and their special occasion.
                    </p>
                </div>

                <form class="menu-search-form" action="{{ route('menu') }}" method="GET" role="search">
                    <label class="form-label" for="menu-search">Search the menu</label>

                    <div class="input-group">
                        <input id="menu-search" class="form-control menu-search-input" name="search"
                            type="search" value="{{ $search }}" placeholder="Search cakes by name…"
                            autocomplete="off">

                        <button class="btn menu-search-button" type="submit">
                            <svg aria-hidden="true" viewBox="0 0 24 24">
                                <path d="m20.7 19.3-4.2-4.2a7.5 7.5 0 1 0-1.4 1.4l4.2 4.2 1.4-1.4ZM5 10.5a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0Z"/>
                            </svg>
                            Search
                        </button>
                    </div>
                </form>
            </header>

            <div class="menu-results-bar">
                <p class="menu-results-count">
                    @if ($search !== '')
                        {{ $products->total() }} {{ $products->total() === 1 ? 'result' : 'results' }}
                        for <strong>“{{ $search }}”</strong>
                    @else
                        {{ $products->total() }} {{ $products->total() === 1 ? 'treat' : 'treats' }} available
                    @endif
                </p>

                @if ($search !== '')
                    <a class="menu-clear-search" href="{{ route('menu') }}">Clear search</a>
                @endif
            </div>

            <div class="row g-4">
                @forelse ($products as $product)
                    <div class="col-sm-6 col-lg-4">
                        <article class="card menu-card h-100">
                            <div class="menu-card-media">
                                @if ($product->image)
                                    <img src="{{ asset('images/' . $product->image) }}"
                                        class="card-img-top menu-card-image"
                                        alt="{{ $product->name }}">
                                @else
                                    <div class="menu-card-placeholder" role="img"
                                        aria-label="Coco Cakes placeholder image">
                                        <span>Coco Cakes</span>
                                    </div>
                                @endif

                                <span class="menu-card-badge">Made for pets</span>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h2 class="card-title">{{ $product->name }}</h2>

                                <p class="card-text">
                                    {{ $product->description }}
                                </p>

                                <a class="btn menu-card-button mt-auto"
                                    href="{{ route('menu.show', ['product' => $product->slug]) }}">
                                    View cake
                                    <svg aria-hidden="true" viewBox="0 0 24 24">
                                        <path d="m13.2 5.8 6.2 6.2-6.2 6.2-1.4-1.4 3.8-3.8H4.5v-2h11.1l-3.8-3.8 1.4-1.4Z"/>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="menu-empty-state">
                            <span class="menu-empty-icon" aria-hidden="true">♡</span>
                            <h2>No cakes found</h2>

                            @if ($search !== '')
                                <p>
                                    We couldn’t find a product matching “{{ $search }}”. Try another name or
                                    browse the full menu.
                                </p>
                                <a class="btn menu-card-button" href="{{ route('menu') }}">View all cakes</a>
                            @else
                                <p>Our menu is being prepared. Please check back soon or contact us for help.</p>
                                <a class="btn menu-card-button" href="{{ route('contact') }}">Contact Coco Cakes</a>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($products->hasPages())
                <div class="menu-pagination">
                    {{ $products->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
