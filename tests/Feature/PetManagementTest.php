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

    public function test_user_can_edit_their_pet(): void
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->for($user)->create();

        $this->actingAs($user)
            ->get(route('customer.pets.edit', $pet))
            ->assertOk()
            ->assertSee($pet->name);

        $this->actingAs($user)
            ->put(route('customer.pets.update', $pet), [
                'name' => 'Coco',
                'type' => 'Dog',
                'breed' => 'Poodle',
                'age' => 5,
            ])
            ->assertRedirect(route('customer.pets'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('pets', [
            'id' => $pet->id,
            'name' => 'Coco',
            'breed' => 'Poodle',
            'age' => 5,
        ]);
    }

    public function test_user_cannot_edit_another_users_pet(): void
    {
        $user = User::factory()->create();
        $otherPet = Pet::factory()->create();

        $this->actingAs($user)
            ->get(route('customer.pets.edit', $otherPet))
            ->assertForbidden();

        $this->actingAs($user)
            ->put(route('customer.pets.update', $otherPet), [
                'name' => 'Changed',
                'type' => 'Dog',
                'breed' => 'Poodle',
                'age' => 5,
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('pets', [
            'id' => $otherPet->id,
            'name' => 'Changed',
        ]);
    }
}
