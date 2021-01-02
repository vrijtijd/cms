<?php

namespace App\Http\Livewire;

use App\Models\Repository;
use App\Services\RepoManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PublishRepositoryForm extends Component
{
    use AuthorizesRequests;

    public $repository;
    public $commitMessage;

    public function mount(Repository $repository) {
        $this->repository = $repository;
        $this->commitMessage = Auth::user()->name . ' publishing changes from ' . config('app.url');
    }

    public function render()
    {
        return view('livewire.publish-repository-form');
    }

    public function publish(RepoManager $repoManager) {
        $this->authorize('view', $this->repository);

        $repoManager->publish($this->repository, $this->commitMessage);
    }
}
