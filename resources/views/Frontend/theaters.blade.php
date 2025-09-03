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
    <div class="container-custom">
        <h2 class="section-header">Choose Cinema</h2>

        <div class="row g-4">


            <!-- Cinema Card 2 -->
            @foreach ($theaters as $theather )

            <div class="col-lg-6 col-md-6">
                <div class="card cinema-card h-100">
                    <div class="cinema-image-container">
                        <img src="{{ asset('storage/' .$theather->image) }}"
                        alt="NamYou Cinema" class="cinema-image">
                        {{-- <div class="cinema-overlay"></div> --}}
                        <div class="cinema-badge">{{ $theather->name }}</div>
                    </div>
                    <div class="cinema-info">
                        <h3 class="cinema-title">{{ $theather->name }}</h3>
                        <p class="cinema-address">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                            {{ $theather->address }}
                        </p>
                        <div class="cinema-features">
                            <span class="feature-badge">Premium Seats</span>
                            <span class="feature-badge">Dolby Digital</span>
                        </div>
                        <button class="select-btn">
                            <i class="fas fa-ticket-alt me-2"></i>
                            Select Cinema
                        </button>
                    </div>
                </div>
            </div>

            @endforeach

        </div>
    </div>
    <style>
        .cinema-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            position: relative;
        }

        .cinema-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .cinema-image-container {
            position: relative;
            overflow: hidden;
            /* height: 200px; */
        }

        .cinema-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .cinema-card:hover .cinema-image {
            transform: scale(1.05);
        }



        .cinema-card:hover .cinema-overlay {
            opacity: 1;
        }

        .cinema-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .cinema-info {
            padding: 20px;
        }

        .cinema-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .cinema-address {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cinema-features {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }

        .feature-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 500;
        }

        .select-btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .select-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .select-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .select-btn:hover::before {
            left: 100%;
        }

        .section-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            margin-bottom: 2rem;
            position: relative;
        }

        .section-header::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }

        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        @media (max-width: 768px) {
            .cinema-info {
                padding: 16px;
            }

            .cinema-title {
                font-size: 1.1rem;
            }

            .cinema-features {
                gap: 8px;
            }

            .feature-badge {
                font-size: 10px;
                padding: 3px 6px;
            }
        }
    </style>
@endsection
