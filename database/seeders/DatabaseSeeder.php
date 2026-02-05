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

        $colony = Colony::factory()->create([
            'name' => 'Alpha',
            'user_id' => $user->id,
        ]);
    }
}
