<?php

namespace App\Http\Livewire;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class FilePickerModal extends Component
{
    use AuthorizesRequests;

    public $repository;
    public $filenames;
    public $isModalOpen = false;

    protected $listeners = [
        'openFilePicker',
        'filePicked' => 'closeFilePicker',
        'fileUploaded' => 'closeFilePicker',
    ];

    public function mount(Repository $repository, RepositoryService $repositoryService)
    {
        $this->repository = $repository;
        $this->refresh($repositoryService);
    }

    public function render()
    {
        return view('livewire.file-picker-modal');
    }

    public function openFilePicker()
    {
        $this->isModalOpen = true;
    }

    public function closeFilePicker(RepositoryService $repositoryService)
    {
        $this->isModalOpen = false;
        $this->refresh($repositoryService);
    }

    public function refresh(RepositoryService $repositoryService)
    {
        $this->authorize('view', $this->repository);

        $this->filenames = $repositoryService->getUploads($this->repository);
    }
}
