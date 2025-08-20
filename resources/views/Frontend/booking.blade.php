@extends('layouts.main')
@section('title','Cinemagic — Booking')

@section('content')
<section class="wrap">
  <div class="section-head"><h2>Booking</h2></div>

  <div class="booking">
    <div>
      <div class="panel">
        <div class="row" style="justify-content:space-between">
          <div class="col">
            <div style="font-weight:700">Oppenheimer</div>
            <div style="color:var(--muted)">Sat • 7:30 PM • Hall A</div>
          </div>
          <div><span class="tag">R18</span></div>
        </div>
      </div>

      <div class="screen" title="Screen"></div>
      <div id="seatGrid" class="seats" data-seat></div>
      <div class="legend">
        <span><i class="dot d-free"></i>Available</span>
        <span><i class="dot d-taken"></i>Taken</span>
        <span><i class="dot d-sel"></i>Selected</span>
      </div>
    </div>

    <aside class="col">
      <div class="panel">
        <div style="font-weight:700;margin-bottom:10px">Summary</div>
        <div class="row" style="justify-content:space-between">
          <span>Seats</span><span id="selSeats">—</span>
        </div>
        <div class="row" style="justify-content:space-between">
          <span>Price</span><span>$<span id="price">0</span></span>
        </div>
        <button style="width:100%;margin-top:10px">Confirm Booking</button>
      </div>
      <div class="panel">
        <div style="font-weight:700;margin-bottom:10px">Showtime</div>
        <div class="row" style="flex-wrap:wrap;gap:8px">
          <span class="tag">12:30</span><span class="tag">15:00</span>
          <span class="tag">17:30</span><span class="tag">19:30</span>
        </div>
      </div>
    </aside>
  </div>
</section>
@endsection
