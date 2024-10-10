<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Movie;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Book::factory(100)->create();
        Movie::factory(50)->create();
        // Category::factory(2)->create();

        User::factory(10)->create();
    }
}
