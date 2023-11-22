<?php

namespace api;

use Tests\Support\ApiTester;

class ApiCest
{
    public function getFormPageTest(ApiTester $I): void
    {
        $I->wantTo('Write example api test');

        $I->sendGet('/api');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['success' => true]);
    }

}
