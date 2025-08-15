<?php

namespace App\View\Components;

use App\Models\Classification;
use App\Models\genre;
use App\Models\Inventory;
use App\Models\Supplier;
use Illuminate\View\Component;

class CreateModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $dataTable;
    public $title;

    public function __construct($dataTable = 'default', $title = 'Add New Record')
    {
        $this->dataTable = $dataTable;
        $this->title = $title;
        $this->suppliers = Supplier::all();
        $this->inventories = Inventory::all();
        $this->genres = genre::all();
        $this->classifications = classification::all();


    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('Backend.components.create_modal',[
            'suppliers' => $this->suppliers,
            'inventories' => $this->inventories,
        ]);
    }
}
