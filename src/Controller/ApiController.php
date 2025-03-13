<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route(path: '/api/adventurers', name: 'api_adventurers_list', methods: ['GET'])]
    public function index(): Response
    {
        return $this->json([
            ['name' => 'Anne', 'status' => 'sleeping'],
            ['name' => 'Pierre', 'status' => 'working'],
            ['name' => 'Dartagnan', 'status' => 'ready'],
            ['name' => 'Dennis', 'status' => 'eating'],
        ]);
    }

    #[Route(path: '/api/races', name: 'api_races_list', methods: ['GET'])]
    public function listRaces(): Response
    {
        return $this->json([
            ['name' => 'Human', 'maxHp' => 8],
            ['name' => 'Elf', 'maxHp' => 6],
            ['name' => 'Orc', 'maxHp' => 10],
            ['name' => 'Dwarf', 'maxHp' => 12],
            ['name' => 'Halfling', 'maxHp' => 6],
        ]);
    }
}
