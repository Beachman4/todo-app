<?php
/**
 * Created by PhpStorm.
 * User: Aylon
 * Date: 11/5/2017
 * Time: 12:16 AM
 */

namespace App\Services;


use App\User;
use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Github
{
    private $client;

    private $user;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;

        $this->addAccessTokenToClient();
    }

    public function getAccessToken($code, $userId)
    {
        $array = [
            'client_id' => config('services.github.client_id'),
            'client_secret' => config('services.github.client_secret'),
            'code' => $code,
            'state' => encrypt($userId)
        ];

        $response = $this->client->post('https://github.com/login/oauth/access_token', [
            'form_params' => $array
        ]);

        return (string) $response->getBody();
    }

    private function addAccessTokenToClient()
    {
        if (!$this->getUser()) {
            throw new UnauthorizedHttpException("", "This requires a user");
        }
        $this->client = new Client([
            'base_uri' => 'https://api.github.com',
            'headers' => [
                'Authorization' => 'token ' . decrypt($this->getUser()->setting('github_token')),
                'Accept' => 'application/vnd.github.v3+json'
            ]
        ]);
    }

    public function getGithubUser()
    {
        $response = $this->client->get('/user');

        $body = (string) $response->getBody();

        $body = json_decode($body);

        return $body;
    }

    public function disconnectGithub()
    {
        $clientId = config('services.github.client_id');
        $client = new Client([
            'base_uri' => 'https://api.github.com',
            'auth' => [
                $clientId,
                config('services.github.client_secret')
            ],
            'headers' => [
                'Accept' => 'application/vnd.github.v3+json'
            ]
        ]);

        $client->delete("/applications/$clientId/grants/" . decrypt($this->getUser()->setting('github_token')));
    }

    private function countRepos()
    {
        $user = $this->getGithubUser();

        $total = $user->total_private_repos + $user->public_repos;

        return $total;
    }

    public function repos()
    {
        $numOfRepos = $this->countRepos();
        if ($numOfRepos <= 100) {

            $response = $this->client->get('/user/repos?per_page=100');

            $body = (string) $response->getBody();

            $body = json_decode($body);
        } else {
            $pages = intval($numOfRepos / 100);

            if ($numOfRepos % 100 != 0) {
                $pages += 1;
            }

            $body = [];

            for($i = 1; $i != $pages; $i++) {
                $response = $this->client->get("/user/repos?per_page=100&page=$i");

                $responseBody = (string) $response->getBody();

                $responseBody = json_decode($responseBody);

                $body = array_merge($body, $responseBody);
            }
        }

        // We just need names

        $repos = [];

        foreach ($body as $repo) {
            $array = [
                'owner' => $repo->owner->login,
                'name' => $repo->name
            ];
            array_push($repos, $array);
        }

        return $repos;
    }

    public function pullRequests()
    {
        $repos = $this->repos();

        $username = decrypt($this->getUser()->setting('github_username'));

        $pullRequests = [];

        foreach ($repos as $repo)
        {
            $pulls = $this->getPullRequestsForRepo($username, $repo);

            $pullRequests = array_merge($pullRequests, $pulls);
        }

        return $pullRequests;
    }

    public function getPullRequestsForRepo($username, $repo)
    {
        $owner = $repo['owner'];
        $name = $repo['name'];
        $response = $this->client->get("/repos/$owner/$name/pulls?state=open");

        $body = (string) $response->getBody();

        $body = json_decode($body);

        $pullRequests = [];

        foreach ($body as $item) {
            if ($item->user->login == $username) {
                array_push($pullRequests, $item);
                continue;
            }
            if (isset($item->assignees)) {
                foreach($item->assignees as $assignee) {
                    if ($assignee->login == $username) {
                        array_push($pullRequests, $item);
                        continue;
                    }
                }
            }
            if ($item->assignee && $item->assignee->login == $username) {
                array_push($pullRequests, $item);
                continue;
            }
        }

        return $pullRequests;
    }

    public function issues()
    {
        $response = $this->client->get('/user/issues?filter=all');

        $body = (string) $response->getBody();

        $body = json_decode($body);

        return $body;
    }
}