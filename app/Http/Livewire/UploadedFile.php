<?php

namespace App\Http\Livewire;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadedFile extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public $isModalOpen = false;
    public $replacementFile;
    public $repository;
    public $filename;
    public $timestamp;

    public function mount(Repository $repository, string $filename) {
        $this->repository = $repository;
        $this->filename = $filename;
        $this->timestamp = strtotime('now');
    }

    public function render()
    {
        return view('livewire.uploaded-file');
    }

    public function replace(RepositoryService $repositoryService) {
        $this->authorize('view', $this->repository);

        $this->validate([
            'replacementFile' => 'image',
        ]);

        $repositoryService->placeUploadedFile($this->repository, $this->filename, $this->replacementFile);
        $this->timestamp = strtotime('now');
    }

    public function delete(RepositoryService $repositoryService) {
        $this->authorize('view', $this->repository);

        $repositoryService->deleteUploadedFile($this->repository, $this->filename);
        $this->emit('fileDeleted');
    }
}
