<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Ramsey\Uuid\Uuid;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
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

}
