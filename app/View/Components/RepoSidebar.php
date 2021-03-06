<?php

namespace App\View\Components;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;
use Illuminate\View\Component;

class RepoSidebar extends Component
{
    public $repository;
    public $archetypes;
    public $hasChanges;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Repository $repository, RepositoryService $repositoryService)
    {
        $this->repository = $repository;
        $this->archetypes = $repositoryService->getArchetypes($repository);
        $this->hasChanges = $repositoryService->hasChanges($repository);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.repo-sidebar');
    }
}
