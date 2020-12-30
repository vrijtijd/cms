<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Repository;
use App\Services\RepoManager;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    public function index() {
        return view('admin.repositories.index', [
            'repositories' => Repository::all(),
        ]);
    }

    public function store(Request $request, RepoManager $repoManager) {
        $request->validate([
            'name' => 'required',
            'url' => 'required',
            'website' => 'nullable|url',
        ]);

        $repoManager->createRepository(
            $request->input('name'),
            $request->input('url'),
            $request->input('website', ''),
        );

        return back();
    }

    public function destroy(Repository $repository, RepoManager $repoManager) {
        $repoManager->deleteRepository($repository->id);

        return back();
    }
}
