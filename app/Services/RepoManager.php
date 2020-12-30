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


    public function createRepository(string $name, string $url) {
        $folderName = Str::slug($name);

        $this->gitWrapper->cloneRepository($url, base_path() . "/repos/$folderName");

        Repository::create([
            'name' => $name,
            'url' => $url,
        ]);
    }
}
