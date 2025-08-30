@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/theaters.css') }}">
    <header class="gradient-header p-4">
        <div class="container">
            <div class="row align-items-center g-4">

                <!-- Left: Text and Icon -->
                <div class="col-lg-8 text-center text-md-start">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-2">
                        <img src="https://img.icons8.com/emoji/48/000000/popcorn-emoji.png" alt="icon" class="me-2"
                            style="width: 40px; height: 40px;" />
                        <h1 class="display-4 fw-bold text-white mb-0">Food <span class="text-danger">&</span> Beverage</h1>
                    </div>
                    <p class="text-white fs-5 mt-2" style="max-width: 28rem;">
                        Enjoyable movie experience with the best food selections and our best-selling popcorn!
                    </p>
                </div>

                <!-- Right: Food Image -->
                <div class="col-lg-4 text-center">
                    <img src="./final image/1536x864_Retail_Banner_3_Snacks_no_text-min-removebg-preview.png"
                        alt="Food and Drinks" class="img-fluid rounded shadow-lg" style="max-width: 28rem;" />
                </div>
            </div>
        </div>
    </header>

    <!-- Cinema List Section -->
    <section class="py-4">
        <div class="container">
            <h2 class="h2 fw-bold mb-4 px-2">Choose Cinema</h2>
            <div class="row g-4">

                <!-- Cinema Card 1 -->
                <div class="col-sm-6 col-lg-6">
                    <div class="cinema-card">
                        <a href="">
                            <img src="./final image/3288.jpg" alt="Legend Cinema" class="w-100">
                            <div class="p-3">
                                <h3 class="h5 fw-semibold mb-0">Aurura Cinema 271 Mega Mall</h3>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Cinema Card 2 -->
                <div class="col-sm-6 col-lg-6">
                    <div class="cinema-card">
                        <a href="">
                            <img src="./final image/eaon 2.jpg" alt="Legend Eden Garden" class="w-100">
                            <div class="p-3">
                                <h3 class="h5 fw-semibold mb-0">Aeon Sen Sok</h3>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Cinema Card 3 -->
                <div class="col-sm-6 col-lg-6">
                    <div class="cinema-card">
                        <a href="">
                            <img src="./final image/aeon-3-sky-bridge-cambodia-photographer.jpg" alt="Legend Meanchey"
                                class="w-100">
                            <div class="p-3">
                                <h3 class="h5 fw-semibold mb-0">Aeon 3</h3>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Cinema Card 4 -->
                <div class="col-sm-6 col-lg-6">
                    <div class="cinema-card">
                        <a href="">
                            <img src="./final image/olypic.jpg" alt="Legend Noro Mall" class="w-100">
                            <div class="p-3">
                                <h3 class="h5 fw-semibold mb-0">Olympic</h3>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Cinema Card 5 -->
                <div class="col-sm-6 col-lg-6">
                    <div class="cinema-card">
                        <a href="">
                            <img src="./final image/olypic.jpg" alt="Legend Premium Exchange Square" class="w-100">
                            <div class="p-3">
                                <h3 class="h5 fw-semibold mb-0">Steung mean chey</h3>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Cinema Card 6 -->
                <div class="col-sm-6 col-lg-6">
                    <div class="cinema-card">
                        <a href="">
                            <img src="./final image/olypic.jpg" alt="Legend Siem Reap" class="w-100">
                            <div class="p-3">
                                <h3 class="h5 fw-semibold mb-0">Aurura Siem Reap</h3>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Cinema Card 7 -->
                <div class="col-sm-6 col-lg-6">
                    <div class="cinema-card">
                        <a href="">
                            <img src="./final image/olypic.jpg" alt="Legend Premium Exchange Square" class="w-100">
                            <div class="p-3">
                                <h3 class="h5 fw-semibold mb-0">Aurura Premium Exchange Square</h3>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Cinema Card 8 -->
                <div class="col-sm-6 col-lg-6">
                    <div class="cinema-card">
                        <a href="">
                            <img src="./final image/olypic.jpg" alt="Legend Siem Reap" class="w-100">
                            <div class="p-3">
                                <h3 class="h5 fw-semibold mb-0">AURURA Siem Reap</h3>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
