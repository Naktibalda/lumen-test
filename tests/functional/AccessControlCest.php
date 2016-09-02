<?php

use \Codeception\Util\HttpCode;

class AccessControlCest
{

    public function unknownRouteReturnsJson(FunctionalTester $I)
    {
        $I->sendGET('/bad-path',[
            'yesterday' => 'project 1',
            'today' => 'project 2',
            'blockers' => 'response from client',
        ]);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseContainsJson(['error' => 'NotFoundHttpException']);
    }

    public function cantPostReportWithoutAuth(FunctionalTester $I)
    {
        $I->sendPOST('/my-report',[
            'yesterday' => 'project 1',
            'today' => 'project 2',
            'blockers' => 'response from client',
        ]);

        $I->canSeeResponseCodeIs(HttpCode::UNAUTHORIZED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['error' => 'Access Denied']);
    }
}
