<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;
use Illuminate\Http\Request;

class PublishRepositoryController extends Controller
{
    public function __invoke(Request $request, RepositoryService $repositoryService, Repository $repository) {
        if ($request->method() === 'PUT') {
            $request->validate(['commitMessage' => 'string|required']);

            $repositoryService->pushRepositoryChanges($repository, $request->input('commitMessage'));

            return redirect()->route('repositories.publish', [$repository->id])->with('published', true);
        }

        return view('repositories.publish', [
            'repository' => $repository,
            'hasChanges' => $repositoryService->doesRepositoryHaveChanges($repository),
        ]);
    }
}
