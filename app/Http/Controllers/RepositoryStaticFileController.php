<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use App\Services\RepoManager;
use Illuminate\Http\Request;

class RepositoryStaticFileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RepoManager $repoManager, Repository $repository, string $path = '')
    {
        [$file, $mimeType] = $repoManager->getStaticFile($repository, $path);

        return response($file)->header('Content-Type', $mimeType);
    }
}
