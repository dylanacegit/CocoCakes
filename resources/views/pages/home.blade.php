@extends('layouts.site')

@section('title', 'Home | Coco Cakes')

@section('content')
    <section id="cocoCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#cocoCarousel" data-bs-slide-to="0"
                class="active" aria-current="true" aria-label="Slide 1"></button>

            <button type="button" data-bs-target="#cocoCarousel" data-bs-slide-to="1"
                aria-label="Slide 2"></button>

            <button type="button" data-bs-target="#cocoCarousel" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="4000">
                <img src="{{ asset('images/coco-slide-1.jpg') }}"
                    class="d-block w-100 carousel-image"
                    alt="Coco Cakes pet birthday cake">

                <div class="carousel-caption">
                    <h1>Celebrate every wag with Coco Cakes.</h1>
                    <p>Pet-friendly treats for birthdays and special days.</p>
                </div>
            </div>

            <div class="carousel-item" data-bs-interval="4000">
                <img src="{{ asset('images/coco-slide-2.jpg') }}"
                    class="d-block w-100 carousel-image"
                    alt="Coco Cakes celebration cake">

                <div class="carousel-caption">
                    <h2>Made for your pet’s special day.</h2>
                    <p>Celebrate birthdays, gotcha days, and happy moments.</p>
                </div>
            </div>

            <div class="carousel-item" data-bs-interval="4000">
                <img src="{{ asset('images/coco-slide-3.jpg') }}"
                    class="d-block w-100 carousel-image"
                    alt="Coco Cakes pet treats">

                <div class="carousel-caption">
                    <h2>Baked with love for every wag.</h2>

                    <a class="btn order-button" href="{{ route('order.create') }}">
                        Place an Order
                    </a>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button"
            data-bs-target="#cocoCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next" type="button"
            data-bs-target="#cocoCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </section>

    <section class="container py-5 text-center">
        <p class="eyebrow">Made for pet celebrations</p>

        <h2 class="display-6 fw-bold">Sweet moments for your furry family.</h2>

        <p class="page-intro mx-auto">
            Coco Cakes creates celebration cakes and treats for pets and the
            people who love them.
        </p>

        <a class="btn order-button" href="{{ route('menu') }}">
            Explore the Menu
        </a>
    </section>
@endsection