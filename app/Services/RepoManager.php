<?php

namespace App\Services;

use App\Models\Repository;
use GitWrapper\GitWrapper;
use Illuminate\Support\Str;

class RepoManager {
    private $gitWrapper;

    public function __construct(GitWrapper $gitWrapper = null)
    {
        $this->gitWrapper = $gitWrapper ?: new GitWrapper();
    }


    public function createRepository(
        string $name,
        string $url,
        string $website = ''
    ) {
        $this->gitWrapper->cloneRepository($url, $this->getRepositoryDirectory($name));

        Repository::create([
            'name' => $name,
            'url' => $url,
            'website' => $website,
        ]);
    }

    public function deleteRepository(int $id) {
        $repository = Repository::find($id);
        $directory = $this->getRepositoryDirectory($repository->name);

        shell_exec("rm -rf $directory");

        $repository->delete();
    }

    private function getRepositoryDirectory(string $name) {
        $folderName = Str::slug($name);

        return base_path() . "/repos/$folderName";
    }
}
