<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class createButton extends Component
{   
    public $name;
    public $target;
    /**
     * Create a new component instance.
     */
    public function __construct($name, $target)
    {
        $this->name = $name;
        $this->target = $target;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.create-button');
    }
}
