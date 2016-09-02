<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
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

    public static function getMyReportForToday($username)
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

    public static function getReportForDate($date)
    {
        $query = "
            SELECT
              u.username,
              u.name,
              IFNULL(r.yesterday, '') AS yesterday,
              IFNULL(r.today, '') AS today,
              IFNULL(r.blockers, '') AS blockers
            FROM user u
            LEFT JOIN report r
              ON u.username = r.username AND r.date = ?";
        return DB::select($query, [$date]);
    }
}
