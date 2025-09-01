@extends('layouts.app')

@section('content')
    @php
        $seatRows = $sortedRows ?? collect();
        $movie = $movie ?? null;
        $showtime = $showtime ?? null;
        $hall = $hall ?? null;
        $Hall_location = $Hall_location ?? null;
        $seats = $seats ?? collect();
        $bookedSeats = $bookedSeats ?? [];
        $seatStatuses = [];

        foreach ($seats as $seat) {
            $status = in_array($seat->id, $bookedSeats) ? 'booked' : $seat->status;
            $seatStatuses[$seat->seat_row . '-' . $seat->seat_number] = $status;
        }
        // Get sorted rows
        $rowsArray = $seatRows->keys()->sort()->reverse()->values()->toArray();
    @endphp

<link rel="stylesheet" href="{{ asset('css/createbooking.css') }}">

    <div class="main-container">
        <div class="content-wrapper">
            <!-- Stepper -->
            <div class="stepper-container">
                <div class="stepper">
                    <div class="step completed">
                        <div class="step-number">✓</div>
                        <div class="step-text">Showtime</div>
                    </div>
                    <div class="step active">
                        <div class="step-number">2</div>
                        <div class="step-text">Choose Seat</div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-text">Order Review</div>
                    </div>
                    <div class="step">
                        <div class="step-number">4</div>
                        <div class="step-text">Checkout</div>
                    </div>
                </div>
            </div>

            <div class="main-content">
                <!-- Seat Selection -->
                <div class="seat-selection-card">
                    <div class="card-header">
                        <div class="showtime-badge">
                            <i class="fas fa-clock"></i>
                            {{ $showtime->start_time->format('h:i A') ?? '1:30 PM' }}
                        </div>
                        <div class="zoom-controls">
                            <button class="zoom-btn" id="zoomOut">-</button>
                            <button class="zoom-btn" id="zoomIn">+</button>
                        </div>
                    </div>

                    <div class="screen-area">
                        <div class="screen"></div>
                        <div class="screen-label">SCREEN</div>
                    </div>

                    <div class="seat-map-container">
                        <div class="seat-map">
                            @php
                                $groups = [
                                    'A' => $GroupA ?? [],
                                    'B' => $GroupB ?? [],
                                    'C' => $GroupC ?? [],
                                    'D' => $GroupD ?? [],
                                    'E' => $GroupE ?? [],
                                    'F' => $GroupF ?? [],
                                    'G' => $GroupG ?? [],
                                ];
                            @endphp

                            @foreach($groups as $row => $seats)
                                <div class="seat-row">
                                    <div class="row-label">{{ $row }}</div>
                                    <div class="seats-container">
                                      @foreach($seats as $seat)
                                        @php
                                            if (is_object($seat) && isset($seat->is_booked)) {
                                                $status = $seat->is_booked ? 'booked' : 'available';
                                            } else {
                                                $status = 'available';
                                            }
                                            $price = is_object($seat) && isset($seat->seatType) ? $seat->seatType->price : 3.00; // fallback
                                        @endphp
                                        <button class="seat {{ $status }}"
                                            data-seat-id="{{ is_object($seat) && isset($seat->id) ? $seat->id : '' }}"
                                            data-seat-number="{{  $seat->seat_number  }}"
                                            data-seat-price="{{ $price }}"
                                            {{ $status !== 'available' ? 'disabled' : '' }}>
                                            {{ $seat->seat_number  }}
                                        </button>
                                    @endforeach
                                    </div>
                                    <div class="row-label">{{ $row }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="legend">
                        <div class="legend-item">
                            <div class="legend-seat"
                                style="background: linear-gradient(145deg, #3a3a3a, #2a2a2a); border-color: #555;"></div>
                            <span>Available</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-seat"
                                style="background: linear-gradient(145deg, #ff4757, #ff3742); border-color: #ff2f3e;"></div>
                            <span>Selected</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-seat"
                                style="background: linear-gradient(145deg, #2196f3, #1976d2); border-color: #0d47a1;"></div>
                            <span>Reserved</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-seat"
                                style="background: linear-gradient(145deg, #666, #555); border-color: #444;"></div>
                            <span>Booked</span>
                        </div>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="order-details-card">
                    <h3 class="order-title">Selected Seats</h3>

                    <div class="selected-seats-display">
                        <div class="seat-icon" id="seatIcon">
                            <i class="fas fa-chair"></i>
                        </div>
                        <div class="selected-seats-tags" id="selectedSeatsTags"></div>
                        <div class="empty-seats-message" id="emptyMessage">Your seat is empty</div>
                    </div>

                    <div class="order-details-list">
                        <div class="detail-row">
                            <span class="detail-label">Movie:</span>
                            <span class="detail-value">{{ $movie->title ?? 'The Conjuring 2 (Re-release)' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Time:</span>
                            <span class="detail-value">{{ $showtime->start_time->format('h:i A') ?? '11:35 PM' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Date:</span>
                            <span class="detail-value">{{ $showtime->start_time->format('D, d M') ?? '' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Format:</span>
                            <span class="detail-value">Adult Regular 2D</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Hall:</span>
                            <span class="detail-value">{{ $hall->cinema_name ?? '2' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Cinema:</span>
                            <span class="detail-value">{{ $hall->Hall_location->name ?? 'Legend Cinema Sihanoukville' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Location:</span>
                            <span class="detail-value">{{ $hall->Hall_location->address ?? '' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Total:</span>
                            <span class="detail-value" id="totalPrice">--</span>
                        </div>
                    </div>
{{-- filepath: c:\xampp\htdocs\aurora_cinema\resources\views\Frontend\Booking\create.blade.php --}}
{{-- ...existing code... --}}
    <div class="action-buttons">
        <button class="btn-back" onclick="history.back()">Back</button>
        @if($movie)
            @if(Auth::check())
                <form id="bookingForm" action="{{ route('booking.pay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="seats" id="seatsInput" value="">
                    <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
                    <button type="submit" class="btn-continue" id="continueBtn" disabled>Continue</button>
                </form>
            @else
                <a href="{{ route('register') }}" class="btn-continue d-block text-center" id="continueBtn" style="text-decoration:none;">
                     continue
                </a>

            @endif
        @else
            <button class="btn-continue" disabled>Movie not found</button>
        @endif
    </div>
    {{-- ...existing code... --}}
                </div>
            </div>
        </div>
    </div>


<script>
        document.addEventListener('DOMContentLoaded', function () {
            let selectedSeats = [];
            const seatPrice = 3.00;

            // Handle seat selection
            document.querySelectorAll('.seat.available').forEach(seat => {
                seat.addEventListener('click', function () {
                    const seatId = this.dataset.seatId;
                    const seatNumber = this.dataset.seatNumber;
                    const seatLabel =  seatNumber;

                    if (this.classList.contains('selected')) {
                        // Deselect seat
                        this.classList.remove('selected');
                        selectedSeats = selectedSeats.filter(s => s.id !== seatId);
                    } else {
                        // Select seat
                        this.classList.add('selected');
                        selectedSeats.push({
                            id: seatId,
                            number: seatNumber,
                            label: seatLabel
                        });
                    }

                    updateOrderDetails();
                });
            });

            function updateOrderDetails() {
                const seatIcon = document.getElementById('seatIcon');
                const selectedSeatsTags = document.getElementById('selectedSeatsTags');
                const emptyMessage = document.getElementById('emptyMessage');
                const totalPrice = document.getElementById('totalPrice');
                const continueBtn = document.getElementById('continueBtn');
                const seatsInput = document.getElementById('seatsInput');

                if (selectedSeats.length === 0) {
                    seatIcon.style.color = '#555';
                    selectedSeatsTags.innerHTML = '';
                    emptyMessage.style.display = 'block';
                    totalPrice.textContent = '--';
                    continueBtn.disabled = true;
                    seatsInput.value = '';
                } else {
                    seatIcon.style.color = '#ff4757';
                    emptyMessage.style.display = 'none';

                    // Create seat tags
                    selectedSeatsTags.innerHTML = selectedSeats.map(seat =>
                        `<span class="seat-tag">${seat.label}</span>`
                    ).join('');

                    // Update total price
                    const total = selectedSeats.length * seatPrice;
                    totalPrice.textContent = '$' + total.toFixed(2);

                    // Enable continue button
                    continueBtn.disabled = false;

                    // Update seats input
                    seatsInput.value = JSON.stringify(selectedSeats.map(s => s.id));
                }
            }

            // Zoom functionality
            let currentZoom = 1;
            const seatMap = document.querySelector('.seat-map');

            document.getElementById('zoomIn').addEventListener('click', function () {
                currentZoom = Math.min(currentZoom + 0.1, 1.5);
                seatMap.style.transform = `scale(${currentZoom})`;
            });

            document.getElementById('zoomOut').addEventListener('click', function () {
                currentZoom = Math.max(currentZoom - 0.1, 0.7);
                seatMap.style.transform = `scale(${currentZoom})`;
            });
        });
    </script>

@endsection
