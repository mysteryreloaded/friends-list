<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    protected $fillable = ['user_1', 'user_2', 'status'];
}
