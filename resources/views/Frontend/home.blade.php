@extends('layouts.app')

@section('content')
    <!-- Cinema Carousel Section -->
    <div id="cinemaCarousel" class="carousel slide" data-bs-ride="carousel">
        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#cinemaCarousel" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Diamond Member"></button>
            <button type="button" data-bs-target="#cinemaCarousel" data-bs-slide-to="1"
                aria-label="Experience Cinema"></button>
            <button type="button" data-bs-target="#cinemaCarousel" data-bs-slide-to="2" aria-label="VIP Lounge"></button>
        </div>
        <!-- Slides -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://coolbeans.sgp1.digitaloceanspaces.com/legend-cinema-prod/480251c7-01bb-478e-a18d-dba2a8d62a39.jpeg"
                    class="d-block w-100 carousel-image" alt="Diamond Member">
            </div>
            <div class="carousel-item">
                <img src="https://coolbeans.sgp1.digitaloceanspaces.com/legend-cinema-prod/480251c7-01bb-478e-a18d-dba2a8d62a39.jpeg"
                    class="d-block w-100 carousel-image" alt="Experience Cinema">
            </div>
            <div class="carousel-item">
                <img src="https://coolbeans.sgp1.digitaloceanspaces.com/legend-cinema-prod/480251c7-01bb-478e-a18d-dba2a8d62a39.jpeg"
                    class="d-block w-100 carousel-image" alt="VIP Lounge">
            </div>
        </div>
        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#cinemaCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#cinemaCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    @php
        use Carbon\Carbon;
        $today = Carbon::today();
        $days = collect(range(0, 6))->map(fn($i) => $today->copy()->addDays($i));
        $selectedDate = request('date', $today->toDateString());
        $search = request('search');
        // Filter movies by showtimes on selected date
        $filteredMovies = $movies->filter(function ($movie) use ($selectedDate, $search) {
            $hasShowtime = $movie->showtimes->where('start_time', '>=', $selectedDate . ' 00:00:00')
                ->where('start_time', '<=', $selectedDate . ' 23:59:59')
                ->count() > 0;
            $matchesSearch = !$search || str_contains(strtolower($movie->title), strtolower($search));
            return $hasShowtime && $matchesSearch;
        });
    @endphp

    <!-- Search Bar -->
    {{-- <form method="get" action="" class="mb-4 d-flex justify-content-center flex-wrap gap-2">
        <input type="hidden" name="date" value="{{ $selectedDate }}">
        <input type="text" name="search" value="{{ $search }}" class="form-control w-auto" placeholder="Search movies..."
            style="min-width:200px;">
        <button type="submit" class="btn btn-danger">Search</button>
    </form> --}}

    <!-- Date Picker Bar -->
    <div class="d-flex gap-3 justify-content-center mb-5 mt-5 flex-wrap">
        @foreach($days as $day)
            <form method="get" action="" class="m-0">
                <input type="hidden" name="date" value="{{ $day->toDateString() }}">

                <button type="submit" class="bg-black text-white border rounded-4 px-4 py-3 text-center" style="border: 2px solid {{ $day->toDateString() === $selectedDate ? '#e50914' : '#444' }};
                                   box-shadow: {{ $day->toDateString() === $selectedDate ? '0 0 10px #e50914' : 'none' }};
                                   min-width: 120px;">
                    <div style="font-size: 0.9rem;">
                        {{ $day->isToday() ? 'Today' : $day->format('D') }}
                    </div>
                    <div style="font-size: 1.5rem; font-weight: bold;">
                        {{ $day->format('d') }}
                    </div>
                    <div style="font-size: 0.9rem;">
                        {{ $day->format('M') }}
                    </div>
                </button>
            </form>
        @endforeach
    </div>

    <!-- Movies Section -->
    <section id="movies" class=" py-md-5">
        <div class="container">
            @if($filteredMovies->isEmpty())
                <div class="alert alert-warning text-center">No movies found for this date{{ $search ? ' and search' : '' }}.
                </div>
            @endif
            <div class="row">
                @foreach($filteredMovies as $movie)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-3">
                        <div class="movie-card h-100">
                            <a href="{{ route('movies.show', $movie->id) }}" class="text-decoration-none">
                                <div class="movie-poster-container">
                                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}"
                                        class="img-fluid rounded shadow-sm movie-poster">
                                </div>
                                <div class="movie-info p-2 p-md-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap">
                                        <small class="text-white movie-date">{{ $movie->release_date->format('M,d, Y') }}</small>
                                        <span class="badge bg-secondary movie-rating">{{ $movie->classification->code ?? '' }}</span>
                                    </div>
                                    <h6 class="movie-title text-light mb-0">{{ $movie->title }}</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        /* Responsive Carousel */
        .carousel-image {
            height: 300px;
            object-fit: cover;
        }

        @media (min-width: 768px) {
            .carousel-image {
                height: 500px;
            }
        }

        @media (min-width: 1024px) {
            .carousel-image {
                height: 700px;
            }
        }

        /* Movie Cards */
        .movie-card {
            transition: transform 0.3s ease;
        }

        .movie-card:hover {
            transform: translateY(-5px);
        }

        .movie-poster-container {
            position: relative;
            overflow: hidden;
            border-radius: 0.375rem;
        }

        .movie-poster {
            aspect-ratio: 2/3;
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .movie-card:hover .movie-poster {
            transform: scale(1.05);
        }

        .movie-info {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 0 0 0.375rem 0.375rem;
        }

        .movie-title {
            font-size: 0.9rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .movie-date {
            font-size: 0.8rem;
        }

        .movie-rating {
            font-size: 0.7rem;
            min-width: 30px;
            text-align: center;
        }

        /* Responsive Typography */
        @media (min-width: 576px) {
            .movie-title {
                font-size: 1rem;
            }

            .movie-date {
                font-size: 0.85rem;
            }

            .movie-rating {
                font-size: 0.75rem;
            }
        }

        @media (min-width: 768px) {
            .movie-title {
                font-size: 1.1rem;
            }

            .movie-date {
                font-size: 0.9rem;
            }

            .movie-rating {
                font-size: 0.8rem;
            }
        }

        /* Responsive Spacing */
        @media (max-width: 576px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            #movies {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }
        }

        /* Fix for very small screens */
        @media (max-width: 375px) {
            .movie-info {
                padding: 0.5rem !important;
            }

            .movie-title {
                font-size: 0.8rem;
            }

            .movie-date {
                font-size: 0.7rem;
            }
        }

        /* Date Picker Bar Responsive */
        .date-picker-bar form {
            flex: 1 1 120px;
        }

        @media (max-width: 768px) {
            .date-picker-bar {
                gap: 1rem !important;
            }
        }
    </style>
@endsection
