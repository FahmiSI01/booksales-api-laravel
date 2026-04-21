<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    private $authors = [
        ['id'=>1,'name'=>'Tere Liye','photo'=>'tere.jpg','bio'=>'Penulis novel Indonesia'],
        ['id'=>2,'name'=>'Andrea Hirata','photo'=>'andrea.jpg','bio'=>'Penulis Laskar Pelangi'],
        ['id'=>3,'name'=>'Pramoedya','photo'=>'pram.jpg','bio'=>'Sastrawan Indonesia'],
        ['id'=>4,'name'=>'Raditya Dika','photo'=>'radit.jpg','bio'=>'Penulis komedi'],
        ['id'=>5,'name'=>'Habiburrahman','photo'=>'habib.jpg','bio'=>'Penulis religi'],
    ];

    public function getAuthors(){
        return $this->authors;
    }
}