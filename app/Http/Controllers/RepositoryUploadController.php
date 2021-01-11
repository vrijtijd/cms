<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;

class RepositoryUploadController extends Controller
{
    public function index(Repository $repository) {
        return view('repositories.uploads.index', [
            'repository' => $repository,
        ]);
    }

    public function show(Repository $repository, string $path, RepositoryService $repositoryService) {
        [$file, $mimeType] = $repositoryService->getUpload($repository, $path);

        return response($file)->header('Content-Type', $mimeType);
    }
}
