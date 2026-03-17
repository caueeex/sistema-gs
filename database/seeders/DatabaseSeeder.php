<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Usuário Teste',
            'email' => 'teste@example.com',
        ]);

        $this->call([
            ProductSeeder::class,
            AdSeeder::class,
        ]);
    }
}
