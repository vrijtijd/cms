<?php

namespace App\Services\RepositoryService;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ContentChange {
    private $type;
    private $oldSlug;
    private $archetype;
    private $contentFile;

    public function __construct(string $gitStatusLine, array $archetypes) {
        $lineSegments = preg_split('/\s+/', $gitStatusLine);

        $this->type = $lineSegments[0];
        $this->oldSlug = ($lineSegments[0] === 'R' || $lineSegments[0] === 'D')
            ? $this->getSlugFromPath($lineSegments[1])
            : null;

        [, $archetypeSlug, $contentFilePath] = explode(
            '/',
            $lineSegments[0] === 'R' ? $lineSegments[3] : $lineSegments[1],
        );

        $this->archetype = Arr::first($archetypes, function(Archetype $archetype) use ($archetypeSlug) {
            return $archetype->getSlug() === $archetypeSlug;
        });

        $this->contentFile = $this->archetype->getContentFile(
            $this->getSlugFromPath($contentFilePath)
        );
    }

    public function getType() {
        return $this->type;
    }

    public function getOldName() {
        return Str::title(implode(' ', explode('-', $this->oldSlug)));
    }

    public function getContentFile() {
        return $this->contentFile;
    }

    public function getArchetype() {
        return $this->archetype;
    }

    private function getSlugFromPath($path) {
        return (string) Str::of($path)->basename('.md');
    }
}
