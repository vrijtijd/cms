<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Events\TeamMemberAdded;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Rules\Role;

class AddTeamMember implements AddsTeamMembers
{
    public $userService;

    public function __construct(UserService $userService = null)
    {
        $this->userService = $userService ?: new UserService();
    }

    /**
     * Add a new team member to the given team.
     *
     * @param mixed $user
     * @param mixed $team
     *
     * @return void
     */
    public function add($user, $team, string $email, string $role = null)
    {
        Gate::forUser($user)->authorize('addTeamMember', $team);

        $this->validate($team, $email, $role);

        $user = User::where('email', $email)->first();

        if ($user) {
            $team->users()->attach($user, ['role' => $role]);
        } else {
            $user = $this->userService->createUser(
                explode('@', $email)[0],
                $email,
                $team->id,
                $role,
            );
        }

        TeamMemberAdded::dispatch($team, $user);
    }

    /**
     * Validate the add member operation.
     *
     * @param mixed $team
     *
     * @return void
     */
    protected function validate($team, string $email, ?string $role)
    {
        Validator::make([
            'email' => $email,
            'role' => $role,
        ], $this->rules())->after(
            $this->ensureUserIsNotAlreadyOnTeam($team, $email)
        )->validateWithBag('addTeamMember');
    }

    /**
     * Get the validation rules for adding a team member.
     *
     * @return array
     */
    protected function rules()
    {
        return array_filter([
            'email' => ['required', 'email'],
            'role' => Jetstream::hasRoles()
                            ? ['required', 'string', new Role()]
                            : null,
        ]);
    }

    /**
     * Ensure that the user is not already on the team.
     *
     * @param mixed $team
     *
     * @return \Closure
     */
    protected function ensureUserIsNotAlreadyOnTeam($team, string $email)
    {
        return function ($validator) use ($team, $email) {
            $validator->errors()->addIf(
                $team->hasUserWithEmail($email),
                'email',
                __('This user already belongs to the team.')
            );
        };
    }
}
