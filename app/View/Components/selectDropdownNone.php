<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class selectDropdownNone extends Component
{
    /**
     * Create a new component instance.
     */

     public $id;
     public $name;
     public $options;
     public $label; 

    public function __construct($id, $name, $options, $label)
    {
        $this -> id = $id;
        $this -> name = $name;
        $this -> options = $options;
        $this -> label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-dropdown-none');
    }
}
