<?php

namespace App\Factory;

use App\Entity\PlanDeTravail;
use App\Repository\PlanDeTravailRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<PlanDeTravail>
 *
 * @method        PlanDeTravail|Proxy                     create(array|callable $attributes = [])
 * @method static PlanDeTravail|Proxy                     createOne(array $attributes = [])
 * @method static PlanDeTravail|Proxy                     find(object|array|mixed $criteria)
 * @method static PlanDeTravail|Proxy                     findOrCreate(array $attributes)
 * @method static PlanDeTravail|Proxy                     first(string $sortedField = 'id')
 * @method static PlanDeTravail|Proxy                     last(string $sortedField = 'id')
 * @method static PlanDeTravail|Proxy                     random(array $attributes = [])
 * @method static PlanDeTravail|Proxy                     randomOrCreate(array $attributes = [])
 * @method static PlanDeTravailRepository|RepositoryProxy repository()
 * @method static PlanDeTravail[]|Proxy[]                 all()
 * @method static PlanDeTravail[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static PlanDeTravail[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static PlanDeTravail[]|Proxy[]                 findBy(array $attributes)
 * @method static PlanDeTravail[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static PlanDeTravail[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class PlanDeTravailFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'titre' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(PlanDeTravail $planDeTravail): void {})
        ;
    }

    protected static function getClass(): string
    {
        return PlanDeTravail::class;
    }
}
