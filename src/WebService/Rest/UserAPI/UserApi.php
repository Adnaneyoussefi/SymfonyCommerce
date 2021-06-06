<?php

namespace App\WebService\Rest\UserAPI;

use App\WebService\Rest\CustomRestClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class UserApi extends CustomRestClient
{
    protected $jsonplaceholderClient;
    
    public function __construct(HttpClientInterface $jsonplaceholderClient, ContainerBagInterface $params)
    {
        $this->file_name = 'users.json';
        $this->ws_id = 'jsonplaceholder';
        parent::__construct($jsonplaceholderClient, $params);
        $this->jsonplaceholderClient = $this->client;
    }

    // public function getUsers()
    // {
    //     dump($this->jsonplaceholderClient);
    //     return $this->jsonplaceholderClient->request('GET', '1');
    // }
}