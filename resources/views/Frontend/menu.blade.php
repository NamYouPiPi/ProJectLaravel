@extends('layouts.main')
@section('title','Cinemagic — Menu')

@section('content')
<body class="cm-bg">
  <header class="nav">
    <div class="row">
      <a href="{{ route('fe.cinemagic') }}" class="logo"><i></i> Cinemagic</a>
      <nav class="grow" style="display:flex;gap:16px">
        <a href="{{ route('fe.cinemagic') }}">Home</a>
        <a href="{{ route('fe.review') }}">Reviews</a>
        <a href="{{ route('fe.booking') }}">Booking</a>
        <a href="{{ route('fe.movies') }}">Movies</a>
      </nav>
      <button class="ghost">Menu</button>
      <button><a href="{{ route('fe.login') }}" class="btn btn-warning">Sign in</a>
</button>
    </div>
  </header>

  <main>
    @yield('content')
  </main>
</body>

@endsection
