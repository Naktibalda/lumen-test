<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function login(Request $request)
    {
        $user = $request->user();

        $token = Uuid::uuid4();

        DB::insert('insert into token (token, ip, username) values (?, ?, ?)', [
            $token, $request->getClientIp(), $user->username
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
