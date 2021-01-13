<?php

namespace App\Http\Livewire;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class UploadedFileList extends Component
{
    use AuthorizesRequests;

    public $repository;
    public $filenames;

    protected $listeners = [
        'fileUploaded' => 'refresh',
        'fileDeleted' => 'refresh',
    ];

    public function mount(Repository $repository, RepositoryService $repositoryService) {
        $this->repository = $repository;

        $this->refresh($repositoryService);
    }

    public function render()
    {
        return view('livewire.uploaded-file-list');
    }

    public function refresh(RepositoryService $repositoryService) {
        $this->authorize('view', $this->repository);

        $this->filenames = $repositoryService->getUploads($this->repository);
    }
}
