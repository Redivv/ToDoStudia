<?php

namespace acceptance;

use Codeception\Attribute\DataProvider;
use Codeception\Example;
use Tests\Support\AcceptanceTester;
use Tests\Support\Data\TaskConst;

class TaskCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->registerTestUser($I);
        $I->addTestTaskTable($I);
    }

    public function seeTaskUI(AcceptanceTester $I): void
    {
        /** TODO check task UI - add table */
    }

    public function addNewTask(AcceptanceTester $I): void
    {
        $I->wantTo('Add a new task');

        $I->waitForElementVisible('.addTaskButton');
        $I->click('.addTaskButton');
        $I->seeInPopup("Podaj tytuł zadania");
        $I->typeInPopup(TaskConst::TEST_TASK_NAME);
        $I->acceptPopup();
        $I->waitForElementVisible('article');
        $I->waitForElementVisible('.taskTitle');
        $I->canSee(TaskConst::TEST_TASK_NAME, '.taskTitle');

        sleep(1);
        $I->canSeeInDatabase('tasks', [
            'title' => TaskConst::TEST_TASK_NAME,
            'table_id' => 1,
            'column_number' => 1,
            'level' => 0,
        ]);
        sleep(1);
        $I->canSeeMessageInQueueContainsText('task_created', 'Hello World!');
    }

    #[DataProvider('taskPointsProvider')]
    public function changeTaskPoints(AcceptanceTester $I, Example $data): void
    {
        $I->wantTo('Change points of a task');

        $I->addNewTask($I);
        $I->waitForElementVisible('.taskLevel');
        $I->click('.taskLevel');
        $I->seeInPopup('Podaj nowy number poziomu trudności zadania.');
        $I->typeInPopup((string)$data['points']);
        $I->acceptPopup();
        $I->waitForText((string)$data['points'], 10, '.taskLevel');

        $I->canSeeInDatabase('tasks', [
            'title' => TaskConst::TEST_TASK_NAME,
            'table_id' => 1,
            'column_number' => 1,
            'level' => $data['points'],
        ]);
    }

    protected function taskPointsProvider(): array
    {
        return [
            ['points' => 1],
            ['points' => 2],
            ['points' => 3],
            ['points' => 4],
            ['points' => 5],
        ];
    }

    public function changeTaskTitle(AcceptanceTester $I): void
    {
        /** TODO zmiana nazwy taska w prompt, można provider */
    }
}
