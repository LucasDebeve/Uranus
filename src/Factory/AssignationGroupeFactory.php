<?php

namespace App\Factory;

use App\Entity\AssignationGroupe;
use App\Repository\AssignationGroupeRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<AssignationGroupe>
 *
 * @method        AssignationGroupe|Proxy                     create(array|callable $attributes = [])
 * @method static AssignationGroupe|Proxy                     createOne(array $attributes = [])
 * @method static AssignationGroupe|Proxy                     find(object|array|mixed $criteria)
 * @method static AssignationGroupe|Proxy                     findOrCreate(array $attributes)
 * @method static AssignationGroupe|Proxy                     first(string $sortedField = 'id')
 * @method static AssignationGroupe|Proxy                     last(string $sortedField = 'id')
 * @method static AssignationGroupe|Proxy                     random(array $attributes = [])
 * @method static AssignationGroupe|Proxy                     randomOrCreate(array $attributes = [])
 * @method static AssignationGroupeRepository|RepositoryProxy repository()
 * @method static AssignationGroupe[]|Proxy[]                 all()
 * @method static AssignationGroupe[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static AssignationGroupe[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static AssignationGroupe[]|Proxy[]                 findBy(array $attributes)
 * @method static AssignationGroupe[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static AssignationGroupe[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class AssignationGroupeFactory extends ModelFactory
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
            'eleve' => UserFactory::new(),
            'groupe' => GroupeFactory::random() ?? GroupeFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(AssignationGroupe $assignationGroupe): void {})
        ;
    }

    protected static function getClass(): string
    {
        return AssignationGroupe::class;
    }
}
