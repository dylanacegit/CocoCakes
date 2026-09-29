<?php

namespace Tests\Feature;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PetManagementTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $this->get(route('customer.pets'))
            ->assertRedirect(route('login'));
    }

    public function test_user_sees_only_their_own_pets(): void
    {
        $user = User::factory()->create();
        $ownPet = Pet::factory()->for($user)->create(['name' => 'Prada']);
        $otherPet = Pet::factory()->create(['name' => 'Connie']);

        $this->actingAs($user)
            ->get(route('customer.pets'))
            ->assertSee($ownPet->name)
            ->assertDontSee($otherPet->name);
    }

    public function test_user_can_add_a_pet(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('customer.pets.store'), [
                'name' => 'Prada',
                'type' => 'Dog',
                'breed' => 'Welsh Corgi',
                'age' => 4,
            ])
            ->assertRedirect(route('customer.pets'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('pets', [
            'user_id' => $user->id,
            'name' => 'Prada',
            'type' => 'Dog',
            'breed' => 'Welsh Corgi',
            'age' => 4,
        ]);
    }

    public function test_pet_fields_are_required(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('customer.pets.store'), [])
            ->assertSessionHasErrors(['name', 'type', 'breed', 'age']);
    }
}
