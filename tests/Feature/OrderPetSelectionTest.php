<?php

namespace Tests\Feature;

use App\Models\Pet;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class OrderPetSelectionTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_order_form_lists_only_the_users_pets(): void
    {
        $user = User::factory()->create();
        $ownPet = Pet::factory()->for($user)->create(['name' => 'Prada']);
        $otherPet = Pet::factory()->create(['name' => 'Connie']);

        $this->actingAs($user)
            ->get(route('order.create'))
            ->assertSee($ownPet->name)
            ->assertDontSee($otherPet->name);
    }

    public function test_user_can_create_an_order_for_their_pet(): void
    {
        $user = User::factory()->create(['name' => 'Dylan Garcia']);
        $pet = Pet::factory()->for($user)->create([
            'name' => 'Prada',
            'type' => 'Dog',
        ]);
        $product = $this->createProduct($user);

        $this->actingAs($user)
            ->post(route('order.store'), [
                'product_id' => $product->id,
                'pet_id' => $pet->id,
                'email' => 'dylan@example.com',
                'flavor' => 'Vanilla',
                'size' => '4-inch',
                'pickup_date' => now()->addDay()->toDateString(),
                'special_instructions' => 'Blue frosting.',
            ])
            ->assertRedirect(route('customer.requests'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'pet_id' => $pet->id,
            'customer_name' => 'Dylan Garcia',
            'pet_name' => 'Prada',
            'pet_type' => 'Dog',
            'flavor' => 'Vanilla',
            'size' => '4-inch',
        ]);
    }

    public function test_user_cannot_order_for_another_users_pet(): void
    {
        $user = User::factory()->create();
        $otherPet = Pet::factory()->create();
        $product = $this->createProduct($user);

        $this->actingAs($user)
            ->post(route('order.store'), [
                'product_id' => $product->id,
                'pet_id' => $otherPet->id,
                'customer_name' => 'Dylan',
                'email' => 'dylan@example.com',
                'flavor' => 'Vanilla',
                'size' => '4-inch',
                'pickup_date' => now()->addDay()->toDateString(),
            ])
            ->assertSessionHasErrors('pet_id');

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_order_rejects_a_flavor_not_available_for_the_product(): void
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->for($user)->create();
        $product = $this->createProduct($user);

        $this->actingAs($user)
            ->post(route('order.store'), [
                'product_id' => $product->id,
                'pet_id' => $pet->id,
                'customer_name' => 'Dylan',
                'email' => 'dylan@example.com',
                'flavor' => 'Strawberry',
                'size' => '4-inch',
                'pickup_date' => now()->addDay()->toDateString(),
            ])
            ->assertSessionHasErrors('flavor');

        $this->assertDatabaseCount('orders', 0);
    }

    private function createProduct(User $user): Product
    {
        return $user->products()->create([
            'name' => 'Birthday Cake',
            'slug' => 'birthday-cake',
            'description' => 'A custom birthday cake.',
            'options' => [
                'flavors' => ['Vanilla', 'Chocolate'],
                'sizes' => ['4-inch', '6-inch'],
            ],
        ]);
    }
}
