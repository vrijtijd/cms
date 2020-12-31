<?php

namespace App\View\Components;

use App\Models\Repository;
use App\Services\RepoManager;
use Illuminate\View\Component;

class RepoSidebar extends Component
{
    public $repository;
    public $archetypes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Repository $repository, RepoManager $repoManager)
    {
        $this->repository = $repository;
        $this->archetypes = $repoManager->getArchetypes($repository);
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
