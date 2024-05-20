<?php

namespace App\Factory;

use App\Entity\Sequence;
use App\Repository\SequenceRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Sequence>
 *
 * @method        Sequence|Proxy                     create(array|callable $attributes = [])
 * @method static Sequence|Proxy                     createOne(array $attributes = [])
 * @method static Sequence|Proxy                     find(object|array|mixed $criteria)
 * @method static Sequence|Proxy                     findOrCreate(array $attributes)
 * @method static Sequence|Proxy                     first(string $sortedField = 'id')
 * @method static Sequence|Proxy                     last(string $sortedField = 'id')
 * @method static Sequence|Proxy                     random(array $attributes = [])
 * @method static Sequence|Proxy                     randomOrCreate(array $attributes = [])
 * @method static SequenceRepository|RepositoryProxy repository()
 * @method static Sequence[]|Proxy[]                 all()
 * @method static Sequence[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Sequence[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Sequence[]|Proxy[]                 findBy(array $attributes)
 * @method static Sequence[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Sequence[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class SequenceFactory extends ModelFactory
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
        $dateDeb = self::faker()->dateTimeBetween('-6 month', '+6 month');

        return [
            'description' => self::faker()->text(),
            'dateDeb' => $dateDeb,
            'dateFin' => self::faker()->dateTimeBetween($dateDeb, '+1 year'),
            'plan_de_travail' => PlanDeTravailFactory::random() ?? PlanDeTravailFactory::new(),
            'titre' => self::faker()->sentence(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Sequence $sequence): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Sequence::class;
    }
}
