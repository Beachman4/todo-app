<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Github;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Auth;

class GithubController extends Controller
{
    private $github;

    public function __construct(Github $github)
    {
        $this->github = $github;
    }

    public function callback(Request $request)
    {
        $code = $request->code;

        Auth::loginUsingId(intval(decrypt($request->state)));

        $body = $this->github->getAccessToken($code, $this->id());

        parse_str($body, $result);

        $token = $result['access_token'];

        $this->user()->updateSetting('github_token', encrypt($token));

        $this->github->setUser($this->user());

        $githubUsername = $this->github->getGithubUser();

        $this->user()->updateSetting('github_username', encrypt($githubUsername->login));

        return redirect('/settings');
    }

    public function disconnect()
    {
        $user = $this->user();

        $this->github->setUser($user);

        $this->github->disconnectGithub();

        $user->deleteSetting('github_token');
        $user->deleteSetting('github_username');

        return response()->json([
            'status' => 'success'
        ]);
    }
}
