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
    }
}
