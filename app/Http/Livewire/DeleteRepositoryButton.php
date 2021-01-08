<?php

namespace App\Http\Livewire;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;
use Livewire\Component;

class DeleteRepositoryButton extends Component
{
    public $isModalOpen = false;
    public $repositoryId;
    public $name;

    public function mount(
        int $repositoryId,
        string $name
    ) {
        $this->repositoryId = $repositoryId;
        $this->name = $name;
    }

    public function render()
    {
        return view('livewire.delete-repository-button');
    }

    public function deleteRepository(RepositoryService $repositoryService) {
        $repositoryService->deleteRepository(
            Repository::find($this->repositoryId)
        );

        return redirect()->route('admin.repositories.index', $this->repositoryId);
    }
}
