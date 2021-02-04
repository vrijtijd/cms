<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;

class PreviewRepositoryController extends Controller
{
    public function __invoke(Request $request, Repository $repository)
    {
        return view('repositories.preview', [
            'repository' => $repository,
            'page' => $request->query('page', 'index.html'),
        ]);
    }
}
