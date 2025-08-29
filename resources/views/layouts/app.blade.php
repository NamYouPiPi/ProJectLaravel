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
                        <a class="nav-link" href="#theaters">
                            <i class="fas fa-map-marker-alt"></i> Theaters
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#offers">
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

    <style>
        /* Footer Base Styles */
        .footer {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            padding: 3rem 0 1.5rem;
            margin-top: auto;
        }

        .footer-logo {
            max-height: 40px;
            width: auto;
        }

        .footer-title {
            font-size: 1.5rem;
            letter-spacing: 1px;
        }

        .footer-description {
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        /* Social Icons */
        .social-icons {
            display: flex;
            gap: 1rem;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid #dc3545;
            border-radius: 50%;
            color: #dc3545;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .social-link:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
        }

        /* Footer Sections */
        .footer-heading {
            color: #dc3545;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .footer-heading i {
            font-size: 1rem;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 0.9rem;
        }

        .footer-links a:hover {
            color: #dc3545;
            text-decoration: underline;
        }

        /* Footer Divider */
        .footer-divider {
            border-color: #444 !important;
            margin: 2rem 0 1.5rem;
        }

        /* Footer Bottom */
        .footer-bottom {
            padding-top: 1rem;
        }

        .copyright-text {
            font-size: 0.9rem;
            color: #ccc;
        }

        .footer-badges .badge {
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
        }

        /* Mobile Styles (iPhone) */
        @media (max-width: 575px) {
            .footer {
                padding: 2rem 0 1rem;
            }

            .footer-brand {
                text-align: center;
                margin-bottom: 2rem;
            }

            .footer-title {
                font-size: 1.3rem;
            }

            .footer-description {
                font-size: 0.85rem;
                text-align: center;
            }

            .social-icons {
                justify-content: center;
                margin-bottom: 2rem;
            }

            .social-link {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }

            .footer-heading {
                font-size: 1rem;
                margin-bottom: 0.75rem;
            }

            .footer-links a {
                font-size: 0.85rem;
            }

            .footer-badges {
                gap: 0.5rem;
            }

            .footer-badges .badge {
                font-size: 0.7rem;
                padding: 0.4rem 0.6rem;
            }

            .copyright-text {
                text-align: center;
                font-size: 0.8rem;
            }
        }

        /* Small Tablets (iPad Mini) */
        @media (min-width: 576px) and (max-width: 767px) {
            .footer {
                padding: 2.5rem 0 1.25rem;
            }

            .social-link {
                width: 38px;
                height: 38px;
                font-size: 1.1rem;
            }

            .footer-heading {
                font-size: 1.05rem;
            }

            .footer-links a {
                font-size: 0.9rem;
            }
        }

        /* Tablets (iPad) */
        @media (min-width: 768px) and (max-width: 991px) {
            .footer {
                padding: 2.75rem 0 1.5rem;
            }

            .footer-brand {
                margin-bottom: 1.5rem;
            }

            .social-icons {
                margin-bottom: 1rem;
            }
        }

        /* Large Tablets and Small Desktops */
        @media (min-width: 992px) and (max-width: 1199px) {
            .footer-title {
                font-size: 1.4rem;
            }

            .footer-description {
                font-size: 0.9rem;
            }
        }

        /* Desktop */
        @media (min-width: 1200px) {
            .footer {
                padding: 4rem 0 2rem;
            }

            .footer-title {
                font-size: 1.6rem;
            }

            .footer-description {
                font-size: 1rem;
                margin-bottom: 2rem;
            }

            .social-link {
                width: 45px;
                height: 45px;
                font-size: 1.3rem;
            }

            .footer-heading {
                font-size: 1.2rem;
                margin-bottom: 1.25rem;
            }

            .footer-links a {
                font-size: 0.95rem;
            }

            .footer-badges .badge {
                font-size: 0.85rem;
                padding: 0.6rem 0.8rem;
            }
        }

        /* Hover Effects for Desktop */
        @media (min-width: 768px) {
            .footer-section:hover .footer-heading {
                color: #ff6b6b;
                transition: color 0.3s ease;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .footer {
                background: linear-gradient(135deg, #0d1117 0%, #161b22 100%);
            }
        }

        /* Print styles */
        @media print {
            .footer {
                background: white !important;
                color: black !important;
            }

            .footer-links a {
                color: black !important;
            }

            .social-icons {
                display: none;
            }
        }

        /* High contrast mode */
        @media (prefers-contrast: high) {
            .footer {
                background: #000;
                border-top: 2px solid #fff;
            }

            .footer-links a:hover {
                background: #fff;
                color: #000;
                padding: 2px 4px;
            }
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/home.js') }}"></script>
</body>

</html>