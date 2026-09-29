@extends('layouts.site')

@section('title', 'Add Product | Coco Cakes')

@section('content')
    <section class="page-section">
        <div class="container order-container">
            <p class="eyebrow">Admin</p>
            <h1 class="section-title">Add Product</h1>

            <form class="order-form" method="POST" action="{{ route('admin.products.store') }}">
                @csrf

                <div class="form-grid">
                    <div class="form-field-wide">
                        <label for="name">Product name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-field-wide">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-field-wide">
                        <label for="image">Image filename</label>
                        <input id="image" name="image" type="text" value="{{ old('image') }}"
                            placeholder="menu-custom-pet-cake.jpg">
                        @error('image')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-field-wide">
                        <label>Options</label>
                        <div class="option-fields">
                            @foreach (old('options', ['', '', '']) as $index => $option)
                                <input name="options[]" type="text" value="{{ $option }}"
                                    aria-label="Product option {{ $index + 1 }}">
                            @endforeach
                        </div>
                        @error('options')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                        @error('options.*')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="admin-form-actions">
                    <button class="btn order-button" type="submit">Add Product</button>
                    <a class="admin-secondary-link" href="{{ route('admin.products.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection
