<?php

namespace App\Console\Commands;

use App\Mail\SendTodoEmails;
use App\Services\Github;
use App\Setting;
use App\SettingMatch;
use App\User;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckForGithubPullRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todo:github';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for Github Pull Requests';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Github $github)
    {
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
                array_push($array, $timezone);
            }
        }

        return $array;
    }
}
