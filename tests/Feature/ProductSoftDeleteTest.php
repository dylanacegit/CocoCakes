<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ProductSoftDeleteTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_can_move_a_product_to_trash(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $product = $this->createProduct($admin, 'Birthday Cake');

        $this->actingAs($admin)
            ->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('success');

        $this->assertSoftDeleted($product);
    }

    public function test_soft_deleted_product_disappears_from_menu_and_individual_view(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(name: 'Birthday Cake');
        $product->delete();

        $this->get(route('menu'))
            ->assertDontSee('Birthday Cake');

        $this->actingAs($user)
            ->get(route('menu.show', ['product' => $product->slug]))
            ->assertNotFound();
    }

    public function test_product_trash_displays_only_soft_deleted_products(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $activeProduct = $this->createProduct($admin, 'Active Cake');
        $deletedProduct = $this->createProduct($admin, 'Deleted Cake');
        $deletedProduct->delete();

        $this->actingAs($admin)
            ->get(route('admin.products.trash'))
            ->assertSee($deletedProduct->name)
            ->assertDontSee($activeProduct->name);
    }

    public function test_admin_can_restore_a_product_to_the_menu(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $product = $this->createProduct($admin, 'Birthday Cake');
        $product->delete();

        $this->actingAs($admin)
            ->patch(route('admin.products.restore', $product))
            ->assertRedirect(route('admin.products.trash'))
            ->assertSessionHas('success');

        $this->assertNotSoftDeleted($product);

        $this->get(route('menu'))
            ->assertSee('Birthday Cake');
    }

    public function test_admin_can_permanently_delete_a_trashed_product(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $product = $this->createProduct($admin, 'Birthday Cake');
        $product->delete();

        $this->actingAs($admin)
            ->delete(route('admin.products.force-delete', $product))
            ->assertRedirect(route('admin.products.trash'))
            ->assertSessionHas('success');

        $this->assertModelMissing($product);
    }

    public function test_product_with_cake_requests_cannot_be_permanently_deleted(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create();
        $product = $this->createProduct($admin, 'Birthday Cake');

        $customer->orders()->create([
            'product_id' => $product->id,
            'customer_name' => $customer->name,
            'email' => $customer->email,
            'pet_name' => 'Coco',
            'pet_type' => 'Dog',
            'flavor' => 'Vanilla',
            'size' => '4-inch',
            'pickup_date' => now()->addDay(),
        ]);

        $product->delete();

        $this->actingAs($admin)
            ->delete(route('admin.products.force-delete', $product))
            ->assertRedirect(route('admin.products.trash'))
            ->assertSessionHas('error');

        $this->assertSoftDeleted($product);
    }

    public function test_active_product_cannot_be_restored_from_trash(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $product = $this->createProduct($admin, 'Birthday Cake');

        $this->actingAs($admin)
            ->patch(route('admin.products.restore', $product))
            ->assertNotFound();

        $this->assertNotSoftDeleted($product);
    }

    public function test_user_cannot_delete_a_product(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(name: 'Birthday Cake');

        $this->actingAs($user)
            ->delete(route('admin.products.destroy', $product))
            ->assertForbidden();

        $this->assertNotSoftDeleted($product);
    }

    private function createProduct(?User $owner = null, string $name = 'Celebration Cake'): Product
    {
        $owner ??= User::factory()->create(['role' => 'admin']);

        return $owner->products()->create([
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
