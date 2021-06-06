<?php
namespace App\Module1\Repository;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubUserRepository
{
    private $githubClient;

    public function __construct(HttpClientInterface $githubClient)
    {
        $this->githubClient = $githubClient;
    }

    public function findByUsername($username)
    {
        $path = '/users/'.$username;
        $response = $this->githubClient->request('GET', $path);
        dump($response);
        return $response->toArray();
    }
}