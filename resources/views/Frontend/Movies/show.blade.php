@extends('layouts.app')

@section('content')
    @php
        // Group showtimes by hall name
        $showtimesByHall = $movie->showtimes
            ? $movie->showtimes->groupBy(fn($showtime) => $showtime->hall->cinema_name ?? 'Unknown Hall')
            : collect();
    @endphp
    <div class="container py-5">
        {{-- <h2 class="fw-bold mb-2 text-center">{{ $movie->title }}</h2> --}}
        <div class="row">
            <div class="col-md-5">
                <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}"
                    class="img-fluid rounded w-100 mb-3">
            </div>
            <div class="col-md-7">
                {{-- <h2 class="fw-bold mb-2 text-center">{{ $movie->title }}</h2> --}}


                @php
                    $youtubeId = null;
                    if (preg_match('/(?:v=|be\\/|embed\\/)([\\w-]+)/', $movie->trailer, $matches)) {
                        $youtubeId = $matches[1];
                    }
                @endphp
                @if($youtubeId)
                    <iframe class="rounded" width="100%" height="315" src="https://www.youtube.com/embed/{{ $youtubeId }}"
                        frameborder="0" allowfullscreen></iframe>
                @endif

                <h5 class="fw-bold mt-4">Showtimes</h5>
                <ul class="list-unstyled mb-4">
                    @foreach($showtimesByHall as $hallName => $showtimes)
                        <h6 class="fw-bold mt-3 text-center">{{ $showtimes->first()->hall->hall_location->name ?? '' }}
                            {{ $hallName }} </h6>
                        <hr class="text-danger">
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($showtimes as $showtime)
                                <form action="{{ route('booking.createForShowtime', ['showtime' => $showtime->id]) }}" method="get">
                                    <button type="submit" class="btn btn-outline-primary rounded-pill px-4 py-2">
                                        {{ $showtime->start_time->format('h:i A') }}
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    @endforeach
                </ul>
                <p>{{ $movie->description }}</p>

            </div>
        </div>
    </div>
@endsection