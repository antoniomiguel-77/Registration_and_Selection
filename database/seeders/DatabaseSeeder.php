<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'john doe',
            'email' => 'john@doe.com',
            'password' => bcrypt('password'), // 👈 garante senha válida
        ]);

        // gera o token Sanctum
        $token = $user->createToken('seeder_token')->plainTextToken;

        // opcional: mostrar no console
        $this->command->info("User token: {$token}");
    }
}
