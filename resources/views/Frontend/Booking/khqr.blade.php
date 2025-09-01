{{-- filepath: c:\xampp\htdocs\aurora_cinema\resources\views\Frontend\Booking\khqr.blade.php --}}
@extends('layouts.app')

@section('content')
    <!-- Modal Trigger (hidden, auto-triggered by JS) -->
    <button type="button" id="khqrModalBtn" class="d-none" data-bs-toggle="modal" data-bs-target="#khqrModal"></button>

    <!-- KHQR Modal -->
    <div class="modal fade" id="khqrModal" tabindex="-1" aria-labelledby="khqrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class=" text-center" id="khqrModalLabel">KHQR</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="text-dark">AURORA CINEMAS</p>
                    <div class="mb-3" style="font-size: 1.5rem; font-weight: bold;">
                        @if(isset($booking) && $booking->total_price)
                            {{ number_format($booking->total_price, 2) }} USD
                        @endif
                    </div>

                    <img src="{{ $qrImage }}" alt="ABA KHQR Code"
                        style="width:220px;height:220px; border:8px solid #f5f5f5; background:#fff;">
                    @if($abapay_deeplink)
                        <div class="mt-3">
                            <a href="{{ $abapay_deeplink }}" class="btn btn-danger w-100">Pay with ABA App</a>
                        </div>
                    @endif
                    <div class="mt-3 text-muted" style="font-size: 0.95rem;">
                        Scan with ABA Mobile, or other Mobile Banking App supporting KHQR.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-show the modal on page load -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('khqrModalBtn').click();
        });
    </script>
@endsection
