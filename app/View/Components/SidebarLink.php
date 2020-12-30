<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class SidebarLink extends Component
{
    public $href;
    public $isCurrent;
    public $icon;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $href, string $icon)
    {
        $this->href = $href;
        $this->isCurrent = Request::fullUrlIs($href);
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.sidebar-link');
    }
}
