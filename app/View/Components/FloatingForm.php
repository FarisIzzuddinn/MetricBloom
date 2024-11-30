<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FloatingForm extends Component
{
    public $id;
    public $name;
    public $type;
    public $placeholder;

    public function __construct($id, $name, $type, $placeholder)
    {
        $this -> id = $id;
        $this -> name = $name;
        $this -> type = $type;
        $this -> placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.floating-form');
    }
}
