<?php

namespace acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Data\TaskTableConst;

class TaskTableCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->registerTestUser($I);
    }

    public function seeTaskTableUI(AcceptanceTester $I): void
    {
        /** TODO check page UI (buttons, texts etc.) */
    }

    public function createNewTable(AcceptanceTester $I): void
    {
        $I->wantTo("Add a new table");

        $I->click('#addTableButton');
        $I->seeInPopup("Podaj nazwę tabelki");
        $I->typeInPopup(TaskTableConst::TEST_TABLE_NAME);
        $I->acceptPopup();
        $I->waitForElement('.tableLink.activeTable');
        $I->canSee(TaskTableConst::TEST_TABLE_NAME, '.tableLink');
        $I->seeInDatabase('tables', [
            'name' => TaskTableConst::TEST_TABLE_NAME,
            'user_id' => 1,
        ]);
    }

    public function editTableName(AcceptanceTester $I): void
    {
        /** TODO edit table test - add table, edit name via popup - check name changed */
    }

    public function deleteTable(AcceptanceTester $I): void
    {
        /** TODO delete table test - add table, delete via popup - check deleted */
    }

}
