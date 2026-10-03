<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class MenuPageTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_menu_paginates_products_six_at_a_time(): void
    {
        $user = User::factory()->create();

        foreach (range(1, 7) as $number) {
            $this->createProduct($user, sprintf('Cake %02d', $number));
        }

        $response = $this->get(route('menu'));

        $response
            ->assertSee('Cake 01')
            ->assertSee('Cake 06')
            ->assertDontSee('Cake 07')
            ->assertSee('page=2', false)
            ->assertViewHas(
                'products',
                fn (LengthAwarePaginator $products): bool => $products->total() === 7
                    && $products->count() === 6
            );
    }

    public function test_search_filters_products_by_name_and_persists_in_pagination_links(): void
    {
        $user = User::factory()->create();

        foreach (range(1, 7) as $number) {
            $this->createProduct($user, sprintf('Custom Cake %02d', $number));
        }

        $this->createProduct($user, 'Birthday Treat Box');

        $response = $this->get(route('menu', ['search' => 'Custom']));

        $response
            ->assertSee('Custom Cake 01')
            ->assertDontSee('Birthday Treat Box')
            ->assertSee('search=Custom&amp;page=2', false)
            ->assertViewHas('search', 'Custom')
            ->assertViewHas(
                'products',
                fn (LengthAwarePaginator $products): bool => $products->total() === 7
            );
    }

    public function test_menu_displays_an_empty_state_for_a_search_without_matches(): void
    {
        $user = User::factory()->create();
        $this->createProduct($user, 'Birthday Cake');

        $this->get(route('menu', ['search' => 'Cupcake']))
            ->assertSee('No cakes found')
            ->assertSee('Cupcake')
            ->assertDontSee('Birthday Cake');
    }

    private function createProduct(User $user, string $name): Product
    {
        return $user->products()->create([
            'name' => $name,
            'slug' => str($name)->slug()->toString(),
            'description' => "A custom {$name} made for a special pet celebration.",
            'options' => [
                'flavors' => ['Vanilla'],
                'sizes' => ['4-inch', '6-inch'],
            ],
        ]);
    }
}
