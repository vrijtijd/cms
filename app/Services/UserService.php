<?php

namespace App\Services;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    public $userCreator;

    public function __construct(CreateNewUser $userCreator = null)
    {
        $this->userCreator = $userCreator ?: new CreateNewUser();
    }

    public function createUser(string $name, string $email, $teamId, string $role)
    {
        return DB::transaction(function () use ($name, $email, $teamId, $role) {
            $password = (string) rand();

            return tap($this->userCreator->create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $password,
            ], $teamId === null), function (User $user) use ($teamId, $role) {
                if ($teamId !== null) {
                    $team = Team::find($teamId);

                    $team->users()->attach($user->id, ['role' => $role]);
                }
            });
        });
    }
}
