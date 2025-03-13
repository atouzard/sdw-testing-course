<?php

namespace App;

use App\Entity\Adventurer;
use App\Entity\AdventurerRace;
use App\Entity\AdventurerStatus;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubService
{

    public function __construct(
        private HttpClientInterface $client
    )
    {
    }

    public function getAdventurers(): array
    {
        $response = $this->client->request('GET', 'https://api.github.com/repos/atouzard/sdw-testing-course/issues');

        $results = $response->toArray();

        $adventurers = [];
        foreach ($results as $result) {
            $adventurer = new Adventurer(
                $result['title'],
                AdventurerRace::HUMAN,
                'Unknown',
                0,
                0
            );

            foreach ($result['labels'] as $label) {
                $adventurer->setStatus(AdventurerStatus::tryFrom($label['name']));
            }
            $adventurers[] = $adventurer;
        }

        return $adventurers;
    }
}