<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Adventurer;
use App\Entity\AdventurerRace;
use App\Entity\AdventurerStatus;
use PHPUnit\Framework\TestCase;

class AdventurerTest extends TestCase
{
    public function testAdventurerGettersShouldSucceed(): void
    {
        $adventurer = new Adventurer('Anne',AdventurerRace::HUMAN, 'Cleric', 2);

        $this->assertSame('Anne', $adventurer->getName());
        $this->assertSame('Cleric', $adventurer->getClass());
        $this->assertSame(2, $adventurer->getHealth());
    }

    public function adventurerHealthDescriptionDataProvider(): \Generator
    {
        yield 'adventurer has 18 health should be fine' => [18, 'fine'];
        yield 'adventurer has 15 health should be fine' => [15, 'fine'];
        yield 'adventurer has 8 health should be wounded' => [8, 'wounded'];
        yield 'adventurer has 2 health should be wounded' => [2, 'badly wounded'];
        yield 'adventurer has 0 health should be dead' => [0, 'dead'];
        yield 'adventurer has -5 health should be dead' => [-5, 'dead'];
    }

    /**
     * @dataProvider adventurerHealthDescriptionDataProvider
     */
    public function testAdventurerHealthDescription(int $health, string $description): void
    {
        $adventurer = new Adventurer('Anne', AdventurerRace::HUMAN,'Cleric', $health);

        $this->assertSame($description, $adventurer->getHealthDescription());
    }

    public function adventurerStatusAvailabilityDataProvider(): \Generator
    {
        yield 'A available adventurer with 10 HP should be available' => ['available', 10, true];
        yield 'A sleeping adventurer with 10 HP should not be available' => ['sleeping', 10, false];
        yield 'A sick adventurer with 10 HP should not be available' => ['sick', 10, false];
        yield 'A available adventurer with 6 HP should not be available' => ['available', 6, false];
        yield 'A available adventurer with 2 HP should not be available' => ['available', 2, false];
        yield 'A available adventurer with —2 HP should not be available' => ['available', -2, false];
        yield 'A eating adventurer with 6 HP should not be available' => ['eating', 6, false];
        yield 'A poisoned adventurer with 12 HP should not be available' => ['poisoned', 12, false];
    }

    /**
     * @dataProvider adventurerStatusAvailabilityDataProvider
     */
    public function testAdventurerAvailability(string $status, int $health, bool $available): void
    {
        $adventurer = new Adventurer('Anne', AdventurerRace::HUMAN,'Cleric', $health);

        $adventurer->setStatus(AdventurerStatus::tryFrom($status));

        $this->assertSame($available, $adventurer->isAvailable());
    }

    public function testAventurerDescription() {
        $adventurer = new Adventurer('Anne', AdventurerRace::HUMAN,'Cleric', 5);
        $this->assertSame("Nom : Anne, Class : Cleric, HP : 5", $adventurer->getDescription());
    }

    public function adventurerHealDataProvider(): \Generator
    {
        yield 'Heal 5 HP should succeed' => [10, 5, 15];
        yield 'Heal should not go over 18 HP for lvl 1 Human' => [10, 15, 18];
        yield 'Heal should not go under min HP' => [10, -15, 0];
        yield 'Dead adventurer should not heal' => [0, 5, 0];
        yield 'Negative health adventurer should not heal' => [-5, 8, 0];
    }

    /**
     * @dataProvider adventurerHealDataProvider
     */
    public function testHealAdventurer($vieDepart, $vieSoignee, $vieFinale) {
        $adventurer = new Adventurer('Anne', AdventurerRace::HUMAN,'Cleric', $vieDepart);

        $adventurer->heal($vieSoignee);

        $this->assertSame($vieFinale, $adventurer->getHealth());
    }

    public function adventurerXPLevelsDataProvider(): \Generator
    {
        yield 'Adventurer is level 1 with 0 xp' => [0, 1, 0];
        yield 'Adventurer gain one level' => [500, 1, 50];
        yield 'Adventurer gain two level' => [1600, 2, 60];
        yield 'Adventurer max level cannot go over level twenty' => [22000, 20, 0];
        yield 'Adventurer gain three level' => [2000, 3, 0];
        yield 'Negative xp cannot exist' => [-1500, 1, 0];
    }

    /**
     * @dataProvider adventurerXPLevelsDataProvider
     */
    public function testAdventurerXPLevels($xp, $level, $advancement): void
    {
        $adventurer = new Adventurer('Anne', AdventurerRace::HUMAN,'Cleric', 10);
        $adventurer->addXP($xp);
        $this->assertSame($xp, $adventurer->getXp());
        $this->assertSame($level, $adventurer->getLevel());
        $this->assertSame($advancement, $adventurer->getLevelAdvancementPercentage());
    }


    public function adventurerHPMaxByRaceDataProvider(): \Generator
    {
        yield 'Adventurer is a human and his max hp is 18' => [AdventurerRace::HUMAN, 10, 18];
        yield 'Adventurer is a elf and his max hp is 16' => [AdventurerRace::ELF, 20, 16];
        yield 'Adventurer is a orc and his max hp is 20' => [AdventurerRace::ORC, 10, 20];
        yield 'Adventurer is a dwarf and his max hp is 22' => [AdventurerRace::DWARF, 15, 22];
        yield 'Adventurer is a lvl 2 dwarf and his max hp is 34' => [AdventurerRace::DWARF, 1000, 34];
    }

    /**
     * @dataProvider adventurerHPMaxByRaceDataProvider
     */
    public function testAdventurerHpMaxByRace($race, $xp, $maxHP): void
    {
        $adventurer = new Adventurer('Anne', $race, 'Cleric', 18, $xp);

        $this->assertSame($maxHP, $adventurer->getMaxHealth());

    }

    // Calculer HP Max pour un aventurier
    // HP Max = 10 + (Niveau * HP de la race)
    // Utiliser ce max HP dans la methode de heal
    // Aller chercher les races et HP max / race sur API

    // HP de race :
    // Human 8
    // Elf 6
    // Orc 10
    // Dwarf 12
}
