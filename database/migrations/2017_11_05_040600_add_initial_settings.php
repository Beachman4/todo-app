<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Setting;

class AddInitialSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Setting::create([
            'setting' => 'github_token',
            'default_value' => ''
        ]);
        Setting::create([
            'setting' => 'github_username',
            'default_value' => ''
        ]);
        Setting::create([
            'setting' => 'timezone',
            'default_value' => 'UTC'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Setting::where('setting', 'github_token')->delete();
        Setting::where('setting', 'github_username')->delete();
        Setting::where('setting', 'timezone')->delete();
    }
}
