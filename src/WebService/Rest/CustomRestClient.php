<?php

namespace App\WebService\Rest;

use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class CustomRestClient
{
    protected $params;

    protected $client;

    protected $file_name;

    protected $ws_id;

    public function __construct(HttpClientInterface $client, ContainerBagInterface $params)
    {
        $this->params = $params;
        $mock_enabled = $this->params->get('bouchon.enabled');
        $active_uc = $this->params->get('bouchon.active_uc');
        $directory = $this->params->get('bouchon.directory');
        if ($mock_enabled == true) {
            $json_path = $this->params->get('kernel.project_dir')
            .DIRECTORY_SEPARATOR.$directory
            .DIRECTORY_SEPARATOR.MODULE_NAME
            .DIRECTORY_SEPARATOR.$active_uc
            .DIRECTORY_SEPARATOR.$this->file_name;
            $response_json = file_get_contents($json_path);

            if(file_exists($json_path))
            {
                $this->client = new MockHttpClient(
                    new MockResponse($response_json),
                   $this->params->get('ws')[$this->ws_id]['rest']
                );
            }
            else
                throw new \Exception("Le fichier ".$json_path." n'existe pas");
        } else {
            $this->client = $client;
        }
    }

    public function request(string $method, string $url, array $options = [])
    {
        return $this->client->request($method, $url, $options);
    }
}