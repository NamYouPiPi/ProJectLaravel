{{-- filepath: c:\xampp\htdocs\aurora_cinema\resources\views\auth\login.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="auth-modal-bg min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="auth-modal-card p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="btn-group w-100" role="group">
                    <a href="{{ route('register') }}" class="btn btn-dark rounded-pill me-2" style="flex:1;">Sign up</a>
                    <a href="{{ route('login') }}" class="btn btn-dark active rounded-pill" style="flex:1;">Sign in</a>
                </div>
                <a href="{{ url('/') }}" class="btn-close ms-3" aria-label="Close"></a>
            </div>
            <h4 class="fw-bold mb-4 text-white">Sign in to your account</h4>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <input id="email" type="email" class="form-control glass-input @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        placeholder="Enter your email">
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-4">
                    <input id="password" type="password"
                        class="form-control glass-input @error('password') is-invalid @enderror" name="password" required
                        autocomplete="current-password" placeholder="Password">
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-light fw-bold py-2 rounded-pill">
                        Sign in
                    </button>
                </div>
                <div class="text-center text-secondary mb-3">OR CONTINUE WITH</div>
                <div class="d-flex gap-2 mb-3">
                    <a href="{{ route('login.google', 'google') }}"
                        class="btn btn-dark w-100 rounded-pill d-flex align-items-center justify-content-center gap-2">
                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg"
                            alt="Google" width="20">
                        Google
                    </a>
                </div>
                <div class="text-center mt-3 text-secondary" style="font-size: 0.9rem;">
                    <a href="{{ route('password.request') }}" class="text-white text-decoration-underline">Forgot
                        password?</a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .auth-modal-bg {
            background: radial-gradient(ellipse at top, #2d0b0b 0%, #000 100%);
            min-height: 100vh;
        }

        .auth-modal-card {
            background: rgba(30, 30, 30, 0.85);
            border-radius: 2rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            max-width: 400px;
            width: 100%;
            color: #fff;
            position: relative;
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.18) !important;
            color: #fff !important;
            border-radius: 0.75rem !important;
            font-size: 1rem;
            padding: 0.75rem 1rem;
            transition: border-color 0.2s;
        }

        .glass-input:focus {
            border-color: #e50914 !important;
            background: rgba(255, 255, 255, 0.15) !important;
            color: #fff !important;
            box-shadow: 0 0 0 0.15rem rgba(229, 9, 20, .15);
        }

        .btn-dark.active,
        .btn-dark:active,
        .btn-dark:focus {
            background: #222 !important;
            color: #fff !important;
            border: none;
        }

        .btn-close {
            filter: invert(1);
            opacity: 0.7;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .btn-light {
            background: linear-gradient(90deg, #fff 60%, #e0e0e0 100%);
            color: #222;
            border: none;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .btn-light:hover,
        .btn-light:focus {
            background: linear-gradient(90deg, #e0e0e0 60%, #fff 100%);
            color: #e50914;
        }

        .btn-dark {
            background: #181818;
            color: #fff;
            border: none;
            font-weight: 500;
        }

        .btn-dark:hover,
        .btn-dark:focus {
            background: #222;
            color: #e50914;
        }

        .invalid-feedback {
            color: #ffb3b3;
        }

        @media (max-width: 576px) {
            .auth-modal-card {
                padding: 1.5rem !important;
                border-radius: 1.2rem;
            }
        }
    </style>
@endsection
