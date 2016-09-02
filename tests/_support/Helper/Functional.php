<?php
namespace Helper;

use Codeception\Util\HttpCode;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Functional extends \Codeception\Module
{

    public function getAndApplyToken()
    {
        $this->getModule('Lumen')->haveRecord('user', ['username' => 'valid', 'name' => 'Test User']);

        $I = $this->getModule('REST');
        $I->sendPost('/login', [
            'username' => 'valid',
            'password' => 'valid',
        ]);

        $I->seeResponseCodeIs(HttpCode::OK);
        $token = $I->grabDataFromResponseByJsonPath('token')[0];
        $I->haveHttpHeader('token', $token);
    }
}
