<?php

namespace App\Services\RepositoryService;

use App\Models\Repository;
use GitWrapper\GitWrapper;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class RepositoryService {
    private $gitWrapper;

    public function __construct(GitWrapper $gitWrapper = null)
    {
        $this->gitWrapper = $gitWrapper ?: new GitWrapper();
    }

    public function cloneRepository(
        string $name,
        string $url,
        string $website,
        int $teamId
    ) {
        $dir = $this->getRepositoryDirectory($name);
        $this->gitWrapper->cloneRepository($url, $dir);

        $wasSuccessful = exec("cd $dir && yarn");

        if (!$wasSuccessful) {
            exec("rm -rf $dir");

            return null;
        }

        return Repository::create([
            'name' => $name,
            'url' => $url,
            'website' => $website,
            'team_id' => $teamId,
        ]);
    }

    public function pullRepository(Repository $repository) {
        return $this->gitWrapper
                    ->workingCopy($this->getRepositoryDirectory($repository->name))
                    ->pull();
    }

    public function pushRepositoryChanges(Repository $repository, string $commitMessage) {
        $workingCopy = $this->gitWrapper->workingCopy($this->getRepositoryDirectory($repository->name));
        $workingCopy->add('.');
        $workingCopy->commit($commitMessage);
        $workingCopy->push();
    }

    public function updateRepository(Repository $repository, string $name, string $url, string $website, int $teamId) {
        $workingCopy = $this->gitWrapper->workingCopy($this->getRepositoryDirectory($repository->name));
        $workingCopy->remote("set-url", "origin", $url);

        $oldDir = $this->getRepositoryDirectory($repository->name);
        $newDir = $this->getRepositoryDirectory($name);

        $repository->update([
            'name' => $name,
            'url' => $url,
            'website' => $website,
            'team_id' => $teamId,
        ]);

        exec("mv $oldDir $newDir");
    }

    public function deleteRepository(Repository $repository) {
        $directory = $this->getRepositoryDirectory($repository->name);

        exec("rm -rf $directory");

        $repository->delete();
    }

    public function getChanges(Repository $repository) {
        $workingCopy = $this->gitWrapper->workingCopy($this->getRepositoryDirectory($repository->name));
        $workingCopy->add('.');

        $status = trim($workingCopy->status('--short'));

        if (strlen($status) === 0) return [];

        $statusLines = explode("\n", $status);

        $archetypes = $this->getArchetypes($repository);

        $changes = array_map(function ($statusLine) use ($archetypes) {
            return new ContentChange($statusLine, $archetypes);
        }, $statusLines);

        return collect($changes)->groupBy(function (ContentChange $contentChange) {
            return $contentChange->getType();
        });

    }

    public function getArchetype(Repository $repository, string $archetypeSlug) {
        return Arr::first($this->getArchetypes($repository), function (Archetype $archetype) use ($archetypeSlug) {
            return $archetype->getSlug() === $archetypeSlug;
        });
    }

    public function getArchetypes(Repository $repository) {
        $archetypeFiles = $this->getArchetypeFiles($repository);
        $repositoryDir = $this->getRepositoryDirectory($repository->name);

        return array_unique(array_map(function (string $path) use ($repositoryDir) {
            return new Archetype($path, $repositoryDir);
        }, $archetypeFiles));
    }

    public function runBuild(Repository $repository) {
        $rootDir = $this->getRepositoryDirectory($repository->name);
        $appUrl = config('app.url');
        $baseUrl = "$appUrl/repositories/{$repository->id}/preview/p/";

        exec("cd $rootDir && yarn && NODE_ENV=production HUGO_BASEURL='$baseUrl' hugo");
    }

    public function getStaticFile(Repository $repository, string $relativePath) {
        $rootDir = $this->getRepositoryDirectory($repository->name);
        $relativePath = str_replace('../', '', $relativePath);

        $path = "$rootDir/public/$relativePath";
        $mimeType = mime_content_type($path);

        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if (empty($extension)) {
            $path .= "/index.html";
            $mimeType = 'text/html';
        } elseif ($extension === 'css') {
            $mimeType = 'text/css';
        } elseif ($extension === 'js') {
            $mimeType = 'application/javascript';
        }

        return [
            file_get_contents($path),
            $mimeType,
        ];
    }

    public function doesRepositoryDirectoryExist(string $name) {
        $rootDir = $this->getRepositoryDirectory($name);

        return is_dir($rootDir) || file_exists($rootDir);
    }

    private function getRepositoryDirectory(string $name) {
        $folderName = Str::slug($name);

        return base_path() . "/repos/$folderName";
    }

    private function getArchetypeFiles(Repository $repository) {
        $rootDir = $this->getRepositoryDirectory($repository->name);

        return array_merge(
            glob($rootDir . '/archetypes/*.md'),
            glob($rootDir . '/themes/**/archetypes/*.md'),
        );
    }
}
