

    @extends('layouts.app')

    @section('content')

        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card shadow border-0 rounded-3">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h3 class="fw-normal">{{ __('Welcome') }}</h3>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf



                            <div class="mb-3">
                                <div class="position-relative">
                                    <div style="border-top: 1px solid #a880e9; position: relative;">
                                    <span
                                        style="position: absolute; top: -10px; left: 0; background: white; padding: 0 5px; color: #a880e9; font-size: 14px;">
                                        {{ __('Email') }}
                                    </span>
                                    </div>
                                    <input id="email" type="Email"
                                           class="form-control form-control-lg @error('email') is-invalid @enderror border-0"
                                           name="email" required autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="position-relative">
                                    <div style="border-top: 1px solid #a880e9; position: relative;">
                                    <span
                                        style="position: absolute; top: -10px; left: 0; background: white; padding: 0 5px; color: #a880e9; font-size: 14px;">
                                        {{ __('Password') }}
                                    </span>
                                    </div>
                                    <input id="password" type="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror border-0"
                                           name="password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember me') }}
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none" href="{{ route('password.request') }}"
                                       style="color: #a880e9;">
                                        {{ __('Forgot password?') }}
                                    </a>
                                @endif
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-lg text-white" style="background-color: #7e3ff2;">
                                    {{ __('Sign In') }}
                                </button>
                            </div>
                        </form>

                        <div class="text-center mb-3">
                            <div class="position-relative">
                                <hr class="my-3">
                                <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted">
                                {{ __('Or') }}
                            </span>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mb-4">
                            <a href="{{ route('login.google') }}"
                               class="btn btn-outline-secondary flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                                <img src="https://img.icons8.com/color/20/000000/google-logo.png">
                                <span>{{ __('Sign in with Google') }}</span>
                            </a>
                            {{-- <a href="{{ route('login.twitter') }}" class="btn btn-outline-secondary"
                                style="width: 50px;">
                                <i class="fab fa-twitter text-info"></i>
                            </a> --}}
                        </div>

                        <div class="text-center">
                            <p class="mb-0 text-muted">
                                {{ __("Don't have account") }}
                                <a href="{{ route('register') }}" class="text-decoration-none fw-medium"
                                   style="color: #7e3ff2;">
                                    {{ __('Sign up') }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    @endsection
