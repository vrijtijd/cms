<?php

namespace App\Http\Livewire;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class DeleteRepositoryButton extends Component
{
    use AuthorizesRequests;

    public $isModalOpen = false;
    public $repository;
    public $name;

    public function mount(
        Repository $repository,
        string $name
    ) {
        $this->repository = $repository;
        $this->name = $name;
    }

    public function render()
    {
        return view('livewire.delete-repository-button');
    }

    public function deleteRepository(RepositoryService $repositoryService) {
        $this->authorize('view', $this->repository);

        $repositoryService->deleteRepository($this->repository);

        return redirect()->route('admin.repositories.index', $this->repository->id);
    }
}
