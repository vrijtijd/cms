<?php

namespace App\Http\Livewire;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;
use Livewire\Component;

class UploadedFileList extends Component
{
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
        $this->filenames = $repositoryService->getUploads($this->repository);
    }
}
