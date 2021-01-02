<?php

namespace App\View\Components\Repositories\Content;

use DateTime;
use Illuminate\View\Component;

class DateInput extends Component
{
    public $label;
    public $name;
    public $date;
    public $dateName;
    public $timeName;
    public $dateValue;
    public $timeValue;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label, string $name, DateTime $date)
    {
        $this->label = $label;
        $this->name = $name;
        $this->dateName = md5($name . 'date');
        $this->timeName = md5($name . 'time');

        $timezone = $date->format('P');
        $this->date = $date;
        if (old($this->dateName)) {
            $this->date = new DateTime(
                old($this->dateName) . 'T' . old($this->timeName) . $timezone
            );
        }

        $this->dateValue = $this->date->format('Y-m-d');
        $this->timeValue = $this->date->format('H:i');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.repositories.content.date-input');
    }
}
