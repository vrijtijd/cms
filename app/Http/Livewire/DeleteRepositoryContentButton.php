<?php

namespace App\Http\Livewire;

use App\Models\Repository;
use App\Services\RepoManager;
use Livewire\Component;

class DeleteRepositoryContentButton extends Component
{
    public $isModalOpen = false;
    public $repositoryId;
    public $archetype;
    public $slug;
    public $title;

    public function mount(
        int $repositoryId,
        string $archetype,
        string $slug,
        string $title
    ) {
        $this->repositoryId = $repositoryId;
        $this->archetype = strtolower($archetype);
        $this->slug = $slug;
        $this->title = $title;
    }

    public function render()
    {
        return view('livewire.delete-repository-content-button');
    }

    public function deleteContentFile(RepoManager $repoManager) {
        $repoManager->deleteContent(
            Repository::find($this->repositoryId),
            $this->archetype,
            $this->slug,
        );

        return redirect()->route('repositories.content.index', [$this->repositoryId, $this->archetype]);
    }
}
