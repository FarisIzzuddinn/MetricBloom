<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class deleteButton extends Component
{
    public $target;
    public $permissionId;
    public $permissionName;

    public function __construct($target, $permissionId, $permissionName)
    {
        $this->target = $target;
        $this->permissionId = $permissionId;
        $this->permissionName = $permissionName;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.delete-button');
    }
}
