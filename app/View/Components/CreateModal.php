<?php

namespace App\View\Components;


use App\Models\{Seat_type, Showtimes, Supplier, Classification, Hall_location, Genre, Movies, Inventory, Hall_cinema, Role, Seats};
use App\Models\Booking;
use App\Models\Customer;
use Illuminate\View\Component;

class CreateModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public mixed $dataTable;
    public mixed $title;
    public array|\Illuminate\Database\Eloquent\Collection|\LaravelIdea\Helper\App\Models\_IH_Supplier_C $suppliers;
    public \Illuminate\Database\Eloquent\Collection $inventories;
    public \Illuminate\Database\Eloquent\Collection $genres;
    public \Illuminate\Database\Eloquent\Collection $classifications;
    public $movies;
    protected \Illuminate\Database\Eloquent\Collection $hall_location;
    protected \Illuminate\Database\Eloquent\Collection $hallCinema;
    protected  $seatsType;
    protected $customers ;
    protected $bookings;
    protected $seats;
    protected $roles;
    public function __construct($dataTable = 'default', $title = 'Add New Record')
    {
        $this->dataTable = $dataTable;
        $this->title = $title;
        $this->suppliers = Supplier::all();
        $this->inventories = Inventory::all();
        $this->genres = Genre::all();
        $this->classifications = Classification::all();
        $this->hall_location = Hall_location::all();
        $this->hallCinema = Hall_cinema::all();
        $this->movies = Movies::where('status', 'active')->get();
        $this->seatsType = Seat_type::all();
        $this->customers = Customer::all();
        $this->bookings = Booking::all();
        $this->seats = Seats::all();
        $this->roles = Role::all();
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
            'genres' => $this->genres,
            'hall_location' => $this->hall_location,
            'hallCinema' => $this->hallCinema,
            'movies' => $this->movies,
            'classifications' => $this->classifications,
            'seatsType' => $this->seatsType,
            'customers' => $this->customers,
            'showtimes' => Showtimes::all(),
            'bookings' => $this->bookings,
            'seats' => $this->seats,
            'roles' => $this->roles,

        ]);
    }
}
