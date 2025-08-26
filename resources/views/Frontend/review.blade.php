{{-- resources/views/Frontend/review.blade.php (and menu, booking, movies) --}}
@extends('layouts.main')
@section('title','Reviews')

@section('content')
<section id="review">
  {{-- your reviews content --}}
</section>
@endsection


@extends('layouts.main')
@section('title','Cinemagic — Reviews')

@section('content')
<section class="wrap">
  <div class="section-head"><h2>Reviews</h2></div>

  <div class="reviews">
    <article class="review">
      <div class="row"><span class="tag">Story</span><strong>4.5/5</strong></div>
      <p>A tense, meticulously crafted biopic with thunderous sound design and unforgettable performances.</p>
    </article>
    <article class="review">
      <div class="row"><span class="tag">Director</span><strong>4.8/5</strong></div>
      <p>Nolan’s non-linear storytelling hits hard; the pacing builds pressure like a reactor reaching critical mass.</p>
    </article>
    <article class="review">
      <div class="row"><span class="tag">Cast</span><strong>4.6/5</strong></div>
      <p>Murphy and Downey Jr. carry the film with precision; supporting roles add texture without clutter.</p>
    </article>
  </div>
</section>
@endsection
