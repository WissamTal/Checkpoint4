<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    public function fetchGitHubPhpRepos(): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.github.com/search/repositories?q=language:PHP+created:>2021-07-20',
            [
                'auth_basic' => [USERNAME, APIKEY],
            ]);
        return $response->toArray();
    }

}