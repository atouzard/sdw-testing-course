<?php

namespace App\Controller;

use App\Entity\Adventurer;
use App\Entity\AdventurerRace;
use App\Repository\AdventurerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route(path: '/', name: 'main_controller', methods: ['GET'])]
    public function index(): Response
    {
        $adventurers = [
            new Adventurer('Anne', AdventurerRace::HUMAN,'Cleric', 2, 1209),
            new Adventurer('Pierre',AdventurerRace::DWARF,'Ranger', 7, 209),
            new Adventurer('Dartagnan',AdventurerRace::ELF, 'Swashbuckler', 15, 2209),
            new Adventurer('Dennis', AdventurerRace::ORC,'Paladin', 6, 544),
            new Adventurer('Jeanne', AdventurerRace::HUMAN,'Fighter', 10, 123),
        ];

        return $this->render('main/index.html.twig', [
            'adventurers' => $adventurers,
        ]);
    }
}
