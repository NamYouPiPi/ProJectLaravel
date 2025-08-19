<?php

namespace App\View\Components;

use App\Models\Inventory;
use Illuminate\View\Component;

class deleteModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $dataTable;
    public $title;
    public function __construct($dataTable = 'default', $title = 'Delete Record')
    {
        //
        $this->dataTable = $dataTable;
        $this->title = $title;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('Backend.components.delete_modal');
    }
}
