@extends('layouts.site')

@section('title', 'Menu | Coco Cakes')

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="text-center mb-5">
                <p class="eyebrow">Coco Cakes Menu</p>

                <h1>Treats made for happy celebrations.</h1>

                <p class="page-intro mx-auto">
                    Browse our pet-friendly cake and treat options. Each order can be
                    personalized for your pet and their special occasion.
                </p>
            </div>

            <div class="row g-4">
                @foreach ($products as $product)
                    <div class="col-md-6 col-lg-3">
                        <article class="card menu-card h-100 border-0 shadow-sm">
                            <img src="{{ asset('images/' . $product['image']) }}"
                                class="card-img-top menu-card-image"
                                alt="{{ $product['name'] }}">

                            <div class="card-body d-flex flex-column">
                                <h2 class="card-title h4">{{ $product['name'] }}</h2>

                                <p class="card-text">
                                    {{ $product['description'] }}
                                </p>

                                <a class="btn order-button mt-auto"
                                    href="{{ route('menu.show', $product) }}">
                                    View options
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection