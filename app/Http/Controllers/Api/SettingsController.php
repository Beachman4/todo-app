<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getOptions()
    {
        return response()->json([
            'github_client_id' => config('services.github.client_id'),
            'state' => encrypt($this->id()),
            'timezones' => \DateTimeZone::listIdentifiers()
        ]);
    }

    public function getSettings()
    {
        $github = $this->user()->setting('github_username');
        $array = [
            'github_username' => $github ? decrypt($github) : $github,
            'settings' => [
                'timezone' => $this->user()->setting('timezone')
            ]
        ];

        return response()->json($array);
    }

    public function update(Request $request)
    {
        $settings = Setting::whereNotIn('setting', ['github_username', 'github_token'])->pluck('setting');

        foreach ($settings as $setting) {
            if ($request->has($setting)) {
                $input = $request->input($setting);
                if ($this->user()->setting($setting) != $input) {
                    $this->user()->updateSetting($setting, $input);
                }
            }
        }

        return response()->json([
            'status' => 'success'
        ]);
    }
}
