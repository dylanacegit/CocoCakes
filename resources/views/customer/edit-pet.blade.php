@extends('layouts.site')

@section('title', 'Edit Pet | Coco Cakes')

@section('content')
    <section class="page-section">
        <div class="container order-container">
            <p class="eyebrow">Pet Profiles</p>
            <h1 class="section-title">Edit Pet</h1>

            <form class="order-form"
                method="POST"
                action="{{ route('customer.pets.update', $pet) }}">

                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div>
                        <label for="name">Pet name</label>
                        <input id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', $pet->name) }}"
                            required>

                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type">Pet type</label>

                        <select id="type" name="type" required>
                            <option value="">Choose a type</option>

                            @foreach (['Dog', 'Cat', 'Rabbit', 'Other'] as $type)
                                <option value="{{ $type }}"
                                    @selected(old('type', $pet->type) === $type)>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>

                        @error('type')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="breed">Breed</label>
                        <input id="breed"
                            name="breed"
                            type="text"
                            value="{{ old('breed', $pet->breed) }}"
                            required>

                        @error('breed')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="age">Age</label>
                        <input id="age"
                            name="age"
                            type="number"
                            min="0"
                            max="50"
                            value="{{ old('age', $pet->age) }}"
                            required>

                        @error('age')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="admin-form-actions">
                    <button class="btn order-button" type="submit">
                        Update Pet
                    </button>

                    <a class="admin-secondary-link"
                        href="{{ route('customer.pets') }}">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </section>
@endsection