<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Product;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home');
    }

    public function menu(): View
    {
        return view('pages.menu', [
            'products' => Product::orderBy('name')->get(),
        ]);
    }

    public function show(Product $product): View
    {
        return view('pages.menu-show', [
            'product' => $product,
        ]);
    }

    public function about(): View
    {
        return view('pages.about',);
    }

    public function contact(): View
    {
        return view('pages.contact');
    }
    public function user(): View
    {
        return view('pages.user', [
            'users' => Product::orderBy('name')->get(),
        ]);
    }
}
