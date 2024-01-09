<?php

namespace App\Service;


use http\Client\Request;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StatusApiService
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function updateStatuses(array $adventurers): array
    {
        $response = $this->client->request('GET', 'http://localhost:8001/api/adventurers');

        foreach ($response->toArray() as $newAdventurer) {
            foreach ($adventurers as $adventurer) {
                if ($adventurer->getName() === $newAdventurer['name']) {
                    $adventurer->setStatus($newAdventurer['status']);
                    continue(2);
                }
            }
            throw new \RuntimeException('Adventurer '. $newAdventurer['name'] .' not found');
        }

        return $adventurers;
    }
}
