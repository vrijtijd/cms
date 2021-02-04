<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RepositoryRequest;
use App\Jobs\CloneRepository;
use App\Models\Repository;
use App\Models\Team;
use App\Services\RepositoryService\RepositoryService;

class RepositoryController extends Controller
{
    public function index()
    {
        return view('admin.repositories.index', [
            'repositories' => Repository::all(),
            'teams' => Team::all(),
        ]);
    }

    public function show(Repository $repository)
    {
        return view('repositories.show', [
            'repository' => $repository,
        ]);
    }

    public function store(RepositoryRequest $request)
    {
        dispatch(new CloneRepository(
            $request->input('name'),
            $request->input('url'),
            $request->input('website') ?: '',
            $request->input('team'),
        ));

        return back();
    }

    public function edit(Repository $repository)
    {
        return view('admin.repositories.edit', [
            'repository' => $repository,
            'teams' => Team::all(),
        ]);
    }

    public function update(RepositoryRequest $request, Repository $repository, RepositoryService $repositoryService)
    {
        $repositoryService->updateRepository(
            $repository,
            $request->input('name'),
            $request->input('url'),
            $request->input('website') ?: '',
            $request->input('team'),
        );

        return back()->with('updated', true);
    }
}
