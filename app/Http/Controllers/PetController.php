<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PetController extends Controller
{
    public function index(Request $request): View
    {
        return view('customer.pets', [
            'pets' => $request->user()->pets()->orderBy('name')->paginate(5),
        ]);
    }

    // Show the form for creating a new pet
    public function create(): View
    {
        return view('customer.create-pet');
    }

    // Store a newly created pet in storage
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'max:100'],
            'breed' => ['required', 'string', 'max:100'],
            'age' => ['required', 'integer', 'min:0', 'max:50'],
        ]);

        // Create a new pet associated with the authenticated user
        $request->user()->pets()->create($validated);

        return to_route('customer.pets')
            ->with('success', 'Pet added successfully.');
    }

    // Show the form for editing the specified pet
    public function edit(Pet $pet): View
    {
        Gate::authorize('update', $pet);

        return view('customer.edit-pet', [
            'pet' => $pet,
        ]);
    }

    // Update the specified pet in storage
    public function update(Request $request, Pet $pet): RedirectResponse
    {
        Gate::authorize('update', $pet);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'max:100'],
            'breed' => ['required', 'string', 'max:100'],
            'age' => ['required', 'integer', 'min:0', 'max:50'],
        ]);

        $pet->update($validated);

        return to_route('customer.pets')
            ->with('success', 'Pet updated successfully.');
    }
}
