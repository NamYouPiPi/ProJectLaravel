<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/image/logo.png') }}">

    <title>AURORA CINEMAS </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">

            <div class="logo">
                <img src="{{ asset('assets/image/logo.png') }}" alt="">
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"
                    style="background-image: url('data:image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 30 30\'><path stroke=\'rgba(255,255,255, 0.8)\' stroke-linecap=\'round\' stroke-miterlimit=\'10\' stroke-width=\'2\' d=\'M4 7h22M4 15h22M4 23h22\'/></svg>');"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#movies">
                            <i class="fas fa-video"></i> Movies
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('theaters') }}">
                            <i class="fas fa-map-marker-alt"></i> Theaters
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('offer') }}">
                            <i class="fas fa-tags"></i> Offers
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-person"></i> Login
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-person"></i> {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>


    {{-- end carousel --}}
    <!-- Hero Section -->

    <section id="home" class="hero-section" style="margin-top: 80px;">
        <div class="container">
            @yield('content')
        </div>
    </section>

    {{-- end home section --}}




    <!-- Footer -->
    <footer class="footer bg-dark text-light">
        <div class="container">
            <div class="row">
                <!-- Company Info Section -->
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="footer-brand">
                        <div class="d-flex align-items-center mb-3">
                            <div class="logo me-3">
                                <img src="{{ asset('assets/image/logo.png') }}" alt="Aurora Cinemas Logo"
                                    class="footer-logo">
                            </div>
                            <h3 class="text-danger mb-0 fw-bold footer-title">AURORA CINEMAS</h3>
                        </div>
                        <p class="text-light footer-description">
                            Your ultimate destination for the best cinema experience. Premium theaters, latest movies,
                            and
                            unforgettable moments.
                        </p>
                        <div class="social-icons">
                            <a href="#" class="social-link" aria-label="Facebook">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="col-6 col-md-3 col-lg-2 mb-4">
                    <div class="footer-section">
                        <h5 class="footer-heading">
                            <i class="fas fa-video me-2"></i>Movies
                        </h5>
                        <ul class="footer-links">
                            <li><a href="#">Now Showing</a></li>
                            <li><a href="#">Coming Soon</a></li>
                            <li><a href="#">Top Rated</a></li>
                            <li><a href="#">IMAX Movies</a></li>
                            <li><a href="#">3D Movies</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-6 col-md-3 col-lg-2 mb-4">
                    <div class="footer-section">
                        <h5 class="footer-heading">
                            <i class="fas fa-ticket-alt me-2"></i>Booking
                        </h5>
                        <ul class="footer-links">
                            <li><a href="#">Book Tickets</a></li>
                            <li><a href="#">Group Booking</a></li>
                            <li><a href="#">Gift Cards</a></li>
                            <li><a href="#">Offers & Deals</a></li>
                            <li><a href="#">My Bookings</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-6 col-md-3 col-lg-2 mb-4">
                    <div class="footer-section">
                        <h5 class="footer-heading">
                            <i class="fas fa-building me-2"></i>Theaters
                        </h5>
                        <ul class="footer-links">
                            <li><a href="#">Find Theaters</a></li>
                            <li><a href="#">Premium Screens</a></li>
                            <li><a href="#">Recliner Seats</a></li>
                            <li><a href="#">Food & Beverage</a></li>
                            <li><a href="#">Parking Info</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-6 col-md-3 col-lg-2 mb-4">
                    <div class="footer-section">
                        <h5 class="footer-heading">
                            <i class="fas fa-headset me-2"></i>Support
                        </h5>
                        <ul class="footer-links">
                            <li><a href="#">Help Center</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Terms of Service</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Refund Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <hr class="footer-divider">

            <!-- Bottom Section -->
            <div class="row align-items-center footer-bottom">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <p class="text-light mb-0 copyright-text">
                        © 2025 AURORA CINEMAS. All rights reserved.
                    </p>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex flex-wrap justify-content-md-end justify-content-center footer-badges">
                        <span class="badge bg-success me-2 mb-2">
                            <i class="fas fa-shield-alt me-1"></i>Secure Booking
                        </span>
                        <span class="badge bg-primary me-2 mb-2">
                            <i class="fas fa-mobile-alt me-1"></i>Mobile App
                        </span>
                        <span class="badge bg-warning text-dark mb-2">
                            <i class="fas fa-star me-1"></i>4.9/5 Rating
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/home.js') }}"></script>
</body>

</html>
