<?php

namespace Tests\Support\Helper;

use Codeception\Module;
use Tests\Support\AcceptanceTester;
use Tests\Support\Data\TaskConst;

class TaskHelper extends Module
{

    public function addNewTask(AcceptanceTester $I): void
    {
        $I->waitForElementVisible('.addTaskButton');
        $I->click('.addTaskButton');
        $I->seeInPopup("Podaj tytuł zadania");
        $I->typeInPopup(TaskConst::TEST_TASK_NAME);
        $I->acceptPopup();
    }

}
