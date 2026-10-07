<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Seeder;

class RandomPetSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'testuser@gmail.com')
            ->firstOrFail();

        Pet::factory()
            ->count(100)
            ->for($user)
            ->create();
    }
}
