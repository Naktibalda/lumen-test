<?php

use Codeception\Util\HttpCode;

class LoginCest
{
    public function _before(FunctionalTester $I)
    {
        $I->haveRecord('user', ['username' => 'valid', 'name' => 'Test User']);
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    /**
     * @param FunctionalTester $I
     */
    public function returnsErrorIfLoginFailed(FunctionalTester $I)
    {
        $I->sendPost('/login', [
            'username' => 'invalid',
            'password' => 'invalid',
        ]);

        $I->canSeeResponseCodeIs(HttpCode::UNAUTHORIZED);
        $I->seeResponseContainsJson([
            'error' => 'incorrect username or password'
        ]);
    }

    public function returnsErrorIfParametersAreNotSet(FunctionalTester $I)
    {
        $I->sendPost('/login', []);

        $I->canSeeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseContainsJson([
            'error' => 'username and password parameters are required'
        ]);
    }

    public function returnsTokenIfLoginSucceeded(FunctionalTester $I)
    {
        $I->sendPost('/login', [
            'username' => 'valid',
            'password' => 'valid',
        ]);

        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->seeResponseMatchesJsonType([
            'token' => 'string:!empty',
        ]);

        $token = $I->grabDataFromResponseByJsonPath('token')[0];

        $I->seeRecord('token', ['token' => $token]);
    }
}
