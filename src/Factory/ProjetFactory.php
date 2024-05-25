<?php

namespace App\Factory;

use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Projet>
 *
 * @method        Projet|Proxy                     create(array|callable $attributes = [])
 * @method static Projet|Proxy                     createOne(array $attributes = [])
 * @method static Projet|Proxy                     find(object|array|mixed $criteria)
 * @method static Projet|Proxy                     findOrCreate(array $attributes)
 * @method static Projet|Proxy                     first(string $sortedField = 'id')
 * @method static Projet|Proxy                     last(string $sortedField = 'id')
 * @method static Projet|Proxy                     random(array $attributes = [])
 * @method static Projet|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ProjetRepository|RepositoryProxy repository()
 * @method static Projet[]|Proxy[]                 all()
 * @method static Projet[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Projet[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Projet[]|Proxy[]                 findBy(array $attributes)
 * @method static Projet[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Projet[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ProjetFactory extends ModelFactory
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
            'titre' => self::faker()->sentence(),
            'description' => self::faker()->text(),
            'sequence' => SequenceFactory::random() ?? SequenceFactory::new(),
            'auteur' => UserFactory::random() ?? UserFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Projet $projet): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Projet::class;
    }
}
