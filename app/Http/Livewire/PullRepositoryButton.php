<?php

namespace App\Http\Livewire;

use App\Jobs\PullRepositoryJob;
use App\Models\Repository;
use Livewire\Component;

class PullRepositoryButton extends Component
{
    public $repository;

    public function mount(Repository $repository) {
        $this->repository = $repository;
    }

    public function render()
    {
        return view('livewire.pull-repository-button');
    }

    public function pullRepository() {
        dispatch(new PullRepositoryJob($this->repository));
        session()->flash('success', true);
    }
}
