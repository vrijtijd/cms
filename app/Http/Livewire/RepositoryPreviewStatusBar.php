<?php

namespace App\Http\Livewire;

use App\Models\Repository;
use App\Services\RepoManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class RepositoryPreviewStatusBar extends Component
{
    use AuthorizesRequests;

    public $repository;

    protected $listeners = ['buildStarted' => 'refreshPreview'];

    public function mount(Repository $repository) {
        $this->repository = $repository;
    }

    public function render()
    {
        return view('livewire.repository-preview-status-bar');
    }

    public function refreshPreview(RepoManager $repoManager) {
        $this->authorize('view', $this->repository);

        $repoManager->build($this->repository);
        $this->emit('buildComplete');
    }
}
