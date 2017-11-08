<?php

namespace App\Jobs;

use App\Mail\SendTodoEmails;
use App\Services\Github;
use App\Setting;
use App\SettingMatch;
use App\TodoItem;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckForGithubPullRequests implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Github $github)
    {
        // Only get users where github_token and github_username is filled out

        $timezones = $this->getTimeZones();

        $timezoneSetting = Setting::where('setting', 'timezone')->first();

        $timezoneMatches = $timezoneSetting->matches()->whereIn('value', $timezones)->pluck('user_id');

        $settings = Setting::where('setting', 'github_token')->orWhere('setting', 'github_username')->pluck('id');

        $matches = SettingMatch::whereIn('setting_id', $settings)->whereIn('user_id', $timezoneMatches)->pluck('user_id');

        $users = User::whereIn('id', $matches)->get();

        foreach ($users as $user) {
            $github->setUser($user);
            $pullRequests = $github->pullRequests();

            $todoItems = [];

            foreach ($pullRequests as $pullRequest)
            {
                $item = $user->todoItems()->create([
                    'title' => $pullRequest->title,
                    'url' => $pullRequest->html_url,
                    'description' => $pullRequest->body,
                    'date' => Carbon::now($user->setting('timezone'))
                ]);

                array_push($todoItems, $item);
            }

            \Mail::to($user->email)->send(new SendTodoEmails($todoItems));
        }
    }

    private function getTimeZones()
    {
        $timezones = \DateTimeZone::listIdentifiers();

        $array = [];

        foreach ($timezones as $timezone) {
            $time = Carbon::now($timezone);
            if ($time->hour == 6) {

            }
            array_push($array, $timezone);
        }

        return $timezones;
    }
}
