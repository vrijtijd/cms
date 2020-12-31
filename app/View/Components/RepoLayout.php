<?php

namespace App\View\Components;

use App\Models\Repository;
use Illuminate\View\Component;

class RepoLayout extends Component
{
    public $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.repo');
    }
}
