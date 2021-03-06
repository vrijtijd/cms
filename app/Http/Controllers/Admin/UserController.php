<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::all(),
            'teams' => Team::all(),
            'roles' => Jetstream::$roles,
        ]);
    }

    public function store(Request $request, UserService $userService)
    {
        $userService->createUser(
            $request->input('name'),
            $request->input('email'),
            $request->input('team'),
            $request->input('role'),
        );

        return back();
    }
}
