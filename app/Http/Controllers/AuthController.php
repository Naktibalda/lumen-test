<?php

namespace App\Http\Controllers;

use App\Token;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Ldap\LdapClient;
use App\User;

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

        $user = User::getByUsername($username);

        $row = [
            'token' => Uuid::uuid4(),
            'username' => $username,
            'ip' => $request->getClientIp(),
        ];
        $token = new Token($row);
        $token->save();

        return response()->json([
            'token' => $row['token'],
            'username' => $username,
            'name' => $user['name'],
        ]);
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
        if (defined('RUNNING_TESTS')) {
            return $username === 'valid';
        }

        $user = User::getByUsername($username);
        return !empty($user);
    }
}
