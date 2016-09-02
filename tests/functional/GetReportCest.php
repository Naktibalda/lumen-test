<?php

use \Codeception\Util\HttpCode;

class GetReportCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function returnsEmptyArrayIfThereAreNoUsersInDatabase(FunctionalTester $I)
    {
        $I->sendGet('/report');
        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->dontSeeResponseJsonMatchesJsonPath('error');
        $I->dontSeeResponseContainsJson(['username' => 'valid']);
    }

    public function returnsAllUsersWithEmptyReportsIfNoneReported(FunctionalTester $I)
    {
        $I->haveRecord('user', ['username' => 'test.1', 'name' => 'Test User 1']);
        $I->haveRecord('user', ['username' => 'test.2', 'name' => 'Test User 2']);
        $I->haveRecord('user', ['username' => 'test.3', 'name' => 'Test User 3']);

        $I->sendGet('/report');
        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(
            [
                ['username' => 'test.1', 'name' => 'Test User 1', 'yesterday' => '', 'today' => '', 'blockers' => ''],
                ['username' => 'test.2', 'name' => 'Test User 2', 'yesterday' => '', 'today' => '', 'blockers' => ''],
                ['username' => 'test.3', 'name' => 'Test User 3', 'yesterday' => '', 'today' => '', 'blockers' => ''],
            ]
        );
    }

    public function returnsReportsOfAllUsers(FunctionalTester $I)
    {
        $I->haveRecord('user', ['username' => 'test.1', 'name' => 'Test User 1']);
        $I->haveRecord('user', ['username' => 'test.2', 'name' => 'Test User 2']);
        $I->haveRecord('user', ['username' => 'test.3', 'name' => 'Test User 3']);
        $date = date('Y-m-d');
        $I->haveRecord('report', ['date' => $date, 'username' => 'test.1', 'yesterday' => 'Project 1', 'today' => 'Project 1', 'blockers' => 'manager']);
        $I->haveRecord('report', ['date' => $date, 'username' => 'test.2', 'yesterday' => 'Project 2', 'today' => 'Project 3', 'blockers' => '']);

        $I->sendGet('/report');
        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson(
            [
                ['username' => 'test.1', 'name' => 'Test User 1', 'yesterday' => 'Project 1', 'today' => 'Project 1', 'blockers' => 'manager'],
                ['username' => 'test.2', 'name' => 'Test User 2', 'yesterday' => 'Project 2', 'today' => 'Project 3', 'blockers' => ''],
                ['username' => 'test.3', 'name' => 'Test User 3', 'yesterday' => '', 'today' => '', 'blockers' => ''],
            ]
        );
    }
}
