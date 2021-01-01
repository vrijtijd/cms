<?php

namespace App\Http\Controllers;

use App\Models\Repository;

class RepositoryPreviewController extends Controller
{
    public function __invoke(Repository $repository) {
        return view('repositories.preview', [
            'repository' => $repository,
        ]);
    }
}
