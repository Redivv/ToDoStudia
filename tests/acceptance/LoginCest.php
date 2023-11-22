<?php

namespace acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Data\LoginConst;

class LoginCest
{
    public function seeLoginForm(AcceptanceTester $I): void
    {
        $I->wantTo('Test login form UI');

        $I->amOnPage('/');
        $I->canSeeElement('#usernameInput');
        $I->canSeeElement('#passwordInput');

        $I->canSeeElement('#submitButtons button');
    }

    public function registerCorrectly(AcceptanceTester $I): void
    {
        $I->wantTo("Test register action");

        $I->amOnPage('/');
        $I->fillField("#usernameInput", LoginConst::TEST_USERNAME);
        $I->fillField("#passwordInput", LoginConst::TEST_PASSWORD);
        $I->click('Rejestruj');
        $I->seeCurrentUrlEquals('/todo');
    }

    public function logoutCorrectly(AcceptanceTester $I): void
    {
        $I->wantTo("Test logout action");

        $I->registerTestUser($I);
        $I->waitForElement('a[href="/logout"]');
        $I->click('a[href="/logout"]');
        $I->seeCurrentUrlEquals('/');
    }

    public function loginCorrectly(AcceptanceTester $I)
    {
        /** TODO register - logout - login */
    }

    public function redirectWhenLoggedIn(AcceptanceTester $I): void
    {
        /** TODO register - go back to login - check redirected */
    }

    public function registerAlreadyExistingUser(AcceptanceTester $I): void
    {
        /** TODO - register - logout - register - widze błąd */
    }

}
