<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genre::create([
            'name' => 'Romance',
            'description' => 'Cerita cinta.'
        ]);

        Genre::create([
            'name' => 'Horror',
            'description' => 'Cerita seram.'
        ]);

        Genre::create([
            'name' => 'Fantasy',
            'description' => 'Dunia imajinasi.'
        ]);

        Genre::create([
            'name' => 'Comedy',
            'description' => 'Cerita lucu.'
        ]);

        Genre::create([
            'name' => 'Religi',
            'description' => 'Cerita islami.'
        ]);

    }
}
