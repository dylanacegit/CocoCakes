<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class UserRoleAccessTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guest_is_redirected_from_the_individual_product_view(): void
    {
        $product = $this->createProduct();

        $this->get(route('menu.show', ['product' => $product->slug]))
            ->assertRedirect(route('login'));
    }

    public function test_admin_is_forbidden_from_the_individual_product_view(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $product = $this->createProduct($admin);

        $this->actingAs($admin)
            ->get(route('menu.show', ['product' => $product->slug]))
            ->assertForbidden();
    }

    public function test_user_can_view_an_individual_product(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();

        $this->actingAs($user)
            ->get(route('menu.show', ['product' => $product->slug]))
            ->assertSee($product->name);
    }

    public function test_admin_is_forbidden_from_the_order_form(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('order.create'))
            ->assertForbidden();
    }

    public function test_user_can_view_the_order_form(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('order.create'))
            ->assertSee('Send Cake Request');
    }

    public function test_admin_is_forbidden_from_the_customer_pet_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('customer.pets'))
            ->assertForbidden();
    }

    public function test_user_is_forbidden_from_admin_product_management(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.products.index'))
            ->assertForbidden();
    }

    private function createProduct(?User $owner = null): Product
    {
        $owner ??= User::factory()->create(['role' => 'admin']);

        return $owner->products()->create([
            'name' => 'Celebration Cake',
            'slug' => 'celebration-cake',
            'description' => 'A celebration cake made for a special pet.',
            'options' => [
                'flavors' => ['Vanilla'],
                'sizes' => ['4-inch', '6-inch'],
            ],
        ]);
    }
}
