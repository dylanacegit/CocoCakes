<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ProductOptionsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_can_create_a_product_with_flavors_and_sizes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'Celebration Cake',
                'description' => 'A celebration cake for a special pet.',
                'flavors' => ['Vanilla', 'Chocolate', ''],
                'sizes' => ['4-inch', '6-inch'],
            ])
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'user_id' => $admin->id,
            'name' => 'Celebration Cake',
            'slug' => 'celebration-cake',
            'options' => json_encode([
                'flavors' => ['Vanilla', 'Chocolate'],
                'sizes' => ['4-inch', '6-inch'],
            ]),
        ]);
    }

    public function test_product_requires_a_flavor_and_valid_cake_size(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'Celebration Cake',
                'description' => 'A celebration cake for a special pet.',
                'flavors' => ['', '', ''],
                'sizes' => ['8-inch'],
            ])
            ->assertSessionHasErrors(['flavors.0', 'sizes.0']);
    }

    public function test_both_cake_sizes_are_required(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'Celebration Cake',
                'description' => 'A celebration cake for a special pet.',
                'flavors' => ['Vanilla'],
                'sizes' => ['4-inch'],
            ])
            ->assertSessionHasErrors('sizes');
    }
}
