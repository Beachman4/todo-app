<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function setting($setting, $default_value = "")
    {
        $setting = Setting::where('setting', $setting)->first();

        //Check for match
        if ($match = $setting->getMatchForUser($this)) {
            return $match->value;
        }

        if ($default_value) {
            return $default_value;
        }

        return $setting->default_value;
    }

    public function updateSetting($setting, $value)
    {
        $setting = Setting::where('setting', $setting)->first();

        if ($match = $setting->getMatchForUser($this)) {
            $match->value = $value;
            $match->save();
            return $match->value;
        }

        $match = $setting->matches()->create([
            'user_id' => $this->id,
            'value' => $value
        ]);

        return $match->value;
    }

    public function deleteSetting($setting)
    {
        $setting = Setting::where('setting', $setting)->first();

        if ($match = $setting->getMatchForUser($this)) {
            $match->delete();
        }
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function todoItems()
    {
        return $this->hasMany(TodoItem::class);
    }


}
