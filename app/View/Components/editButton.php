<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class editButton extends Component
{
    public $target;
    /**
     * Create a new component instance.
     */
    public function __construct($target)
    {
        $this->target = $target;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.edit-button');
    }
}
