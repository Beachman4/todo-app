<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Setting
 *
 * @property int $id
 * @property string $setting
 * @property string $default_value
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SettingMatch[] $matches
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereDefaultValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereSetting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Setting whereUpdatedAt($value)
 */
	class Setting extends \Eloquent {}
}

namespace App{
/**
 * App\SettingMatch
 *
 * @property int $setting_id
 * @property int $user_id
 * @property string $value
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SettingMatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SettingMatch whereSettingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SettingMatch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SettingMatch whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SettingMatch whereValue($value)
 */
	class SettingMatch extends \Eloquent {}
}

namespace App{
/**
 * App\TodoItem
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $url
 * @property string $reminder
 * @property string $date
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TodoItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TodoItem whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TodoItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TodoItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TodoItem whereReminder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TodoItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TodoItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TodoItem whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TodoItem whereUserId($value)
 */
	class TodoItem extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TodoItem[] $todoItems
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

