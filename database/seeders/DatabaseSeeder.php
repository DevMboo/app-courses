<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => \Hash::make('12345678')
        ]);

        $categories = [
            'Educativo',
            'Treinamento',
            'Aprimoramento',
            'Completo',
            'Básico',
            'Outros',
        ];

        foreach ($categories as $category) {
            Category::create(['title' => $category]);
        }
    }
}
