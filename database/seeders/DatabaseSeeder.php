<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\BlogCategory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Crear usuario predeterminado
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Crear categoría predeterminada para productos
        Category::create([
            'name' => 'General',
            'description' => 'Categoría general para productos'
        ]);

        // Crear categoría predeterminada para el blog
        BlogCategory::create([
            'name' => 'General',
            'description' => 'Categoría general para el blog'
        ]);
    }
}
