@include('partials.navbar')

@extends('layouts.main')
@section('title','Cinemagic — Home')

@section('content')
<section class="hero hero--cinemagic"
  style="
    background:
      radial-gradient(1200px 600px at 70% 45%, rgba(0,0,0,.0) 0%, rgba(0,0,0,.35) 60%, rgba(0,0,0,.75) 100%),
      linear-gradient(180deg, rgba(9,10,15,.1) 0%, rgba(9,10,15,.6) 65%, var(--bg) 100%),
      url('{{ asset('assets/image/banners.jpg') }}') center / cover no-repeat;">
  <div class="hero__inner">
    <span class="pill">IMAX • Action • 3h 1m</span>
    <h1 class="hero__title">Oppenheimer</h1>

    <div class="hero__meta">
      <span class="stars" aria-label="rating"><i>★</i><i>★</i><i>★</i><i>★</i><i class="muted">★</i></span>
      <span class="score">8.7/10</span><span>•</span>
      <span class="badge">R18</span><span>•</span>
      <span>2025</span><span>•</span><span>English</span>
    </div>

    <div class="hero__cta">
      <a class="btn" href="{{ route('fe.booking') }}">Book Tickets</a>
      <a class="btn ghost" href="{{ route('fe.review') }}">Review</a>
      <a class="btn ghost" href="{{ route('fe.movies') }}">More Info</a>
    </div>

    <div class="hero__more">
      <div class="hero__people">
        <strong>Christopher Nolan</strong> : <a class="link" href="#">Director</a><br>
        <span>Cillian Murphy, Emily Blunt, Matt Damon</span> : <a class="link" href="#">Stars</a>
      </div>
      <p class="hero__desc">
        The story of American scientist J. Robert Oppenheimer, and his role in the development of the atomic bomb.
      </p>
    </div>
  </div>
</section>
{{-- Book Tickets: if customer signed in -> go to booking; else -> customer login --}}
@auth('customer')
  <a href="{{ url('/booking') }}" class="btn">Book Tickets</a>
@else
  <a href="{{ route('customer.login', [], false) ?? url('/customer/login') }}" class="btn">Book Tickets</a>
@endauth

{{-- Manage Movies button only for admin/manager (guard:user) --}}
@auth('user')
  @role('admin|manager','user')
    <a href="{{ url('/admin/movies') }}" class="btn btn--ghost">Manage Movies</a>
  @endrole
@endauth

@endsection
