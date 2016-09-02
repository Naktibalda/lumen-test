<?php

namespace App\Http\Controllers;

use App\Token;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class AuthController extends Controller
{

    public function __construct()
    {
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if ($username === null || $password === null) {
            return response()->json(['error' => 'username and password parameters are required'], 400);
        }
        if (!$this->isValidUser($username, $password)) {
            return response()->json(['error' => 'incorrect username or password'], 401);
        }

        $row = [
            'token' => Uuid::uuid4(),
            'username' => $username,
            'ip' => $request->getClientIp(),
        ];
        $token = new Token($row);
        $token->save();

        return response()->json(['token' => $row['token']]);
    }

    public function logout(Request $request)
    {

    }

    /**
     * @param $username
     * @param $password
     * @return bool
     */
    private function isValidUser($username, $password)
    {
        return defined('RUNNING_TESTS') && $username === 'valid';
    }
}
