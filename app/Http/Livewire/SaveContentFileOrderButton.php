<?php

namespace App\Http\Livewire;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SaveContentFileOrderButton extends Component
{
    use AuthorizesRequests;

    public $hasChanges = false;
    public $repository;
    public $archetypeSlug;

    protected $listeners = [
        'saveOrder',
        'changeMade' => 'showSaveButton',
    ];

    public function mount(Repository $repository, string $archetypeSlug)
    {
        $this->repository = $repository;
        $this->archetypeSlug = $archetypeSlug;
    }

    public function render()
    {
        return view('livewire.save-content-file-order-button');
    }

    public function showSaveButton()
    {
        $this->hasChanges = true;
    }

    public function saveOrder(array $orderedContentFiles, RepositoryService $repositoryService)
    {
        $this->authorize('view', $this->repository);

        $archetype = $repositoryService->getArchetype($this->repository, $this->archetypeSlug);

        foreach ($orderedContentFiles as [$contentFileSlug, $weight]) {
            $archetype->getContentFile($contentFileSlug)->setWeight($weight);
        }

        $this->hasChanges = false;
        $this->emit('changesSaved');
    }
}
