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

        $row = [
            'date' => date('Y-m-d'),
            'username' => $user->username,
            'yesterday' => $yesterday,
            'today' => $today,
            'blockers' => $blockers,
        ];

        $report = new Report($row);
        $report->save();

        return new JsonResponse($row);
    }

}
