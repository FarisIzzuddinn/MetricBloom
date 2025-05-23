<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Closure;
use Illuminate\Contracts\View\View;

class FloatingForm extends Component
{
    public $id;
    public $name;
    public $type;
    public $placeholder;
    public $labelName;

    public function __construct($id, $name, $type = 'text', $placeholder = '', $labelName = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->labelName = $labelName;
    }

    public function render(): View|Closure|string
    {
        return view('components.floating-form');
    }
}
