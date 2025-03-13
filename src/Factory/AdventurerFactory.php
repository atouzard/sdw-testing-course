<?php

namespace App\Factory;

use App\Entity\Adventurer;
use App\Entity\AdventurerStatus;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Adventurer>
 */
final class AdventurerFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Adventurer::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'class' => self::faker()->text(),
            'health' => self::faker()->randomNumber(),
            'name' => self::faker()->text(),
            'status' => self::faker()->randomElement(AdventurerStatus::cases()),
            'xp' => self::faker()->randomNumber(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Adventurer $adventurer): void {})
        ;
    }
}
