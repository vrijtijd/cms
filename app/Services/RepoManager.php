<?php

namespace App\Services;

use App\Models\Repository;
use GitWrapper\GitWrapper;
use Illuminate\Support\Str;

use function Psy\debug;

class RepoManager {
    private $gitWrapper;

    public function __construct(GitWrapper $gitWrapper = null)
    {
        $this->gitWrapper = $gitWrapper ?: new GitWrapper();
    }


    public function createRepository(
        string $name,
        string $url,
        string $website,
        int $teamId
    ) {
        $this->gitWrapper->cloneRepository($url, $this->getRepositoryDirectory($name));

        Repository::create([
            'name' => $name,
            'url' => $url,
            'website' => $website,
            'team_id' => $teamId,
        ]);
    }

    public function deleteRepository(int $id) {
        $repository = Repository::find($id);
        $directory = $this->getRepositoryDirectory($repository->name);

        shell_exec("rm -rf $directory");

        $repository->delete();
    }

    public function getArchetypes(Repository $repository) {
        $rootDir = $this->getRepositoryDirectory($repository->name);

        $archetypeFiles = array_merge(
            glob($rootDir . '/archetypes/*.md'),
            glob($rootDir . '/themes/**/archetypes/*.md'),
        );

        return array_unique(array_map(function (string $file) {
            $basename = Str::of($file)->basename('.md');

            return Str::title(implode(' ', explode('-', $basename)));
        }, $archetypeFiles));
    }

    private function getRepositoryDirectory(string $name) {
        $folderName = Str::slug($name);

        return base_path() . "/repos/$folderName";
    }
}
