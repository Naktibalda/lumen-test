<?php

use Codeception\Util\HttpCode;

class CreateReportCest
{

    public function _before(FunctionalTester $I)
    {
        $I->getAndApplyToken();
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function reportSuccessfully(FunctionalTester $I)
    {
        $report = [
            'yesterday' => 'project 1',
            'today' => 'project 2',
            'blockers' => 'response from client',
        ];

        $expectedResponse = $report;
        $expectedResponse['username'] = 'valid';
        $expectedResponse['date'] = date('Y-m-d');

        $I->sendPOST('/my-report', $report);

        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            $expectedResponse
        );

        $I->seeRecord('report', $expectedResponse);
    }

    public function updateReportSuccessfully(FunctionalTester $I)
    {
        $username = 'valid';
        $date = date('Y-m-d');

        $report1 = [
            'yesterday' => 'project 1',
            'today' => 'project 2',
            'blockers' => 'response from client',
            'username' => $username,
            'date' => $date,
        ];

        $I->haveRecord('report', $report1);

        $report2 = [
            'yesterday' => 'project 3',
            'today' => 'project 4',
            'blockers' => 'response from client',
        ];

        $expectedResponse = $report2;
        $expectedResponse['username'] = 'valid';
        $expectedResponse['date'] = date('Y-m-d');

        $I->sendPOST('/my-report', $report2);

        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            $expectedResponse
        );

        $I->seeRecord('report', $expectedResponse);
    }
}
