<?php

namespace App\Factory;

use App\Entity\Suivi;
use App\Repository\SuiviRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Suivi>
 *
 * @method        Suivi|Proxy                     create(array|callable $attributes = [])
 * @method static Suivi|Proxy                     createOne(array $attributes = [])
 * @method static Suivi|Proxy                     find(object|array|mixed $criteria)
 * @method static Suivi|Proxy                     findOrCreate(array $attributes)
 * @method static Suivi|Proxy                     first(string $sortedField = 'id')
 * @method static Suivi|Proxy                     last(string $sortedField = 'id')
 * @method static Suivi|Proxy                     random(array $attributes = [])
 * @method static Suivi|Proxy                     randomOrCreate(array $attributes = [])
 * @method static SuiviRepository|RepositoryProxy repository()
 * @method static Suivi[]|Proxy[]                 all()
 * @method static Suivi[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Suivi[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Suivi[]|Proxy[]                 findBy(array $attributes)
 * @method static Suivi[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Suivi[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class SuiviFactory extends ModelFactory
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
            'eleve' => UserFactory::randomOrCreate(),
            'plan_de_travail' => PlanDeTravailFactory::randomOrCreate(),
            'progression' => self::faker()->numberBetween(0, 70),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Suivi $suivi): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Suivi::class;
    }
}
