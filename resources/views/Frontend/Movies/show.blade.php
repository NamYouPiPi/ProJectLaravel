@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-5">
                <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}"
                    class="img-fluid rounded w-100 mb-3">
            </div>
            <div class="col-md-7">
                <h2 class="fw-bold mb-2 text-center">{{ $movie->title }}</h2>


                @php
                    $youtubeId = null;
                    if (preg_match('/(?:v=|be\\/|embed\\/)([\\w-]+)/', $movie->trailer, $matches)) {
                        $youtubeId = $matches[1];
                    }
                @endphp
                @if($youtubeId)
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0"
                        allowfullscreen></iframe>
                @endif

                <h5 class="fw-bold mt-4">Showtimes</h5>
                <ul class="list-unstyled mb-4">
                    @foreach($movie->showtimes ?? [] as $showtime)
                        <li class="mb-1">
                            <i class="fas fa-clock text-warning me-2"></i>
                            {{ $showtime->start_time->format('g:i A') }} - {{ $showtime->end_time->format('g:i A') }}
                        </li>
                    @endforeach
                </ul>
                <p>{{ $movie->description }}</p>
                <a href="{{ route('booking.create', $movie->id) }}" class="btn btn-book-now btn-lg">
                    <i class="fas fa-ticket-alt"></i> Book Now
                </a>
            </div>
        </div>
    </div>
@endsection