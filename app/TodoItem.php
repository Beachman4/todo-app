<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TodoItem extends Model
{
    protected $fillable = ['title', 'date', 'reminder', 'description', 'url'];
}
