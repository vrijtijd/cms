<?php

namespace App\Http\Livewire;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class DeleteRepositoryContentButton extends Component
{
    use AuthorizesRequests;

    public $isModalOpen = false;
    public $repository;
    public $archetypeSlug;
    public $contentFileSlug;
    public $title;

    public function mount(
        Repository $repository,
        string $archetypeSlug,
        string $contentFileSlug,
        string $title
    ) {
        $this->repository = $repository;
        $this->archetypeSlug = $archetypeSlug;
        $this->contentFileSlug = $contentFileSlug;
        $this->title = $title;
    }

    public function render()
    {
        return view('livewire.delete-repository-content-button');
    }

    public function deleteContentFile(RepositoryService $repositoryService)
    {
        $this->authorize('view', $this->repository);

        $repositoryService->getArchetype($this->repository, $this->archetypeSlug)
                          ->getContentFile($this->contentFileSlug)
                          ->delete();

        return redirect()->route('repositories.content.index', [$this->repository->id, $this->archetypeSlug]);
    }
}
