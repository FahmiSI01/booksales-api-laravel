<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    private $books = [
        [
            'title' => 'Pulang',
            'description' => 'Novel tentang perjalanan pulang seorang anak ke kampung halamannya.',
            'price' => 10.99,
            'stock' => 5,
            'cover_photo' => 'https://example.com/pulang.jpg',
            'genre_id' => 1,
            'author_id' => 1,
        ],
        [
            'title' => 'Laut Bercerita',
            'description' => 'Novel tentang kehidupan seorang anak yang tinggal di tepi laut.',
            'price' => 12.99,
            'stock' => 3,
            'cover_photo' => 'https://example.com/laut-bercerita.jpg',
            'genre_id' => 1,
            'author_id' => 2,
        ],
        [
            'title' => 'Bumi Manusia',
            'description' => 'Novel tentang kehidupan seorang anak muda di masa kolonial.',
            'price' => 15.99,
            'stock' => 2,
            'cover_photo' => 'https://example.com/bumi-manusia.jpg',
            'genre_id' => 1,
            'author_id' => 3,
        ],
    ];

    public function getBooks(){
        return $this->books;
    }

};
