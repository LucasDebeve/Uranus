<?php

namespace App\Tests\Api\PlanDeTravail;

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
        $I->sendGet('/api/bookmarks/1');

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Bookmark::class, '/api/bookmarks/1');
        // Transform Date to W3C date string ("Y-m-d\\TH:i:sP")
        $data['creationDate'] = $data['creationDate']->format(\DateTimeInterface::W3C);
        $I->seeResponseIsAnItem(self::expectedProperties(), $data);
    }
}
