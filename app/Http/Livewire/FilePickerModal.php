<?php

namespace App\Http\Livewire;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;
use Livewire\Component;

class FilePickerModal extends Component
{
    public $repository;
    public $filenames;
    public $isModalOpen = false;

    protected $listeners = [
        'openFilePicker',
        'filePicked' => 'closeFilePicker',
        'fileUploaded' => 'closeFilePicker',
    ];

    public function mount(Repository $repository, RepositoryService $repositoryService) {
        $this->repository = $repository;
        $this->filenames = $repositoryService->getUploads($repository);
    }

    public function render()
    {
        return view('livewire.file-picker-modal');
    }

    public function openFilePicker() {
        $this->isModalOpen = true;
    }

    public function closeFilePicker() {
        $this->isModalOpen = false;
    }
}
