@include('partials.navbar')

@extends('layouts.main')
@section('title','Cinemagic — Movies')

@section('content')
<section class="wrap">
  <div class="section-head"><h2>Trending</h2><a class="tag" href="#">See all</a></div>
  <div class="grid" id="grid-trending" data-shelf></div>

  <div class="section-head" style="margin-top:22px"><h2>Upcoming</h2><a class="tag" href="#">See all</a></div>
  <div class="grid" id="grid-upcoming" data-shelf></div>

  <div class="section-head" style="margin-top:22px"><h2>Recommended</h2><a class="tag" href="#">See all</a></div>
  <div class="grid" id="grid-reco" data-shelf></div>

  <div class="section-head" style="margin-top:22px"><h2>In Theater</h2><a class="tag" href="#">See all</a></div>
  <div class="grid" id="grid-theater" data-shelf></div>
</section>
@endsection
