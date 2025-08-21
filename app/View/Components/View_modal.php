<?php

namespace App\View\Components;

use Illuminate\View\Component;

class View_modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
        public $title;
    public $dataTable;
    public function __construct()
    {
        //
        $this->title = 'View Modal';
        $this->dataTable = 'details';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */

    public function render()
    {
        return view('components.view_modal');
    }
}
