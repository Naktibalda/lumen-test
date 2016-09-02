<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public static function getByToken($token)
    {
        $result = DB::select('SELECT u.username, u.name FROM user u JOIN token t USING(username) WHERE t.token = ?',
                        [$token]);
        if (!empty($result)) {
            return new self((array)$result[0]);
        }
    }

    public static function getByUsername($username)
    {
        $result = DB::select('SELECT u.username, u.name FROM user u WHERE username = ?', [$username]);
        if (!empty($result)) {
            return new self((array)$result[0]);
        }
    }
}
