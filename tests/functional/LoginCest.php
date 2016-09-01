<?php


class LoginCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function returnsErrorIfLoginFailed(FunctionalTester $I)
    {
        $I->sendPost('/login', [
            'username' => 'invalid',
            'password' => 'invalid',
        ]);

        $I->canSeeResponseCodeIs(Codeception\Util\HttpCode::UNAUTHORIZED);
        $I->seeResponseContainsJson([
            'error' => 'incorrect username or password'
        ]);
    }
}
