<?php

namespace App\Http\Livewire;

use App\Models\Repository;
use App\Services\RepoManager;
use Livewire\Component;

class RepositoryPreviewStatusBar extends Component
{
    public $repository;

    public function mount(Repository $repository) {
        $this->repository = $repository;
    }

    public function render()
    {
        return view('livewire.repository-preview-status-bar');
    }

    public function refreshPreview(RepoManager $repoManager) {
        $repoManager->build($this->repository);
        $this->emit('buildComplete');
    }
}
