<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;

class RepositoryStaticFileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RepositoryService $repositoryService, Repository $repository, string $path = '')
    {
        [$file, $mimeType] = $repositoryService->getStaticFile($repository, $path);

        return response($file)->header('Content-Type', $mimeType);
    }
}
