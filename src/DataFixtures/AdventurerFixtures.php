<?php

namespace App\DataFixtures;

use App\Entity\Adventurer;
use App\Entity\AdventurerRace;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdventurerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $adventurers = [
            new Adventurer('Anne', AdventurerRace::HUMAN,'Cleric', 2, 1209),
            new Adventurer('Pierre',AdventurerRace::DWARF,'Ranger', 7, 209),
            new Adventurer('Dartagnan',AdventurerRace::ELF, 'Swashbuckler', 15, 2209),
            new Adventurer('Dennis', AdventurerRace::ORC,'Paladin', 6, 544),
            new Adventurer('Jeanne', AdventurerRace::HUMAN,'Fighter', 10, 123),
        ];

        foreach ($adventurers as $adventurer) {
            $manager->persist($adventurer);
        }

        $manager->flush();
    }
}
