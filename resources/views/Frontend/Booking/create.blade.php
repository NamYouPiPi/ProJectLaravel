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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e1e1e 0%, #2d2d2d 100%);
            color: white;
            min-height: 100vh;
        }

        .main-container {
            background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .content-wrapper {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Stepper Styles */
        .stepper-container {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
        }

        .stepper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .stepper::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #ff4757 0%, #ff4757 50%, #555 50%, #555 100%);
            z-index: 1;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(26, 26, 26, 0.8);
            padding: 10px 20px;
            border-radius: 25px;
            position: relative;
            z-index: 2;
        }

        .step.active {
            background: linear-gradient(45deg, #ff4757, #ff3742);
        }

        .step.completed {
            background: linear-gradient(45deg, #ff4757, #ff3742);
        }

        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .step.active .step-number,
        .step.completed .step-number {
            background: rgba(255, 255, 255, 0.3);
        }

        .step-text {
            font-weight: 500;
            font-size: 14px;
        }

        /* Layout */
        .main-content {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
        }

        /* Seat Selection Area */
        .seat-selection-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 30px;
        }

        .showtime-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(45deg, #ff4757, #ff3742);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .zoom-controls {
            display: flex;
            gap: 5px;
        }

        .zoom-btn {
            width: 35px;
            height: 35px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .zoom-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        /* Screen */
        .screen-area {
            text-align: center;
            margin-bottom: 40px;
        }

        .screen {
            width: 70%;
            height: 6px;
            background: linear-gradient(90deg, #ff4757, #ff6b7d);
            margin: 0 auto 15px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 71, 87, 0.3);
        }

        .screen-label {
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 4px;
            color: #ccc;
        }

        /* Seat Map */
        .seat-map-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .seat-map {
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: center;
        }

        .seat-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .row-label {
            width: 30px;
            text-align: center;
            font-weight: bold;
            color: #888;
            font-size: 16px;
        }

        .seats-container {
            display: flex;
            gap: 8px;
        }

        .seat {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 2px solid transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .seat::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .seat.available {
            background: linear-gradient(145deg, #3a3a3a, #2a2a2a);
            border-color: #555;
            color: #999;
        }

        .seat.available:hover {
            background: linear-gradient(145deg, #4a4a4a, #3a3a3a);
            border-color: #ff4757;
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(255, 71, 87, 0.3);
        }

        .seat.selected {
            background: linear-gradient(145deg, #ff4757, #ff3742);
            border-color: #ff2f3e;
            color: white;
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(255, 71, 87, 0.4);
        }

        .seat.booked {
            background: linear-gradient(145deg, #666, #555);
            border-color: #444;
            color: #333;
            cursor: not-allowed;
        }

        .seat.reserved {
            background: linear-gradient(145deg, #2196f3, #1976d2);
            border-color: #0d47a1;
            color: white;
            cursor: not-allowed;
        }

        .seat.blocked {
            background: linear-gradient(145deg, #8b0000, #660000);
            border-color: #4a0000;
            color: #fff;
            cursor: not-allowed;
        }

        .seat.broken {
            background: linear-gradient(145deg, #444, #333);
            border-color: #222;
            color: #666;
            cursor: not-allowed;
            position: relative;
        }

        .seat.broken::after {
            content: "×";
            position: absolute;
            font-size: 18px;
            color: #ff0000;
        }

        /* Legend */
        .legend {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #ccc;
        }

        .legend-seat {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 2px solid;
        }

        /* Order Details Sidebar */
        .order-details-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 25px;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .order-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 25px;
            color: white;
        }

        .selected-seats-display {
            text-align: center;
            padding: 25px;
            margin-bottom: 25px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .seat-icon {
            font-size: 48px;
            color: #555;
            margin-bottom: 15px;
        }

        .selected-seats-tags {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin: 15px 0;
        }

        .seat-tag {
            background: linear-gradient(45deg, #ff4757, #ff3742);
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }

        .empty-seats-message {
            color: #888;
            font-style: italic;
        }

        .order-details-list {
            margin-bottom: 25px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .detail-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 18px;
            color: #ff4757;
        }

        .detail-label {
            color: #ccc;
            font-weight: 500;
        }

        .detail-value {
            color: white;
            font-weight: 500;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .btn-back {
            flex: 1;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .btn-continue {
            flex: 1;
            background: linear-gradient(45deg, #ff4757, #ff3742);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-continue:hover {
            background: linear-gradient(45deg, #ff3742, #e73c3c);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 71, 87, 0.3);
        }

        .btn-continue:disabled {
            background: #666;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-content {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .order-details-card {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .stepper {
                flex-direction: column;
                gap: 15px;
            }

            .stepper::before {
                display: none;
            }

            .seat {
                width: 28px;
                height: 28px;
                font-size: 11px;
            }

            .legend {
                gap: 15px;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>

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
                                            @endphp
                                            <button class="seat {{ $status }}"
                                                data-seat-id="{{ is_object($seat) && isset($seat->id) ? $seat->id : '' }}"

                                                data-seat-number="{{  $seat->seat_number  }}"
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
                            <span class="detail-value">{{ $showtime->date ?? 'Thu, 28 Aug' }}</span>
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
                            <span class="detail-value">{{ $Hall_location->name ?? 'Legend Cinema Sihanoukville' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Total:</span>
                            <span class="detail-value" id="totalPrice">--</span>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button class="btn-back" onclick="history.back()">Back</button>
                        @if($movie)
                            <form id="bookingForm" action="{{ route('bookingseats.payment', $movie->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                <input type="hidden" name="seats" id="seatsInput">
                                <button type="submit" class="btn-continue" id="continueBtn" disabled>Continue</button>
                            </form>
                        @else
                            <button class="btn-continue" disabled>Movie not found</button>
                        @endif
                    </div>
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
