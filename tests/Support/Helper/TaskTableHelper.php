<?php

namespace Tests\Support\Helper;

use Codeception\Module;
use Tests\Support\AcceptanceTester;
use Tests\Support\Data\TaskTableConst;

class TaskTableHelper extends Module
{
    public function addTestTaskTable(AcceptanceTester $I): void
    {
        $I->click('#addTableButton');
        $I->seeInPopup("Podaj nazwę tabelki");
        $I->typeInPopup(TaskTableConst::TEST_TABLE_NAME);
        $I->acceptPopup();
    }

}
