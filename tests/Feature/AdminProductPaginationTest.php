<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminProductPaginationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_product_list_paginates_five_products_at_a_time(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        foreach (range(1, 6) as $number) {
            $admin->products()->create([
                'name' => sprintf('Cake %02d', $number),
                'slug' => sprintf('cake-%02d', $number),
                'description' => 'A custom cake made for a special pet celebration.',
                'options' => [
                    'flavors' => ['Vanilla'],
                    'sizes' => ['4-inch', '6-inch'],
                ],
            ]);
        }

        $this->actingAs($admin)
            ->get(route('admin.products.index'))
            ->assertSee('page=2', false)
            ->assertViewHas(
                'products',
                fn (LengthAwarePaginator $products): bool => $products->total() === 6
                    && $products->count() === 5
                    && $products->perPage() === 5
            );
    }
}
