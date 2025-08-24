@extends('Backend.layouts.app')
@section('content')
@section('title', 'Add Booking Seat')
@section('booking', 'active')
    @include('Backend.components.Toast')

    <div class="card shadow">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Add New Booking Seat</h3>
                <a href="{{ route('booking-seats.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Booking Seats
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('booking-seats.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="booking_id" class="form-label">Booking</label>
                        <select name="booking_id" id="booking_id"
                            class="form-select @error('booking_id') is-invalid @enderror" required
                            onchange="loadSeatsForBooking(this.value)">
                            <option value="">Select Booking</option>
                            @foreach ($bookings as $booking)
                                <option value="{{ $booking->id }}" {{ old('booking_id', $booking_id ?? null) == $booking->id ? 'selected' : '' }}>
                                    {{ $booking->booking_reference }} - {{ $booking->customer->name }}
                                    ({{ $booking->showtime->movie->title }})
                                </option>
                            @endforeach
                        </select>
                        @error('booking_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="seat_id" class="form-label">Seat</label>
                        <select name="seat_id" id="seat_id" class="form-select @error('seat_id') is-invalid @enderror"
                            required>
                            <option value="">Select Seat</option>
                            @foreach ($seats as $seat)
                                <option value="{{ $seat->id }}" {{ old('seat_id') == $seat->id ? 'selected' : '' }}
                                    data-price="{{ $seat->price }}">
                                    Row {{ $seat->row }}, Seat {{ $seat->seat_number }} ({{ $seat->type }})
                                </option>
                            @endforeach
                        </select>
                        @error('seat_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" name="price" id="price"
                            class="form-control @error('price') is-invalid @enderror" value="{{ old('price', '0.00') }}"
                            step="0.01" min="0" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" aria-label="Please select status"
                            class="form-select @error('status') is-invalid @enderror" required>
                            <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-gradient">Add Booking Seat</button>
                    <a href="{{ route('booking-seats.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Seat Visualization Card --}}
    <div class="card shadow mt-4">
        <div class="card-header">
            <h4>Seat Visualization</h4>
        </div>
        <div class="card-body">
            <div id="seat-loading" class="text-center">
                <p>Please select a booking to view available seats</p>
            </div>
            <div id="seat-map" class="d-none">
                <div class="text-center mb-4">
                    <div class="screen-container">
                        <div class="screen">SCREEN</div>
                    </div>
                </div>
                <div id="seat-container" class="d-flex flex-wrap justify-content-center gap-2">
                    <!-- Seats will be loaded here -->
                </div>
                <div class="mt-4 d-flex justify-content-center gap-4">
                    <div class="d-flex align-items-center">
                        <div class="seat-box available"></div>
                        <span class="ms-2">Available</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="seat-box booked"></div>
                        <span class="ms-2">Booked</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="seat-box selected"></div>
                        <span class="ms-2">Selected</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .screen-container {
            perspective: 500px;
            margin-bottom: 30px;
        }

        .screen {
            background-color: #fff;
            height: 70px;
            width: 70%;
            margin: 0 auto;
            transform: rotateX(-45deg);
            box-shadow: 0 3px 10px rgba(255, 255, 255, 0.7);
            text-align: center;
            line-height: 70px;
            font-weight: bold;
            color: #666;
            border: 1px solid #ddd;
        }

        .seat-box {
            width: 30px;
            height: 30px;
            margin: 3px;
            border-radius: 5px;
        }

        .available {
            background-color: #444451;
            cursor: pointer;
        }

        .booked {
            background-color: #ff4757;
        }

        .selected {
            background-color: #6c63ff;
        }

        .seat-row {
            display: flex;
            justify-content: center;
            margin-bottom: 8px;
        }

        .row-label {
            width: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 8px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const booking_id = document.getElementById('booking_id').value;
            if (booking_id) {
                loadSeatsForBooking(booking_id);
            }

            // Update price when seat is selected
            document.getElementById('seat_id').addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const price = selectedOption.getAttribute('data-price');
                    document.getElementById('price').value = price || '0.00';
                }
            });
        });

        function loadSeatsForBooking(bookingId) {
            if (!bookingId) {
                document.getElementById('seat-map').classList.add('d-none');
                document.getElementById('seat-loading').classList.remove('d-none');
                return;
            }

            document.getElementById('seat-loading').innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';

            // Get the showtime ID from the selected booking
            fetch(`/bookings/${bookingId}`)
                .then(response => response.json())
                .then(data => {
                    const showtime_id = data.showtime_id;
                    return fetch(`/get-seats-for-showtime/${showtime_id}`);
                })
                .then(response => response.json())
                .then(data => {
                    // Populate seat dropdown
                    const seatDropdown = document.getElementById('seat_id');
                    seatDropdown.innerHTML = '<option value="">Select Seat</option>';

                    data.available_seats.forEach(seat => {
                        const option = document.createElement('option');
                        option.value = seat.id;
                        option.textContent = `Row ${seat.row}, Seat ${seat.seat_number} (${seat.type})`;
                        option.setAttribute('data-price', seat.price);
                        seatDropdown.appendChild(option);
                    });

                    // Render seat visualization
                    renderSeatMap(data.all_seats, data.booked_seats);

                    document.getElementById('seat-loading').classList.add('d-none');
                    document.getElementById('seat-map').classList.remove('d-none');
                })
                .catch(error => {
                    console.error('Error loading seats:', error);
                    document.getElementById('seat-loading').innerHTML = '<p class="text-danger">Error loading seats. Please try again.</p>';
                });
        }

        function renderSeatMap(allSeats, bookedSeats) {
            const seatContainer = document.getElementById('seat-container');
            seatContainer.innerHTML = '';

            // Group seats by row
            const seatsByRow = {};
            allSeats.forEach(seat => {
                if (!seatsByRow[seat.row]) {
                    seatsByRow[seat.row] = [];
                }
                seatsByRow[seat.row].push(seat);
            });

            // Get booked seat IDs
            const bookedSeatIds = bookedSeats.map(bs => bs.seat_id);

            // Create row elements
            Object.keys(seatsByRow).sort().forEach(row => {
                const rowDiv = document.createElement('div');
                rowDiv.className = 'seat-row';

                const rowLabel = document.createElement('div');
                rowLabel.className = 'row-label';
                rowLabel.textContent = row;
                rowDiv.appendChild(rowLabel);

                // Sort seats by seat_number
                seatsByRow[row].sort((a, b) => a.seat_number - b.seat_number).forEach(seat => {
                    const seatDiv = document.createElement('div');
                    seatDiv.className = 'seat-box';
                    seatDiv.dataset.id = seat.id;
                    seatDiv.dataset.row = seat.row;
                    seatDiv.dataset.number = seat.seat_number;
                    seatDiv.dataset.price = seat.price;
                    seatDiv.title = `Row ${seat.row}, Seat ${seat.seat_number} (${seat.type}) - $${seat.price}`;

                    if (bookedSeatIds.includes(seat.id)) {
                        seatDiv.classList.add('booked');
                    } else {
                        seatDiv.classList.add('available');
                        seatDiv.addEventListener('click', function () {
                            selectSeat(this.dataset.id, this.dataset.price);

                            // Remove selected class from all seats
                            document.querySelectorAll('.seat-box.selected').forEach(el => {
                                el.classList.remove('selected');
                                el.classList.add('available');
                            });

                            // Add selected class to this seat
                            this.classList.remove('available');
                            this.classList.add('selected');
                        });
                    }

                    rowDiv.appendChild(seatDiv);
                });

                seatContainer.appendChild(rowDiv);
            });
        }

        function selectSeat(seatId, price) {
            const seatDropdown = document.getElementById('seat_id');
            seatDropdown.value = seatId;

            const priceInput = document.getElementById('price');
            priceInput.value = price || '0.00';
        }
    </script>
@endsection