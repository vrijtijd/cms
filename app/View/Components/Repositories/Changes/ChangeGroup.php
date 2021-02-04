<?php

namespace App\View\Components\Repositories\Changes;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;
use Illuminate\View\Component;

class ChangeGroup extends Component
{
    public $archetypes;
    public $changeType;
    public $changes;
    public $repository;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $changeType, array $changes, Repository $repository, RepositoryService $repositoryService)
    {
        $this->archetypes = $repositoryService->getArchetypes($repository);
        $this->changeType = $changeType;
        $this->changes = $changes;
        $this->repository = $repository;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.repositories.changes.change-group');
    }
}
