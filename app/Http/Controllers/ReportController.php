<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function __construct()
    {
    }

    public function create(Request $request)
    {
        $user = $request->user();

        //todo validate

        $yesterday = $request->input('yesterday');
        $today = $request->input('today');
        $blockers = $request->input('blockers');
        $date = date('Y-m-d');
        $username = $user->username;


        $attributes = [
            'date' => $date,
            'username' => $username,
            'yesterday' => $yesterday,
            'today' => $today,
            'blockers' => $blockers,
        ];

        $report = Report::where('username', $username)->where('date', $date)->first();
        if (!$report) {
            $report = new Report($attributes);
            $report->save();
        } else {
            $report->update($attributes);
        }

        return new JsonResponse($attributes);
    }

    public function get(Request $request)
    {
        $user = $request->user();

        $result = Report::getReportForToday($user->username);

        return new JsonResponse($result);
    }

    public function getAll(Request $request)
    {
        $result = [];

        return new JsonResponse($result);
    }

}
