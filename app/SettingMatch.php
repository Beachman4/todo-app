<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingMatch extends Model
{
    protected $fillable = ['setting_id', 'user_id', 'value'];

    protected $primaryKey = 'setting_id';
}
