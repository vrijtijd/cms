<?php

namespace App\View\Components\Repositories\Content;

use Illuminate\View\Component;

class FrontMatterInput extends Component
{
    public $name;
    public $value;
    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;

        $type = gettype($value);
        if ($type === 'object') $type = get_class($value);
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.repositories.content.front-matter-input');
    }
}
