<?php

namespace App\Tests\Unit;

use App\Entity\AdventurerStatus;
use App\GithubService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class GithubServiceTest extends TestCase
{

    public function testGithubService(): void
    {
        $response = new MockResponse(json_encode([
            [
                "title" => "Anne",
                "labels" => [
                    ['name' => 'available']
                ]
            ],
            [
                "title" => "Cédric",
                "labels" => [
                    ['name' => 'sleeping']
                ]
            ]
        ]));
        $client = new MockHttpClient($response);

        $githubService = new GithubService(
            $client
        );
        $adventurers = $githubService->getAdventurers();

        $this->assertCount(2, $adventurers);
        $this->assertSame('Anne', $adventurers[0]->getName());
        $this->assertSame(AdventurerStatus::AVAILABLE, $adventurers[0]->getStatus());
        $this->assertSame('Cédric', $adventurers[1]->getName());
        $this->assertSame(AdventurerStatus::SLEEPING, $adventurers[1]->getStatus());
    }
}
