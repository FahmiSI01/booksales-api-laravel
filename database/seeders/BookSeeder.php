<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'Cinta Sejati',
            'description' => 'Novel tentang cinta sejati.',
            'price' => 18.99,
            'stock' => 7,
            'cover_photo' => 'https://example.com/cinta-sejati.jpg',
            'genre_id' => 1,
            'author_id' => 1,
        ]);

        Book::create([
            'title' => 'Hantu Malam',
            'description' => 'Novel tentang hantu malam.',
            'price' => 8.99,
            'stock' => 6,
            'cover_photo' => 'https://example.com/hantu-malam.jpg',
            'genre_id' => 2,
            'author_id' => 2,
        ]);

        Book::create([
            'title' => 'Pulang',
            'description' => 'Novel tentang perjalanan pulang seorang anak ke kampung halamannya.',
            'price' => 10.99,
            'stock' => 5,
            'cover_photo' => 'https://example.com/pulang.jpg',
            'genre_id' => 3,
            'author_id' => 3,
        ]);

        Book::create([
            'title' => 'Comedy Times',
            'description' => 'Novel tentang cerita lucu.',
            'price' => 15.99,
            'stock' => 2,
            'cover_photo' => 'https://example.com/comedy-times.jpg',
            'genre_id' => 4,
            'author_id' => 4,
        ]);

        Book::create([
            'title' => 'Air Mata Surga',
            'description' => 'Novel tentang air mata surganya.',
            'price' => 20.99,
            'stock' => 4,
            'cover_photo' => 'https://example.com/air-mata-surga.jpg',
            'genre_id' => 5,
            'author_id' => 5,
        ]);

    }
}
