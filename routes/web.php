<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
 Public Routes
*/

Route::get('/', [PageController::class, 'home'])
    ->name('home');

Route::get('/menu', [PageController::class, 'menu'])
    ->name('menu');

Route::get('/menu/{product:slug}', [PageController::class, 'show'])
    ->name('menu.show');

Route::get('/about', [PageController::class, 'about'])
    ->name('about');

Route::get('/contact', [PageController::class, 'contact'])
    ->name('contact');

/*
 Authenticated User Routes
*/

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return request()->user()->role === 'admin'
            ? to_route('admin.products.index')
            : to_route('customer.requests');
    })->name('dashboard');

    Route::get('/order', [OrderController::class, 'create'])
        ->name('order.create');

    Route::post('/order', [OrderController::class, 'store'])
        ->name('order.store');

    Route::get('/my-cake-requests', [CustomerController::class, 'requests'])
        ->name('customer.requests');

    Route::get('/saved-cakes', [CustomerController::class, 'favorites'])
        ->name('customer.favorites');

    Route::get('/my-pets', [PetController::class, 'index'])
        ->name('customer.pets');

    Route::get('/my-pets/create', [PetController::class, 'create'])
        ->name('customer.pets.create');

    Route::post('/my-pets', [PetController::class, 'store'])
        ->name('customer.pets.store');

    Route::get('/my-pets/{pet}/edit', [PetController::class, 'edit'])
        ->name('customer.pets.edit');

    Route::put('/my-pets/{pet}', [PetController::class, 'update'])
        ->name('customer.pets.update');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
 Administrator Routes
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('products', ProductController::class)
            ->only(['index', 'create', 'store', 'edit', 'update']);

        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');
    });

require __DIR__ . '/auth.php';
