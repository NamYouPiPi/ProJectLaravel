@extends('layouts.app')

@section('content')
    @php
        $seatRows = $sortedRows ?? collect();
        $movie = $movie ?? null;
        $showtime = $showtime ?? null;
        $hall = $hall ?? null;
        $cinema = $cinema ?? null;
        $seats = $seats ?? collect();
        $bookedSeats = $bookedSeats ?? [];

        // Prepare seat statuses
        $seatStatuses = [];
        foreach ($seats as $seat) {
            $status = in_array($seat->id, $bookedSeats) ? 'booked' : $seat->status;
            $seatStatuses[$seat->seat_row . '-' . $seat->seat_number] = $status;
        }

        // Get sorted rows
        $rowsArray = $seatRows->keys()->sort()->reverse()->values()->toArray();
    @endphp
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #1a1a1a;
            color: white;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .screen-container {
            text-align: center;
            margin-bottom: 50px;
        }

        .screen {
            width: 80%;
            height: 8px;
            background: linear-gradient(90deg, #ff0000, #cc0000);
            margin: 0 auto 10px;
            border-radius: 20px;
        }

        .screen-label {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .seating-area {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .section {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .row-label {
            width: 20px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }

        .seat {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 2px solid #333;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
            transition: all 0.3s ease;
            position: relative;
        }

        .seat.available {
            background: #2a2a2a;
            border-color: #555;
            color: #999;
        }

        .seat.available:hover {
            background: #3a3a3a;
            border-color: #777;
            transform: scale(1.1);
        }

        .seat.selected {
            background: #ff6b35;
            border-color: #ff4500;
            color: white;
            transform: scale(1.1);
        }

        .seat.booked {
            background: #666;
            border-color: #444;
            color: #333;
            cursor: not-allowed;
        }

        .seat.reserved {
            background: #1e90ff;
            border-color: #0066cc;
            color: white;
            cursor: not-allowed;
        }

        .seat.blocked {
            background: #8b0000;
            border-color: #660000;
            color: #fff;
            cursor: not-allowed;
        }

        .seat.broken {
            background: #444;
            border-color: #222;
            color: #666;
            cursor: not-allowed;
            position: relative;
        }

        .seat.broken::after {
            content: "×";
            position: absolute;
            font-size: 16px;
            color: #ff0000;
        }

        .legend {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .legend-seat {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 2px solid;
        }

        .booking-info {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background: #2a2a2a;
            border-radius: 10px;
        }

        .selected-seats {
            margin: 10px 0;
            font-size: 16px;
        }

        .total-price {
            font-size: 24px;
            font-weight: bold;
            color: #ff6b35;
            margin: 10px 0;
        }

        .book-button {
            background: #ff6b35;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .book-button:hover {
            background: #ff4500;
        }

        .book-button:disabled {
            background: #666;
            cursor: not-allowed;
        }

        .gap {
            width: 20px;
        }
    </style>
    <div class="container py-5">
        <!-- Stepper -->
        <div class="mb-4">
            <div class="d-flex justify-content-center align-items-center">
                <div class="stepper d-flex flex-row justify-content-between w-75">
                    <div class="step text-center flex-fill">
                        <div class="circle bg-danger text-white mx-auto mb-2">1</div>
                        <div class="text-light">Showtime</div>
                    </div>
                    <div class="step text-center flex-fill">
                        <div class="circle bg-danger text-white mx-auto mb-2">2</div>
                        <div class="text-light">Choose Seat</div>
                    </div>
                    <div class="step text-center flex-fill">
                        <div class="circle bg-secondary text-white mx-auto mb-2">3</div>
                        <div class="text-light">Order Review</div>
                    </div>
                    <div class="step text-center flex-fill">
                        <div class="circle bg-secondary text-white mx-auto mb-2">4</div>
                        <div class="text-light">Checkout</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="d-flex gap-5">  <!-- Seat Map -->
              <div class="col-lg-8 mb-4">
                  <h4 class="fw-bold mb-3">Choose Seat</h4>
                  <div class="bg-dark rounded p-4">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                          <button class="btn btn-outline-danger btn-sm" disabled>
                              <i class="fas fa-clock"></i> {{ $showtime->time ?? '1:30' }}
                          </button>
                          <div>
                              <button class="btn btn-outline-light btn-sm me-2" id="zoomOut">-</button>
                              <button class="btn btn-outline-light btn-sm" id="zoomIn">+</button>
                          </div>
                      </div>
                      <div class="screen-container">
                          <div class="screen"></div>
                          <div class="screen-label">SCREEN</div>
                      </div>

                      <div class="seating-area">
                          <div class="section" id="leftSection"></div>
                          <div class="gap"></div>
                          <div class="section" id="rightSection"></div>
                      </div>

                      <div class="legend">
                          <div class="legend-item">
                              <div class="legend-seat available" style="background: #2a2a2a; border-color: #555;"></div>
                              <span>Available</span>
                          </div>
                          <div class="legend-item">
                              <div class="legend-seat selected" style="background: #ff6b35; border-color: #ff4500;"></div>
                              <span>Selected</span>
                          </div>
                          <div class="legend-item">
                              <div class="legend-seat reserved" style="background: #1e90ff; border-color: #0066cc;"></div>
                              <span>Reserved</span>
                          </div>
                          <div class="legend-item">
                              <div class="legend-seat booked" style="background: #666; border-color: #444;"></div>
                              <span>Booked</span>
                          </div>
                          <div class="legend-item">
                              <div class="legend-seat blocked" style="background: #8b0000; border-color: #660000;"></div>
                              <span>Blocked</span>
                          </div>
                          <div class="legend-item">
                              <div class="legend-seat broken" style="background: #444; border-color: #222;"></div>
                              <span>Broken</span>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Order Details Sidebar -->
              <div class="col-lg-4 mt-5">
                  <div class="bg-dark rounded p-4 sticky-top" style="top: 20px;">
                      <h5 class="fw-bold text-light mb-3">Order Details</h5>
                      <div id="selectedSeats" class="mb-3 text-light">Your seat is empty</div>
                      <div class="mb-2 text-light"><strong>Movie:</strong> {{ $movie->title }}</div>
                      <div class="mb-2 text-light"><strong>Start:</strong> {{ $showtime->start_time->format('g:i A') ?? '' }}</div>
                      <div class="mb-2 text-light"><strong>End:</strong> {{ $showtime->end_time->format('g:i A') ?? '' }}</div>
                      <div class="mb-2 text-light"><strong>Format:</strong> Adult Regular 2D</div>
                      <div class="mb-2 text-light"><strong>Hall:</strong> {{ $hall->cinema_name ?? '' }}</div>
                      <div class="mb-2 text-light"><strong>Cinema:</strong> {{ $hall->Hall_location->name ?? $hall->name ?? '' }}
                      </div>
                      <div class="mb-2 text-light"><strong>Total:</strong> $<span id="totalPrice">0.00</span></div>
                      @if($movie)
                          <form action="{{ route('booking.store', $movie->id) }}" method="POST">
                              @csrf
                              <input type="hidden" name="seats" id="seatsInput">
                              <button type="submit" class="btn btn-primary w-100 mt-3" id="continueBtn" disabled>Continue</button>
                          </form>
                      @else
                          <div class="alert alert-danger">Movie not found. Please go back and select a movie.</div>
                      @endif
                  </div>
              </div></div>
        </div>
    </div>





















    <style>
        .stepper .circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }
    </style>
    <script>
        // Seat data from database
        const seatData = {
            // Row configuration - sort rows in reverse order (L to A)
            rows: @json($rowsArray),
            leftSectionSeats: [1, 2, 3, 4, 5,],
            rightSectionSeats: [6, 7, 8, 9, 10],

            // Seat statuses from database
            seatStatuses: @json($seatStatuses),
        };

        const seatPrice = 3.00;
        let selectedSeats = [];

        function createSeatLayout() {
            const leftSection = document.getElementById('leftSection');
            const rightSection = document.getElementById('rightSection');

            seatData.rows.forEach(rowLetter => {
                // Left section
                const leftRow = document.createElement('div');
                leftRow.className = 'row';

                const leftLabel = document.createElement('div');
                leftLabel.className = 'row-label';
                leftLabel.textContent = rowLetter;
                leftRow.appendChild(leftLabel);

                seatData.leftSectionSeats.forEach(seatNumber => {
                    const seat = createSeat(rowLetter, seatNumber);
                    leftRow.appendChild(seat);
                });

                leftSection.appendChild(leftRow);

                // Right section
                const rightRow = document.createElement('div');
                rightRow.className = 'row';

                seatData.rightSectionSeats.forEach(seatNumber => {
                    const seat = createSeat(rowLetter, seatNumber);
                    rightRow.appendChild(seat);
                });

                const rightLabel = document.createElement('div');
                rightLabel.className = 'row-label';
                rightLabel.textContent = rowLetter;
                rightRow.appendChild(rightLabel);

                rightSection.appendChild(rightRow);
            });
        }

        function createSeat(row, number) {
            const seat = document.createElement('div');
            const seatId = `${row}-${number}`;

            seat.className = 'seat';
            seat.dataset.seatId = seatId;
            seat.dataset.row = row;
            seat.dataset.number = number;
            seat.textContent = number;

            // Set seat status
            const status = seatData.seatStatuses[seatId] || 'available';
            seat.classList.add(status);

            // Add click handler only for available seats
            if (status === 'available') {
                seat.addEventListener('click', toggleSeat);
            }

            return seat;
        }

        function toggleSeat(event) {
            const seat = event.target;
            const seatId = seat.dataset.seatId;

            if (seat.classList.contains('selected')) {
                seat.classList.remove('selected');
                seat.classList.add('available');
                selectedSeats = selectedSeats.filter(id => id !== seatId);
            } else if (seat.classList.contains('available')) {
                seat.classList.remove('available');
                seat.classList.add('selected');
                selectedSeats.push(seatId);
            }

            updateBookingInfo();
        }

        function updateBookingInfo() {
            const selectedSeatsText = document.getElementById('selectedSeats');
            const totalPriceText = document.getElementById('totalPrice');
            const seatsInput = document.getElementById('seatsInput');
            const continueBtn = document.getElementById('continueBtn');

            if (selectedSeats.length === 0) {
                selectedSeatsText.textContent = 'Your seat is empty';
                totalPriceText.textContent = '0.00';
                seatsInput.value = '';
                continueBtn.disabled = true;
            } else {
                selectedSeatsText.textContent = selectedSeats.sort().join(', ');
                totalPriceText.textContent = (selectedSeats.length * seatPrice).toFixed(2);
                seatsInput.value = selectedSeats.join(',');
                continueBtn.disabled = false;
            }
        }

        // Initialize the seat layout
        createSeatLayout();

        // Zoom functionality
        let zoom = 1;
        const seatMap = document.querySelector('.seating-area');

        document.getElementById('zoomIn').addEventListener('click', function () {
            zoom = Math.min(2, zoom + 0.1);
            seatMap.style.transform = `scale(${zoom})`;
        });

        document.getElementById('zoomOut').addEventListener('click', function () {
            zoom = Math.max(0.5, zoom - 0.1);
            seatMap.style.transform = `scale(${zoom})`;
        });
    </script>
@endsection
