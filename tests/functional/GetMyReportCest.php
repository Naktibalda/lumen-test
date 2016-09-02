<?php

use \Codeception\Util\HttpCode;

class GetMyReportCest
{
    public function _before(FunctionalTester $I)
    {
        $I->getAndApplyToken();
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function returnsEmptyFieldsIfTodaysReportIsNotSaved(FunctionalTester $I)
    {
        $I->sendGet('/my-report');
        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson([
            'yesterday' => '',
            'today' => '',
            'blockers' => '',
        ]);
    }

    public function returnsTodaysReportIfItWasSavedBefore(FunctionalTester $I)
    {
        $report = [
            'yesterday' => 'project 1',
            'today' => 'project 2',
            'blockers' => 'response from client',
            'username' => 'valid',
            'date' => date('Y-m-d'),
        ];

        $I->haveRecord('report', $report);

        $I->sendGet('/my-report');
        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson([
            'yesterday' => 'project 1',
            'today' => 'project 2',
            'blockers' => 'response from client',
        ]);
    }

    public function returnsYesterdaysTodayTasksInYesterdayFieldIfPreviousReportExists(FunctionalTester $I)
    {
        $report = [
            'yesterday' => 'project 1',
            'today' => 'project 2',
            'blockers' => 'response from client',
            'username' => 'valid',
            'date' => date('Y-m-d', strtotime('-1 day')),
        ];

        $I->haveRecord('report', $report);

        $I->sendGet('/my-report');
        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson([
            'yesterday' => 'project 2',
            'today' => '',
            'blockers' => '',
        ]);
    }
}
