<?php

namespace App\View\Components\Repositories\Changes;

use App\Models\Repository;
use App\Services\RepositoryService\Archetype;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Change extends Component
{
    public $changeType;
    public $fileName;
    public $label;
    public $link;
    public $oldFileName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $change, array $archetypes, Repository $repository)
    {
        $lineSegments = preg_split('/\s+/', $change);

        $this->changeType = $lineSegments[0];
        $this->oldFileName = ($lineSegments[0] === 'R' || $lineSegments[0] === 'D')
            ? $this->getTitleFromSlug($this->getSlugFromPath($lineSegments[1]))
            : null;

        [$topDir, $archetypeSlug, $filePath] = explode(
            '/',
            $lineSegments[0] === 'R' ? $lineSegments[3] : $lineSegments[1],
        );

        if ($topDir === 'content') {
            $archetype = Arr::first($archetypes, function(Archetype $archetype) use ($archetypeSlug) {
                return $archetype->getSlug() === $archetypeSlug;
            });

            $contentFile = $archetype->getContentFile(
                $this->getSlugFromPath($filePath)
            );

            $this->label = $archetype->getName();
            $this->fileName = $contentFile ? $contentFile->getName() : '';
            $this->link = $contentFile ? route('repositories.content.edit', [
                $repository->id,
                $archetype->getSlug(),
                $contentFile->getSlug(),
            ]) : '';

        } elseif ($topDir === 'static' && $archetypeSlug === 'uploads') {
            $this->label = 'Upload';
            $this->fileName = $this->getTitleFromSlug(
                $this->getSlugFromPath($filePath)
            );
            $this->link = route('repositories.uploads.show', [
                $repository->id,
                $filePath
            ]);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.repositories.changes.change');
    }

    private function getSlugFromPath(string $path) {
        return (string) Str::of($path)->basename('.md');
    }

    private function getTitleFromSlug(string $slug) {
        return Str::title(implode(' ', explode('-', $slug)));
    }
}
