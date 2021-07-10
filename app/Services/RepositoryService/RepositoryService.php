<?php

namespace App\Services\RepositoryService;

use App\Models\Repository;
use ErrorException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;
use Symplify\GitWrapper\GitWrapper;

class RepositoryService
{
    private $gitWrapper;

    public function __construct(GitWrapper $gitWrapper = null)
    {
        $this->gitWrapper = $gitWrapper ?: new GitWrapper(exec('which git'));
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

    public function pullRepository(Repository $repository)
    {
        return $this->gitWrapper
                    ->workingCopy($this->getRepositoryDirectory($repository->name))
                    ->pull();
    }

    public function pushRepositoryChanges(Repository $repository, string $commitMessage)
    {
        $workingCopy = $this->gitWrapper->workingCopy($this->getRepositoryDirectory($repository->name));
        $workingCopy->add('.');
        $workingCopy->commit($commitMessage);
        $workingCopy->push();
    }

    public function updateRepository(Repository $repository, string $name, string $url, string $website, int $teamId)
    {
        $workingCopy = $this->gitWrapper->workingCopy($this->getRepositoryDirectory($repository->name));
        $workingCopy->remote('set-url', 'origin', $url);

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

    public function deleteRepository(Repository $repository)
    {
        $directory = $this->getRepositoryDirectory($repository->name);

        exec("rm -rf $directory");

        $repository->delete();
    }

    public function hasChanges(Repository $repository)
    {
        return count($this->getChanges($repository)) > 0;
    }

    public function getChanges(Repository $repository)
    {
        $workingCopy = $this->gitWrapper->workingCopy($this->getRepositoryDirectory($repository->name));
        $workingCopy->add('.');

        $status = trim($workingCopy->status('--short'));

        if (strlen($status) === 0) {
            return [];
        }

        $statusLines = explode("\n", $status);

        return collect($statusLines)->filter(function (string $statusLine) {
            return preg_match('/^\w\s+(content|static)/', $statusLine);
        })->groupBy(function (string $statusLine) {
            return $statusLine[0];
        })->toArray();
    }

    public function getArchetype(Repository $repository, string $archetypeSlug)
    {
        return Arr::first($this->getArchetypes($repository), function (Archetype $archetype) use ($archetypeSlug) {
            return $archetype->getSlug() === $archetypeSlug;
        });
    }

    public function getArchetypes(Repository $repository)
    {
        $archetypeFiles = $this->getArchetypeFiles($repository);
        $repositoryDir = $this->getRepositoryDirectory($repository->name);

        return array_unique(array_map(function (string $path) use ($repositoryDir) {
            return new Archetype($path, $repositoryDir);
        }, $archetypeFiles));
    }

    public function runBuild(Repository $repository)
    {
        $rootDir = $this->getRepositoryDirectory($repository->name);
        $appUrl = config('app.url');
        $baseUrl = "$appUrl/repositories/{$repository->id}/preview/p/";
        $cacheDir = env('HUGO_CACHEDIR', '');

        exec(implode(' ', [
            "cd $rootDir",
            '&& yarn',
            "&& NODE_ENV=production HUGO_BASEURL='$baseUrl'",
            empty($cacheDir) ? '' : "HUGO_CACHEDIR=$cacheDir",
            'hugo',
        ]));
    }

    public function getPublicFile(Repository $repository, string $relativePath)
    {
        return $this->getFile($repository, "public/$relativePath");
    }

    public function doesRepositoryDirectoryExist(string $name)
    {
        $rootDir = $this->getRepositoryDirectory($name);

        return is_dir($rootDir) || file_exists($rootDir);
    }

    public function getUploads(Repository $repository)
    {
        $rootDir = $this->getRepositoryDirectory($repository->name);
        $uploads = glob("$rootDir/static/uploads/**");

        return array_map(function ($path) use ($rootDir) {
            return str_replace("$rootDir/static/uploads/", '', $path);
        }, $uploads);
    }

    public function getUpload(Repository $repository, string $path)
    {
        return $this->getFile($repository, "/static/uploads/$path");
    }

    public function addUploadedFile(Repository $repository, TemporaryUploadedFile $file)
    {
        $tempPath = $file->getRealPath();
        $extension = pathinfo($tempPath, PATHINFO_EXTENSION);

        do {
            $filename = substr(md5(rand()), 10).'.'.$extension;
        } while (file_exists($filename));

        $this->placeUploadedFile($repository, $filename, $file);

        return $filename;
    }

    public function placeUploadedFile(Repository $repository, string $filename, TemporaryUploadedFile $file)
    {
        $rootDir = $this->getRepositoryDirectory($repository->name);

        rename($file->getRealPath(), "$rootDir/static/uploads/$filename");
    }

    public function deleteUploadedFile(Repository $repository, string $filename)
    {
        $rootDir = $this->getRepositoryDirectory($repository->name);

        unlink("$rootDir/static/uploads/$filename");
    }

    private function getRepositoryDirectory(string $name)
    {
        $folderName = Str::slug($name);

        return base_path()."/repos/$folderName";
    }

    private function getArchetypeFiles(Repository $repository)
    {
        $rootDir = $this->getRepositoryDirectory($repository->name);

        return array_merge(
            glob($rootDir.'/archetypes/*.md'),
            glob($rootDir.'/themes/**/archetypes/*.md'),
        );
    }

    private function getFile(Repository $repository, string $relativePath)
    {
        $rootDir = $this->getRepositoryDirectory($repository->name);
        $relativePath = str_replace('../', '', $relativePath);

        $path = "$rootDir/$relativePath";
        try {
            $mimeType = mime_content_type($path);
        } catch (ErrorException $e) {
            return [null, null];
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if (empty($extension)) {
            $path .= '/index.html';
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
}
