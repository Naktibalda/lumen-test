<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Report extends Model implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $table = 'report';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'username', 'yesterday', 'today', 'blockers'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public static function getReportForToday($username)
    {
        $report = self::where('username', $username)->where('date', date('Y-m-d'))->first();
        if ($report) {
            return [
                'yesterday' => $report->yesterday,
                'today' => $report->today,
                'blockers' => $report->blockers,
            ];
        }

        $report = self::getLastReport($username);
        if ($report) {
            return [
                'yesterday' => $report->today,
                'today' => '',
                'blockers' => '',
            ];
        }

        return [
            'yesterday' => '',
            'today' => '',
            'blockers' => '',
        ];
    }

    public static function getLastReport($username)
    {
        return self::where('username', $username)->orderBy('date', 'desc')->take(1)->first();
    }
}
