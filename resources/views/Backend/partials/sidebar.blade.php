<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('assets/image/logo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Aurora Cinemas </span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">
                <li class="nav-item  @yield('dashboard')">
                    <a href="{{url('/')}}" class="nav-link">
                        <i class="nav-icon bi bi-palette"></i>
                        <p>Dashboard </p>
                    </a>
                </li>
                <li class="nav-item @yield('menu-open')">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Inventory
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="{{route('suppliers.index')}}" class="nav-link @yield('supplier')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Suppliers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('inventory.index')}}" class="nav-link @yield('inventory')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Invetory</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sale.index')  }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Sale</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item @yield('menu-open')">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Movies
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="{{ route('movies.index')}}" class="nav-link @yield('movies')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Movies</p>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ route('genre.index')}}" class="nav-link @yield('genre')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Genre</p>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ route('classification.index')}}" class="nav-link @yield('genre')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Classification</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item  @yield('hallLocation')">
                    <a href="{{route('hall_locations.index')}}" class="nav-link">
                        <i class="bi bi-geo-alt"></i>
                        <p>Hall Location </p>
                    </a>
                </li>
                <li class="nav-item  @yield('hallCinema')">
                    <a href="{{route('hallCinema.index')}}" class="nav-link">
                        <i class="bi bi-geo-alt"></i>
                        <p>HallCinema </p>
                    </a>
                </li>
                <li class="nav-item  @yield('ShowTimes')">
                    <a href="{{route('Showtime.index')}}" class="nav-link">
                        <i class="bi bi-geo-alt"></i>
                        <p>ShowTimes </p>
                    </a>
                </li>
                <li class="nav-item  @yield('seatsTypes')">
                    <a href="{{route('seatTypes.index')}}" class="nav-link">
                        <i class="bi bi-geo-alt"></i>
                        <p>Seats Type </p>
                    </a>
                </li>
                <li class="nav-item  @yield('seats')">
                    <a href="{{route('seats.index')}}" class="nav-link">
                        <i class="bi bi-geo-alt"></i>
                        <p>Seats </p>
                    </a>
                </li>
                <li class="nav-item  @yield('customer')">
                    <a href="{{route('customer.index')}}" class="nav-link">
                        <i class="bi bi-geo-alt"></i>
                        <p>Customers </p>
                    </a>
                </li>
                <li class="nav-item  @yield('employees')">
                    <a href="{{route('employees.index')}}" class="nav-link">
                        <i class="bi bi-geo-alt"></i>
                        <p>Employees </p>
                    </a>
                </li>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
