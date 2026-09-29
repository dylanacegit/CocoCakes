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
        $user = User::factory()->create();
        $pet = Pet::factory()->for($user)->create([
            'name' => 'Prada',
            'type' => 'Dog',
        ]);
        $product = $this->createProduct($user);

        $this->actingAs($user)
            ->post(route('order.store'), [
                'product_id' => $product->id,
                'pet_id' => $pet->id,
                'customer_name' => 'Dylan',
                'email' => 'dylan@example.com',
                'pickup_date' => now()->addDay()->toDateString(),
                'special_instructions' => 'Blue frosting.',
            ])
            ->assertRedirect(route('customer.requests'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'pet_id' => $pet->id,
            'pet_name' => 'Prada',
            'pet_type' => 'Dog',
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
                'pickup_date' => now()->addDay()->toDateString(),
            ])
            ->assertSessionHasErrors('pet_id');

        $this->assertDatabaseCount('orders', 0);
    }

    private function createProduct(User $user): Product
    {
        return $user->products()->create([
            'name' => 'Birthday Cake',
            'slug' => 'birthday-cake',
            'description' => 'A custom birthday cake.',
            'options' => [],
        ]);
    }
}
