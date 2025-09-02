<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="{{ url('/') }}" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('assets/image/logo.png') }}" alt="Aurora Cinemas Logo"
                class="brand-image opacity-75 shadow" />
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
                @if(auth()->user()->hasPermission('access_dashboard'))
                    <li class="nav-item @yield('dashboard')">
                        <a href="{{ url('/dashboard') }}" class="nav-link">
                            <i class="nav-icon bi bi-palette"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endif

                {{-- promotions --}}
                @if(auth()->user()->hasPermission('view_promotions'))
                    <li class="nav-item @yield('promotion')">
                        <a href="{{ route('promotions.index') }}" class="nav-link">
                            <i class="nav-icon bi bi-megaphone"></i>
                            <p>Promotions</p>
                        </a>
                    </li>
                @endif

                <!-- Inventory Section -->
                @if(auth()->user()->hasAnyPermission(['view_inventory', 'view_suppliers', 'view_sales']))
                    <li class="nav-item @yield('inventory-menu-open')">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-box-seam"></i>
                            <p>
                                Inventory
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(auth()->user()->hasPermission('view_suppliers'))
                                <li class="nav-item">
                                    <a href="{{route('suppliers.index') }}" class="nav-link @yield('supplier')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Suppliers</p>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('view_inventory'))
                                <li class="nav-item">
                                    <a href="{{ route('inventory.index') }}" class="nav-link @yield('inventory')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Inventory</p>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('view_sales'))
                                <li class="nav-item">
                                    <a href="{{ route('sale.index') }}" class="nav-link @yield('sale')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Sale</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Movies Section -->
                @if(auth()->user()->hasAnyPermission(['view_movies', 'view_genre', 'view_classification']))
                    <li class="nav-item @yield('movies-menu-open')">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-film"></i>
                            <p>
                                Movies
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(auth()->user()->hasPermission('view_movies'))
                                <li class="nav-item">
                                    <a href="{{ route('movies.index') }}" class="nav-link @yield('movies')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Movies</p>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('view_genre'))
                                <li class="nav-item">
                                    <a href="{{ route('genre.index') }}" class="nav-link @yield('genre')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Genre</p>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('view_classification'))
                                <li class="nav-item">
                                    <a href="{{ route('classification.index') }}" class="nav-link @yield('classification')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Classification</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(auth()->user()->hasAnyPermission(['view_hall_locations', 'view_hall_cinema']))
                    <li class="nav-item @yield('cinemas-menu-open')">
                        <a href="#" class="nav-link">
                            <i class="bi bi-camera-reels"></i>
                            <p>Cinemas <i class="nav-arrow bi bi-chevron-right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(auth()->user()->hasPermission('view_hall_locations'))
                                <li class="nav-item @yield('hall_locations')">
                                    <a href="{{ route('hall_locations.index') }}" class="nav-link @yield('hall_locations')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Hall location</p>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('view_hall_cinema'))
                                <li class="nav-item @yield('hallCinema')">
                                    <a href="{{ route('hallCinema.index') }}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Hall Cinema</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(auth()->user()->hasAnyPermission(['view_seats', 'view_seat_types']))
                    <li class="nav-item @yield('seats-menu-open')">
                        <a href="#" class="nav-link">
                            <i class="bi bi-person-seat"></i>
                            <p>Seats <i class="nav-arrow bi bi-chevron-right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(auth()->user()->hasPermission('view_seats'))
                                <li class="nav-item @yield('seat')">
                                    <a href="{{ route('seats.index') }}" class="nav-link @yield('seat')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Seats</p>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('view_seat_types'))
                                <li class="nav-item @yield('seatTypes')">
                                    <a href="{{ route('seatTypes.index') }}" class="nav-link @yield('seatTypes')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Seat Types</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Showtimes -->
                @if(auth()->user()->hasPermission('view_showtimes'))
                    <li class="nav-item @yield('showtimes')">
                        <a href="{{ route('showtimes.index') }}" class="nav-link">
                            <i class="bi bi-clock"></i>
                            <p>Showtimes</p>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->hasPermission('view_customers'))
                    <li class="nav-item  @yield('customer')">
                        <a href="{{route('customer.index')}}" class="nav-link">
                            <i class="bi bi-geo-alt"></i>
                            <p>Customers </p>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->hasPermission('view_employees'))
                    <li class="nav-item  @yield('employees')">
                        <a href="{{route('employees.index')}}" class="nav-link">
                            <i class="bi bi-geo-alt"></i>
                            <p>Employees </p>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->hasPermission('view_bookings'))
                    <li class="nav-item  @yield('bookings')">
                        <a href="{{route('bookings.index')}}" class="nav-link">
                            <i class="bi bi-journal-text"></i>
                            <p>Bookings</p>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->hasPermission('view_booking_seats'))
                    <li class="nav-item  @yield('booking-seats')">
                        <a href="{{route('booking-seats.index')}}" class="nav-link">
                            <i class="bi bi-journal-text"></i>
                            <p>Booking Seats</p>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->hasAnyPermission(['manage_users', 'manage_roles', 'manage_permissions']) || auth()->user()->isSuperAdmin())
                    <li class="nav-item @yield('user-menu-open')">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon bi bi-speedometer"></i>
                            <p>
                                Management User
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(auth()->user()->hasPermission('manage_users') || auth()->user()->isSuperAdmin())
                                <li class="nav-item ">
                                    <a href="{{route('users.index')}}" class="nav-link @yield('supplier')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>User</p>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('manage_permissions') || auth()->user()->isSuperAdmin())
                                <li class="nav-item">
                                    <a href="{{route('permissions.index')}}" class="nav-link @yield('inventory')">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Permission</p>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('manage_roles') || auth()->user()->isSuperAdmin())
                                <li class="nav-item">
                                    <a href="{{ route('roles.index')  }}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Role</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>