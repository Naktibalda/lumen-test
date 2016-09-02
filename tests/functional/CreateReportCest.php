<?php

use Codeception\Util\HttpCode;

class CreateReportCest
{

    public function _before(FunctionalTester $I)
    {
        $I->sendPost('/login', [
            'username' => 'valid',
            'password' => 'valid',
        ]);

        $I->canSeeResponseCodeIs(HttpCode::OK);
        $token = $I->grabDataFromResponseByJsonPath('token')[0];
        $I->haveHttpHeader('token', $token);
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
            $report
        );

        $I->seeRecord('report', $report);
    }
}
