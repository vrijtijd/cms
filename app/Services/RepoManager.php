<?php

namespace App\Services;

use App\Models\Repository;
use GitWrapper\GitWrapper;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

function convertArchetypeSlugToTitle(string $slug) {
    return Str::title(implode(' ', explode('-', $slug)));
}

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

    public function isValidArchetype(Repository $repository, string $archetype) {
        return in_array(
            convertArchetypeSlugToTitle($archetype),
            $this->getArchetypes($repository),
        );
    }

    public function getArchetypes(Repository $repository) {
        $archetypeFiles = $this->getArchetypeFiles($repository);

        return array_unique(array_map(function (string $file) {
            return convertArchetypeSlugToTitle(
                Str::of($file)->basename('.md')
            );
        }, $archetypeFiles));
    }

    public function getContentFiles(Repository $repository, string $archetype) {
        $rootDir = $this->getRepositoryDirectory($repository->name);

        return array_map(function ($path) {
            return new ContentFile($path);
        }, glob("$rootDir/content/$archetype/*.md"));
    }

    public function getContentFile(Repository $repository, string $archetype, string $slug) {
        $rootDir = $this->getRepositoryDirectory($repository->name);
        $path = "$rootDir/content/$archetype/$slug.md";

        return new ContentFile($path);
    }

    public function deleteContent(Repository $repository, string $archetype, string $slug) {
        $path = implode('/', [
            $this->getRepositoryDirectory($repository->name),
            'content',
            $archetype,
            "$slug.md"
        ]);

        shell_exec("rm -rf $path");
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

class ContentFile {
    private $path;
    private $slug;
    private $name;
    private $frontMatter;
    private $body;

    public function __construct(string $path) {
        $this->path = $path;
        $this->slug = Str::of($path)->basename('.md');
        $this->name = convertArchetypeSlugToTitle($this->slug);
    }

    public function getName() {
        return $this->name;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getFrontMatter() {
        if (!$this->frontMatter) $this->readFile();

        return $this->frontMatter;
    }

    public function getBody() {
        if (!$this->body) $this->readFile();

        return $this->body;
    }

    public function update(array $frontMatter, string $body) {
        $this->frontMatter = $frontMatter;
        $this->body = $body;

        $fileHandle = fopen($this->path, 'w');

        $frontMatterYaml = trim(Yaml::dump($frontMatter));
        $body = str_replace("\r", '', $body);

        fwrite($fileHandle, <<<EOF
---
$frontMatterYaml
---
$body

EOF
);

        fclose($fileHandle);
    }

    private function readFile() {
        $fileHandle = fopen($this->path, 'r');

        $frontMatter = '';
        $body = '';

        $isReadingFrontMatter = false;

        while (($line = fgets($fileHandle)) !== false) {
            if (preg_match('/^-+$/', $line)) {
                $isReadingFrontMatter = !$isReadingFrontMatter;
                continue;
            }

            if ($isReadingFrontMatter) {
                $frontMatter .= $line;
            } else {
                $body .= $line;
            }
        }

        fclose($fileHandle);

        $this->frontMatter = Yaml::parse($frontMatter, Yaml::PARSE_DATETIME);
        $this->body = $body;
    }
}
