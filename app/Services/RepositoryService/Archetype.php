<?php

namespace App\Services\RepositoryService;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Archetype {
    private $slug;
    private $repositoryDir;

    public function __construct(string $path, string $repositoryDir)
    {
        $this->slug = (string) Str::of($path)->basename('.md');
        $this->repositoryDir = $repositoryDir;
    }

    public function getName() {
        return Str::title(implode(' ', explode('-', $this->slug)));
    }

    public function getSlug() {
        return $this->slug;
    }

    public function __toString()
    {
        return $this->slug;
    }

    public function getContentFiles() {
        return array_map(function ($path) {
            return new ContentFile($path, $this);
        }, glob("{$this->repositoryDir}/content/{$this->slug}/*.md"));
    }

    public function getContentFile(string $slug) {
        return Arr::first($this->getContentFiles(), function ($contentFile) use ($slug) {
            return $contentFile->getSlug() === $slug;
        });
    }

    public function createContentFile(
        string $title,
        int $timezoneOffsetInMinutes
    ) {
        if (!trim($title)) $title = strtotime('now');

        $contentFileSlug = Str::slug($title);

        exec("cd {$this->repositoryDir} && hugo new {$this->slug}/$contentFileSlug.md");

        return (new ContentFile(
            "{$this->repositoryDir}/content/{$this->slug}/$contentFileSlug.md",
            $this
        ))->applyTimezoneOffset($timezoneOffsetInMinutes);
    }

    public function hasSingleView() {
        $themeFiles = array_merge(
            glob("{$this->repositoryDir}/layouts/{$this->slug}/single.html"),
            glob("{$this->repositoryDir}/themes/**/layouts/{$this->slug}/single.html"),
        );

        return count($themeFiles) > 0;
    }
}
