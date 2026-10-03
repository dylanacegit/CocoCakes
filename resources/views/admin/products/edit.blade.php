@extends('layouts.site')

@section('title', 'Edit Product | Coco Cakes')

@section('content')
    <section class="page-section">
        <div class="container order-container">
            <p class="eyebrow">Admin</p>
            <h1 class="section-title">Edit Product</h1>

            <form class="order-form"
                method="POST"
                action="{{ route('admin.products.update', $product) }}">

                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-field-wide">
                        <label for="name">Product name</label>

                        <input id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', $product->name) }}"
                            required>

                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-field-wide">
                        <label for="description">Description</label>

                        <textarea id="description"
                            name="description"
                            rows="5"
                            required>{{ old('description', $product->description) }}</textarea>

                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-field-wide">
                        <label for="image">Image filename</label>

                        <input id="image"
                            name="image"
                            type="text"
                            value="{{ old('image', $product->image) }}">

                        @error('image')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    @php
                        $flavors = old(
                            'flavors',
                            $product->options['flavors'] ?? []
                        );

                        $flavors = array_pad($flavors, 3, '');
                    @endphp

                    <div class="form-field-wide">
                        <label>Flavor options</label>

                        <div class="option-fields">
                            @foreach ($flavors as $index => $flavor)
                                <input name="flavors[]"
                                    type="text"
                                    value="{{ $flavor }}"
                                    placeholder="{{ $index === 0
                                        ? 'Example: Vanilla'
                                        : 'Additional flavor (optional)' }}"
                                    aria-label="Flavor option {{ $index + 1 }}"
                                    @required($index === 0)>
                            @endforeach
                        </div>

                        @error('flavors')
                            <p class="form-error">{{ $message }}</p>
                        @enderror

                        @error('flavors.*')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    @php
                        $selectedSizes = old(
                            'sizes',
                            $product->options['sizes'] ?? []
                        );
                    @endphp

                    <div class="form-field-wide">
                        <label>Available sizes</label>

                        <div class="option-fields option-checkboxes">
                            @foreach (['4-inch', '6-inch'] as $size)
                                <label>
                                    <input name="sizes[]"
                                        type="checkbox"
                                        value="{{ $size }}"
                                        @checked(in_array($size, $selectedSizes, true))>

                                    {{ $size }}
                                </label>
                            @endforeach
                        </div>

                        @error('sizes')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="admin-form-actions">
                    <button class="btn order-button" type="submit">
                        Update Product
                    </button>

                    <a class="admin-secondary-link"
                        href="{{ route('admin.products.index') }}">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </section>
@endsection