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
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="https://coolbeans.sgp1.digitaloceanspaces.com/legend-cinema-prod/480251c7-01bb-478e-a18d-dba2a8d62a39.jpeg"
                    class="d-block w-100" alt="Diamond Member" style="height: 700px; object-fit: cover;">
            </div>
            <div class="carousel-item active">
                <img src="https://coolbeans.sgp1.digitaloceanspaces.com/legend-cinema-prod/480251c7-01bb-478e-a18d-dba2a8d62a39.jpeg"
                    class="d-block w-100" alt="Diamond Member" style="height: 700px; object-fit: cover;">
            </div>
            <div class="carousel-item active">
                <img src="https://coolbeans.sgp1.digitaloceanspaces.com/legend-cinema-prod/480251c7-01bb-478e-a18d-dba2a8d62a39.jpeg"
                    class="d-block w-100" alt="Diamond Member" style="height: 700px; object-fit: cover;">
            </div>
            <div class="carousel-item active">
                <img src="https://coolbeans.sgp1.digitaloceanspaces.com/legend-cinema-prod/480251c7-01bb-478e-a18d-dba2a8d62a39.jpeg"
                    class="d-block w-100" alt="Diamond Member" style="height: 700px; object-fit: cover;">
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
    <section id="movies" class="py-5 mt-5">
        <div class="container">
            <div class="row g-4">
                @foreach($movies as $movie)
                    <main class="col-md-3">
                        <a href="{{ route('movies.show', $movie->id) }}">
                            <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}"
                                class="img-fluid rounded shadow-sm">
                        </a>
                        <div class="">
                            <div class="d-flex  align-items-center ">
                                <p class="text-light">{{ $movie->release_date }}</p><p
                                    class="badge text-bg-secondary ">{{ $movie->classification->code ?? '' }}</p>

                                </div>
                                <p class="">{{ $movie->title }}</p>
                        </div>
                    </main>
                @endforeach
            </div>
        </div>
    </section>

@endsection
