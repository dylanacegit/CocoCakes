<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home');
    }

    public function menu(Request $request): View
    {
        $searchQuery = $request->query('search', '');
        $search = is_string($searchQuery)
            ? str($searchQuery)->trim()->limit(100, '')->toString()
            : '';

        return view('pages.menu', [
            'products' => Product::query()
                ->when(
                    $search !== '',
                    fn(Builder $query): Builder => $query->whereLike('name', "%{$search}%")
                )
                ->orderBy('name')
                ->paginate(3)
                ->appends($search !== '' ? ['search' => $search] : []),
            'search' => $search,
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
        return view('pages.about');
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
