<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="{{ url('/') }}" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('assets/image/logo.png') }}" alt="Aurora Cinemas Logo" class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Aurora Cinemas</span>
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

                <!-- Dashboard -->
                <li class="nav-item @yield('dashboard')">
                    <a href="{{ url('/') }}" class="nav-link">
                        <i class="nav-icon bi bi-palette"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Inventory Section -->
                <li class="nav-item @yield('menu-open')">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-box-seam"></i>
                        <p>
                            Inventory
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('suppliers.index') }}" class="nav-link @yield('supplier')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Suppliers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('inventory.index') }}" class="nav-link @yield('inventory')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Inventory</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sale.index') }}" class="nav-link @yield('sale')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Sale</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Movies Section -->
                <li class="nav-item @yield('menu-open')">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-film"></i>
                        <p>
                            Movies
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('movies.index') }}" class="nav-link @yield('movies')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Movies</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('genre.index') }}" class="nav-link @yield('genre')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Genre</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('classification.index') }}" class="nav-link @yield('classification')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Classification</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Halls -->
                <li class="nav-item @yield('hallLocation')">
                    <a href="{{ route('hall_locations.index') }}" class="nav-link">
                        <i class="bi bi-geo-alt"></i>
                        <p>Hall Location</p>
                    </a>
                </li>
                <li class="nav-item @yield('hallCinema')">
                    <a href="{{ route('hallCinema.index') }}" class="nav-link">
                        <i class="bi bi-building"></i>
                        <p>Hall Cinema</p>
                    </a>
                </li>

                <!-- Showtimes -->
                <li class="nav-item @yield('showtimes')">
                    <a href="{{ route('Showtime.index') }}" class="nav-link">
                        <i class="bi bi-clock"></i>
                        <p>Showtimes</p>
                    </a>
                </li>

                <!-- Seats -->
                <li class="nav-item @yield('seatTypes')">
                    <a href="{{ route('seatTypes.index') }}" class="nav-link">
                        <i class="bi bi-layout-sidebar"></i>
                        <p>Seat Types</p>
                    </a>
                </li>
                <li class="nav-item @yield('seats')">
                    <a href="{{ route('seats.index') }}" class="nav-link">
                        <i class="bi bi-person-seat"></i>
                        <p>Seats</p>
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

                <li class="nav-item  @yield('bookings')">
                    <a href="{{route('bookings.index')}}" class="nav-link">
                        <i class="bi bi-journal-text"></i>
                        <p>Bookings</p>
                    </a>
                </li>
                <li class="nav-item  @yield('booking-seats')">
                    <a href="{{route('booking-seats.index')}}" class="nav-link">
                        <i class="bi bi-journal-text"></i>
                        <p>Booking Seats</p>
                    </a>
                </li>
                <li class="nav-item @yield('menu-open')">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Management User
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="{{route('users.index')}}" class="nav-link @yield('supplier')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('permissions.index')}}" class="nav-link @yield('inventory')">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Permission</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles.index')  }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Role</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
