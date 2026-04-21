<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    private $genres = [
        ['id'=>1,'name'=>'Romance','description'=>'Cerita cinta'],
        ['id'=>2,'name'=>'Horror','description'=>'Cerita seram'],
        ['id'=>3,'name'=>'Fantasy','description'=>'Dunia imajinasi'],
        ['id'=>4,'name'=>'Comedy','description'=>'Cerita lucu'],
        ['id'=>5,'name'=>'Religi','description'=>'Cerita islami'],
    ];

    public function getGenres(){
        return $this->genres;
    }
}