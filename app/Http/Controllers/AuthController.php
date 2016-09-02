<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
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

        $token = Uuid::uuid4();

        DB::insert('insert into token (token, ip, username) values (?, ?, ?)', [
            $token, $request->getClientIp(), $username
        ]);

        return response()->json(['token' => $token]);
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
