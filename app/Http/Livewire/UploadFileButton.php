<?php

namespace App\Http\Livewire;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadFileButton extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $repository;
    public $file;

    public function mount(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function render()
    {
        return view('livewire.upload-file-button');
    }

    public function upload(RepositoryService $repositoryService)
    {
        $this->authorize('view', $this->repository);

        $this->validate([
            'file' => 'image',
        ]);

        $filename = $repositoryService->addUploadedFile($this->repository, $this->file);
        $this->emit('fileUploaded', $filename);
    }
}
