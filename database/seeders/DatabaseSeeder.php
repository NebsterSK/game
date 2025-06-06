<?php

namespace Database\Seeders;

use App\Models\Colony;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $city = Colony::factory()->create([
            'name' => 'Nove Mesto',
            'user_id' => $user->id,
        ]);
    }
}
