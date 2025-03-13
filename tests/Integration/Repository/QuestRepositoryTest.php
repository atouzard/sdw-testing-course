<?php

namespace App\Tests\Integration\Repository;

use App\Factory\QuestFactory;
use App\Repository\QuestRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class QuestRepositoryTest extends KernelTestCase
{
    use ResetDatabase, Factories;

    public function testNoActiveQuestWithoutEntries(): void
    {
        self::bootKernel();
        $questRepository = self::getContainer()->get(QuestRepository::class);

        $this->assertFalse($questRepository->hasActiveQuest());
    }

    public function testHasActiveQuestIfQuestIsActive(): void
    {
        $quest = QuestFactory::createOne([
            'startedAt' => new \DateTimeImmutable('-1 day'),
            'finished' => false,
        ]);

        QuestFactory::createMany(3, [
            'startedAt' => new \DateTimeImmutable('now'),
            'finished' => true,
        ]);

        $this->assertTrue($quest->_repository()->hasActiveQuest());
    }

    public function testNoActiveQuestForUpdatedQuest(): void
    {
        $quest = QuestFactory::createOne([
            'finished' => false
        ]);

        $quest->setFinished(true);
        $quest->_save();

        $this->assertFalse($quest->_repository()->hasActiveQuest());
    }

    public function testNoActiveQuestForDeletedActiveQuest(): void
    {
        $quest = QuestFactory::createOne([
            'finished' => false
        ]);

        $quest->_delete();

        $this->assertFalse($quest->_repository()->hasActiveQuest());
    }
}
