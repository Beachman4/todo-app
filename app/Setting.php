<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Setting extends Model
{
    protected $fillable = ['setting', 'default_value', 'display_name'];

    public function matches()
    {
        return $this->hasMany(SettingMatch::class);
    }

    public function getMatchForUser(User $user)
    {
        return SettingMatch::where('setting_id', $this->id)->where('user_id', $user->id)->first();
    }
}
