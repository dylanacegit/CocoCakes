@extends('layouts.site')

@section('title', 'Order | Coco Cakes')

@section('content')
    <section class="page-section">
        <div class="container order-container">
            <p class="eyebrow">Cake Request</p>
            <h1>Plan your pet’s special treat.</h1>
            <p class="page-intro">
                Send us the details of your celebration, and Coco Cakes will review your request.
            </p>

            @if (session('success'))
                <div class="success-message" role="alert">{{ session('success') }}</div>
            @endif

            <form class="order-form" action="{{ route('order.store') }}" method="POST">
                @csrf

                <div class="form-grid">
                    <div>
                        <label for="customer_name">Your name</label>
                        <input id="customer_name" name="customer_name" type="text"
                            value="{{ old('customer_name', auth()->user()->name) }}" required>
                        @error('customer_name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email">Email address</label>
                        <input id="email" name="email" type="email"
                            value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-field-wide">
                        <label for="pet_id">Pet</label>
                        <select id="pet_id" name="pet_id" required>
                            <option value="">Choose your pet</option>
                            // Loop through the pets and create an option for each one
                            @foreach ($pets as $pet)
                                <option value="{{ $pet->id }}" @selected((string) old('pet_id') === (string) $pet->id)>
                                    {{ $pet->name }} — {{ $pet->type }}, {{ $pet->breed }}
                                </option>
                            @endforeach
                        </select>
                        @error('pet_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                        @if ($pets->isEmpty())
                            <p class="form-help">
                                <a href="{{ route('customer.pets.create') }}">Add a pet before placing an order.</a>
                            </p>
                        @endif
                    </div>

                    <div class="form-field-wide">
                        <label for="product_id">Cake selection</label>
                        <select id="product_id" name="product_id" required>
                            <option value="">Choose an option</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" @selected((string) old('product_id', request('product')) === (string) $product->id)>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-field-wide">
                        <label for="pickup_date">Preferred pickup date</label>
                        <input id="pickup_date" name="pickup_date" type="date" value="{{ old('pickup_date') }}"
                            min="{{ now()->toDateString() }}" required>
                        @error('pickup_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-field-wide">
                        <label for="special_instructions">Special instructions</label>
                        <textarea id="special_instructions" name="special_instructions" rows="5"
                            placeholder="Tell us about the celebration or your preferred design.">{{ old('special_instructions') }}</textarea>
                        @error('special_instructions')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button class="btn order-button order-submit" type="submit">Send Cake Request</button>
            </form>
        </div>
    </section>
@endsection
