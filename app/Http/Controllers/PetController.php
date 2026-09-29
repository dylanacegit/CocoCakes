<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PetController extends Controller
{
    public function index(Request $request): View
    {
        return view('customer.pets', [
            'pets' => $request->user()->pets()->orderBy('name')->get(),
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
}
