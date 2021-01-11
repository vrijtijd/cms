<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;

class RepositoryPublicFileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RepositoryService $repositoryService, Repository $repository, string $path = '')
    {
        [$file, $mimeType] = $repositoryService->getPublicFile($repository, $path);

        if ($file === null) {
            abort(404);
        }

        return response($file)->header('Content-Type', $mimeType);
    }
}
