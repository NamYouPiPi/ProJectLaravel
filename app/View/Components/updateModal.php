<?php

namespace App\View\Components;

use Illuminate\View\Component;

class updateModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $dataTable;
    public $title;
    public function __construct()
    {
        //
        $this->dataTable = 'default';
        $this->title = 'default';

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('Backend.components.update_modal');
    }
}
