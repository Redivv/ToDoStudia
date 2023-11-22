<?php

namespace Tests\Support\Helper;

use Codeception\Module;
use Tests\Support\AcceptanceTester;
use Tests\Support\Data\LoginConst;

class LoginHelper extends Module
{
    public function registerTestUser(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->fillField("#usernameInput", LoginConst::TEST_USERNAME);
        $I->fillField("#passwordInput", LoginConst::TEST_PASSWORD);
        $I->click('Rejestruj');
    }

    public function loginTestUser(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->fillField("#usernameInput", LoginConst::TEST_USERNAME);
        $I->fillField("#passwordInput", LoginConst::TEST_PASSWORD);
        $I->click('Zaloguj');
    }

}
