<?php

namespace App\Http\Livewire;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;
use Livewire\Component;

class DeleteRepositoryContentButton extends Component
{
    public $isModalOpen = false;
    public $repositoryId;
    public $archetypeSlug;
    public $contentFileSlug;
    public $title;

    public function mount(
        int $repositoryId,
        string $archetypeSlug,
        string $contentFileSlug,
        string $title
    ) {
        $this->repositoryId = $repositoryId;
        $this->archetypeSlug = $archetypeSlug;
        $this->contentFileSlug = $contentFileSlug;
        $this->title = $title;
    }

    public function render()
    {
        return view('livewire.delete-repository-content-button');
    }

    public function deleteContentFile(RepositoryService $repositoryService) {
        $repositoryService->getArchetype(Repository::find($this->repositoryId), $this->archetypeSlug)
                          ->getContentFile($this->contentFileSlug)
                          ->delete();

        return redirect()->route('repositories.content.index', [$this->repositoryId, $this->archetypeSlug]);
    }
}
