<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        return view('admin.teams.index', [
            'teams' => Team::all(),
        ]);
    }
}
