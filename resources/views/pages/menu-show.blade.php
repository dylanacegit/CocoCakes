@extends('layouts.site')

@section('title', $product->name . ' | Coco Cakes')

@section('content')
    <section class="page-section">
        <div class="container">
            <a class="back-link" href="{{ route('menu') }}">
                ← Back to Menu
            </a>

            <div class="row g-4 align-items-center">
                <div class="col-md-6">
                    <img src="{{ asset('images/' . $product->image) }}"
                        class="img-fluid rounded-4 shadow-sm cake-detail-image"
                        alt="{{ $product->name }}">
                </div>

                <div class="col-md-6">
                    <p class="eyebrow">Coco Cakes Menu</p>

                    <h1>{{ $product->name }}</h1>

                    <p class="page-intro">
                        {{ $product->description }}
                    </p>

                    <h2 class="h4 mt-4">Available flavors</h2>

                    <ul class="list-group list-group-flush mb-4">
                        @forelse ($product->options['flavors'] ?? [] as $flavor)
                            <li class="list-group-item bg-transparent">
                                {{ $flavor }}
                            </li>
                        @empty
                            <li class="list-group-item bg-transparent">Ask us about available flavors.</li>
                        @endforelse
                    </ul>

                    <h2 class="h4 mt-4">Available sizes</h2>

                    <ul class="list-group list-group-flush mb-4">
                        @foreach ($product->options['sizes'] ?? [] as $size)
                            <li class="list-group-item bg-transparent">{{ $size }}</li>
                        @endforeach
                    </ul>

                    <a class="btn order-button" 
                        href="{{ route('order.create', ['product' => $product->id]) }}">
                        Request This Cake
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
