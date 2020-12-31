<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Repository;
use App\Models\Team;
use App\Services\RepoManager;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    public function index() {
        return view('admin.repositories.index', [
            'repositories' => Repository::all(),
            'teams' => Team::all(),
        ]);
    }

    public function show(Repository $repository) {
        return view('repositories.show', [
            'repository' => $repository,
        ]);
    }

    public function store(Request $request, RepoManager $repoManager) {
        $request->validate([
            'name' => 'required',
            'url' => 'required',
            'website' => 'nullable|url',
            'team' => 'integer|exists:teams,id',
        ]);

        $repoManager->createRepository(
            $request->input('name'),
            $request->input('url'),
            $request->input('website', ''),
            $request->input('team'),
        );

        return back();
    }

    public function destroy(Repository $repository, RepoManager $repoManager) {
        $repoManager->deleteRepository($repository->id);

        return back();
    }
}
