<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'Cinta Terkalang',
            'description' => 'Novel tentang cinta sejati.',
            'price' => 20000.00,
            'stock' => 7,
            'cover_photo' => 'book1.png',
            'genre_id' => 1,
            'author_id' => 1,
        ]);

        Book::create([
            'title' => 'Hantu Belang',
            'description' => 'Novel tentang hantu belang.',
            'price' => 300000.00,
            'stock' => 6,
            'cover_photo' => 'hantu.avif',
            'genre_id' => 2,
            'author_id' => 2,
        ]);

        Book::create([
            'title' => 'Pulang',
            'description' => 'Novel tentang perjalanan pulang seorang anak ke kampung halamannya.',
            'price' => 25000.00,
            'stock' => 5,
            'cover_photo' => 'pulang.jpg',
            'genre_id' => 3,
            'author_id' => 3,
        ]);

        Book::create([
            'title' => 'my Stupid Boss',
            'description' => 'Novel tentang cerita lucu.',
            'price' => 15000.00,
            'stock' => 2,
            'cover_photo' => 'boss.avif',
            'genre_id' => 4,
            'author_id' => 4,
        ]);

        Book::create([
            'title' => 'Journey to Allah',
            'description' => 'Novel tentang islam.',
            'price' => 40000.00,
            'stock' => 4,
            'cover_photo' => 'jurney.avif',
            'genre_id' => 5,
            'author_id' => 5,
        ]);
    }
}
