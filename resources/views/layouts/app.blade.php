<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AURORA CINEMAS </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        #cinemaCarousel {
            margin: 0;
            padding: 0;
        }

        :root {
            --cinema-primary: #e50914;
            --cinema-dark: #141414;
            --cinema-gold: #ffd700;
        }

        body {
            background-color: var(--cinema-dark);
            color: white;
        }

        .navbar {
            background: linear-gradient(90deg, var(--cinema-dark) 0%, #2d2d2d 100%);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            font-size: 2rem;
            font-weight: bold;
            color: var(--cinema-primary) !important;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .logo {
            width: 60px;
            height: auto;
        }

        .logo img {
            width: 100%;
            height: auto;
        }



        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav .nav-link:hover {
            color: var(--cinema-gold) !important;
            transform: translateY(-2px);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: var(--cinema-primary);
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover::after {
            width: 100%;
            left: 0;
        }

        .btn-book-now {
            background: linear-gradient(45deg, var(--cinema-primary), #ff3333);
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(229, 9, 20, 0.3);
        }

        .btn-book-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(229, 9, 20, 0.4);
        }

        /* .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect fill="%23222" width="1200" height="600"/><circle fill="%23e50914" cx="200" cy="150" r="50" opacity="0.1"/><circle fill="%23ffd700" cx="800" cy="400" r="80" opacity="0.1"/><circle fill="%23e50914" cx="1000" cy="200" r="60" opacity="0.1"/></svg>');
            background-size: cover;
            background-position: center;
            min-height: 70vh;
            display: flex;
            align-items: center;
        } */

        .movie-card {
            background: linear-gradient(145deg, #2a2a2a, #1a1a1a);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #333;
        }

        .movie-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(229, 9, 20, 0.2);
        }

        .movie-poster {
            height: 300px;
            background: linear-gradient(45deg, var(--cinema-primary), #ff6b6b);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
        }

        .booking-section {
            background: linear-gradient(135deg, #1a1a1a, #2a2a2a);
            border-radius: 20px;
            padding: 2rem;
            margin: 3rem 0;
        }

        .footer {
            background: linear-gradient(90deg, var(--cinema-dark) 0%, #0a0a0a 100%);
            padding: 3rem 0 1rem;
            margin-top: 4rem;
            border-top: 3px solid var(--cinema-primary);
        }

        .footer h5 {
            color: var(--cinema-gold);
            margin-bottom: 1rem;
            font-weight: bold;
        }

        .footer a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
            display: block;
            padding: 5px 0;
        }

        .footer a:hover {
            color: var(--cinema-primary);
            padding-left: 5px;
        }

        .social-icons a {
            display: inline-block;
            margin-right: 15px;
            font-size: 1.5rem;
            color: #ccc;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            color: var(--cinema-primary);
            transform: translateY(-3px);
        }

        .quick-book {
            background: linear-gradient(45deg, var(--cinema-primary), #ff4757);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 2rem 0;
        }

        .form-control,
        .form-select {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 10px;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: var(--cinema-gold);
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
            color: white;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .btn-search {
            background: var(--cinema-gold);
            color: black;
            border: none;
            font-weight: bold;
            border-radius: 10px;
            padding: 10px 20px;
        }

        .btn-search:hover {
            background: #ffed4a;
            color: black;
            transform: translateY(-2px);
        }
    </style>
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
                        <a class="nav-link" href="#showtimes">
                            <i class="fas fa-clock"></i> Showtimes
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
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-user"></i> Login
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <button class="btn btn-book-now">
                            <i class="fas fa-ticket-alt"></i> Book Now
                        </button>
                    </li> --}}
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

    <!-- Movies Section -->
    {{-- <section id="movies" class="py-5 mt-5">
        @yield('movies')
    </section> --}}

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="logo">
                            <img src="{{ asset('assets/image/logo.png') }}" alt="">
                        </div>
                        {{-- <i class="fas fa-film text-danger me-2" style="font-size: 2rem;"></i> --}}
                        <h3 class="text-danger mb-0 fw-bold">AURORA CINEMAS</h3>
                    </div>
                    <p class="text-light">
                        Your ultimate destination for the best cinema experience. Premium theaters, latest movies, and
                        unforgettable moments.
                    </p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5><i class="fas fa-video"></i> Movies</h5>
                    <a href="#">Now Showing</a>
                    <a href="#">Coming Soon</a>
                    <a href="#">Top Rated</a>
                    <a href="#">IMAX Movies</a>
                    <a href="#">3D Movies</a>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5><i class="fas fa-ticket-alt"></i> Booking</h5>
                    <a href="#">Book Tickets</a>
                    <a href="#">Group Booking</a>
                    <a href="#">Gift Cards</a>
                    <a href="#">Offers & Deals</a>
                    <a href="#">My Bookings</a>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5><i class="fas fa-building"></i> Theaters</h5>
                    <a href="#">Find Theaters</a>
                    <a href="#">Premium Screens</a>
                    <a href="#">Recliner Seats</a>
                    <a href="#">Food & Beverage</a>
                    <a href="#">Parking Info</a>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5><i class="fas fa-headset"></i> Support</h5>
                    <a href="#">Help Center</a>
                    <a href="#">Contact Us</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Refund Policy</a>
                </div>
            </div>
            <hr class="my-4" style="border-color: #333;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-light mb-0">
                        © 2025 AURORA CINEMAS  All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex justify-content-md-end justify-content-center">
                        <span class="badge bg-success me-2">
                            <i class="fas fa-shield-alt"></i> Secure Booking
                        </span>
                        <span class="badge bg-primary me-2">
                            <i class="fas fa-mobile-alt"></i> Mobile App
                        </span>
                        <span class="badge bg-warning text-dark">
                            <i class="fas fa-star"></i> 4.9.99/5 Rating
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add active state to navbar on scroll
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'linear-gradient(90deg, #0a0a0a 0%, #1a1a1a 100%)';
            } else {
                navbar.style.background = 'linear-gradient(90deg, var(--cinema-dark) 0%, #2d2d2d 100%)';
            }
        });

        // Simple booking interaction


    </script>
</body>

</html>
