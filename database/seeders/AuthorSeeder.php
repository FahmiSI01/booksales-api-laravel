<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create([
            'name' => 'Mike Love',
            'photo' => 'https://example.com/mike_love.jpg',
            'bio' => 'Mike Love adalah seorang penulis novel romance.'
        ]);

        Author::create([
            'name' => 'Thonk Ghost',
            'photo' => 'https://example.com/thonk_ghost.jpg',
            'bio' => 'Thonk Ghost adalah seorang penulis novel horror.'
        ]);

        Author::create([
            'name' => 'Luth Thunk',
            'photo' => 'https://example.com/luth_thunk.jpg',
            'bio' => 'Luth Thunk adalah seorang penulis novel fantasi.'
        ]);

        Author::create([
            'name' => 'Doe Dha',
            'photo' => 'https://example.com/doe_dha.jpg',
            'bio' => 'Doe Dha adalah seorang penulis novel komedi.'
        ]);

        Author::create([
            'name' => 'Hi Lale',
            'photo' => 'https://example.com/hi_lale.jpg',
            'bio' => 'Hi Lale adalah seorang penulis novel religi.'
        ]);
    }
}
