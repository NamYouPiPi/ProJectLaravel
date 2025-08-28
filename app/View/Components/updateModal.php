<?php

namespace App\View\Components;

use App\Models\Classification;
use App\Models\Genre;
use App\Models\Hall_cinema;
use App\Models\Movies;
use App\Models\showtimes;
use App\Models\Supplier;
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
    public $movies;
    public $genres;
    public $suppliers;
    public $classifications;
    public $showTimes;
    public $hallCinemas;
    public function __construct( )
    {
        //
        $this->dataTable = '' ;
        $this->title ='';
        $this->movies = Movies::all();
        $this->genres= Genre::all();
        $this->suppliers= Supplier::all();
        $this->classifications = Classification::all();
        $this->showTimes = showtimes::all();
        $this->hallCinemas = Hall_cinema::all();

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
