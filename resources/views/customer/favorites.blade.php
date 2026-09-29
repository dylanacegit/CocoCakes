<x-app-layout>
    <x-slot name="header">
        <h1 class="h4 mb-0">Saved Cakes</h1>
    </x-slot>

    <section class="container py-5">
        <p class="eyebrow">Your Favorites</p>
        <h2 class="mb-4">Saved Coco Cakes selections</h2>

        <div class="row g-4">
            @forelse ($favorites as $favorite)
                <div class="col-md-6 col-lg-4">
                    <article class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title h5">
                                {{ $favorite }}
                            </h3>

                            <p class="card-text">
                                You saved this cake for a future pet celebration.
                            </p>

                            <a class="btn order-button" href="{{ route('menu') }}">
                                View Menu
                            </a>
                        </div>
                    </article>
                </div>
            @empty
                <p>You have no saved cakes yet.</p>
            @endforelse
        </div>
    </section>
</x-app-layout>