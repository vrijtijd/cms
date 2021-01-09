<?php

namespace App\View\Components\Repositories;

use App\Models\Repository;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Form extends Component
{
    public $action;
    public $isEdit;
    public $method;
    public $repository;
    public $route;
    public $teams;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Repository $repository, Collection $teams)
    {
        $this->isEdit = isset($repository->id);
        $this->repository = $repository ?: new Repository();
        $this->teams = $teams;
        $this->method = $this->isEdit ? 'PUT' : 'POST';
        $this->action = $this->isEdit
            ? route('admin.repositories.update', $repository->id)
            : route('admin.repositories.store');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.repositories.form');
    }
}
