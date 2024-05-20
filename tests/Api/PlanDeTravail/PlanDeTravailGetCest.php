<?php

namespace App\Tests\Api\PlanDeTravail;

use App\Entity\PlanDeTravail;
use App\Factory\PlanDeTravailFactory;
use App\Tests\Support\ApiTester;

class PlanDeTravailGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'titre' => 'string',
            'sequences' => 'array',
        ];
    }

    public function getPlanDeTravailDetail(ApiTester $I): void
    {
        // 1. 'Arrange'
        $data = [
            'titre' => 'My Plan de Travail',
        ];
        PlanDeTravailFactory::createOne($data);

        // 2. 'Act'
        $I->sendGet('/api/plan_de_travails/1');

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(PlanDeTravail::class, '/api/bookmarks/1');
        // Transform Date to W3C date string ("Y-m-d\\TH:i:sP")
        $I->seeResponseIsAnItem(self::expectedProperties(), $data);
    }
}
