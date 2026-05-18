<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['user_id', 'name', 'email', 'subject', 'message', 'reply', 'status', 'read_by_user'];
}
