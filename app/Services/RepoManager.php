<?php

namespace App\Services;

use App\Models\Repository;
use DateTime;
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
        $dir = $this->getRepositoryDirectory($name);
        $this->gitWrapper->cloneRepository($url, $dir);

        $wasSuccessful = exec("cd $dir && yarn");

        if ($wasSuccessful) {
            Repository::create([
                'name' => $name,
                'url' => $url,
                'website' => $website,
                'team_id' => $teamId,
            ]);
        } else {
            exec("rm -rf $dir");
        }
    }

    public function pullRepository(Repository $repository) {
        return $this->gitWrapper
                    ->workingCopy($this->getRepositoryDirectory($repository->name))
                    ->pull();
    }

    public function deleteRepository(Repository $repository) {
        $directory = $this->getRepositoryDirectory($repository->name);

        exec("rm -rf $directory");

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

    public function createContentFile(Repository $repository, string $archetype, $title) {
        if (!trim($title)) $title = strtotime('now');

        $slug = Str::slug($title);

        $rootDir = $this->getRepositoryDirectory($repository->name);

        exec("cd $rootDir && hugo new $archetype/$slug.md");

        return new ContentFile("$rootDir/content/$archetype/$slug.md");
    }

    public function deleteContent(Repository $repository, string $archetype, string $slug) {
        $path = implode('/', [
            $this->getRepositoryDirectory($repository->name),
            'content',
            $archetype,
            "$slug.md"
        ]);

        exec("rm $path");
    }

    public function build(Repository $repository) {
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

    public function hasChanges(Repository $repository) {
        return $this->gitWrapper
                    ->workingCopy($this->getRepositoryDirectory($repository->name))
                    ->hasChanges();
    }

    public function publish(Repository $repository, string $commitMessage) {
        $workingCopy = $this->gitWrapper->workingCopy($this->getRepositoryDirectory($repository->name));
        $workingCopy->add('.');
        $workingCopy->commit($commitMessage);
        $workingCopy->push();
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

    public function update(string $slug, array $frontMatter, string $body) {
        $slug = Str::slug($slug);
        $this->frontMatter = $frontMatter;
        $this->body = $body;

        $fileHandle = fopen($this->path, 'w');

        foreach ($frontMatter as $key => $value) {
            if ($value === 'true' || $value === 'false') {
                $frontMatter[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            } elseif (is_numeric($value)) {
                $frontMatter[$key] = $value + 0;
            } elseif (strtotime($value)) {
                $frontMatter[$key] = new DateTime($value);
            }
        }

        $frontMatterYaml = trim(Yaml::dump($frontMatter));
        $body = str_replace("\r", '', $body);
        $body = preg_replace('/^[ \t\f]+|[ \t\f]+$/m', '', $body); // trim each line
        $body = preg_replace('/^(.+)$/m', '\1  ', $body); // force markdown newlines

        fwrite($fileHandle, <<<EOF
---
$frontMatterYaml
---
$body

EOF
);

        fclose($fileHandle);

        if ($this->slug !== $slug) {
            rename(
                $this->path,
                str_replace("{$this->slug}.md", "$slug.md", $this->path),
            );
            $this->slug = $slug;
        }

        return $this;
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
