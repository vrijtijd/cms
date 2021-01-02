<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use App\Services\RepoManager;

class PublishRepositoryController extends Controller
{
    public function __invoke(RepoManager $repoManager, Repository $repository) {
        return view('repositories.publish', [
            'repository' => $repository,
            'hasChanges' => $repoManager->hasChanges($repository),
        ]);
    }
}
