{{-- Safe navbar include (tries several locations) --}}
@if (View::exists('Frontend.Partials.navbar'))
  @include('Frontend.Partials.navbar')
@elseif (View::exists('Frontend.partials.navbar'))
  @include('Frontend.partials.navbar')
@elseif (View::exists('partials.navbar'))
  @include('partials.navbar')
@endif

<section class="auth-container">
  <h1 class="page-title">Sign in</h1>

  <div class="card auth-card">
    <h3 class="h5 mb-3">Customer Sign in</h3>

    @if ($errors->any())
      <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
    @endif

    <form method="POST"
          action="{{ \Illuminate\Support\Facades\Route::has('customer.login') ? route('customer.login') : url('/customer/login') }}">
      @csrf

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email"
               name="email"
               class="form-control"
               placeholder="customer@example.com"
               value="{{ old('email') }}"
               required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password"
               name="password"
               class="form-control"
               placeholder="********"
               required>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="remember" id="rememberCustomer">
        <label class="form-check-label" for="rememberCustomer">Remember me</label>
      </div>

      <button class="btn btn-warning w-100">Sign in</button>
    </form>

    <div class="signup mt-4">
      <span>Don’t have an account?</span>
      <a href="{{ \Illuminate\Support\Facades\Route::has('customer.register') ? route('customer.register') : url('/customer/register') }}">
        Sign up
      </a>
    </div>
  </div>
</section>

<style>
  body { background:#0b1017; }

  .auth-container{
    max-width:900px;
    margin:40px auto;
    padding:0 20px;
  }

  .page-title{
    color:#fff;
    font-size:56px;
    margin-bottom:20px;
  }

  .auth-card{
    background:#1f2937;
    color:#e5e7eb;
    border:0;
    border-radius:14px;
    padding:24px;
    box-shadow:0 10px 30px rgba(0,0,0,.25);
  }

  .form-control{
    background:#0f172a;
    color:#e5e7eb;
    border:1px solid #1f2937;
    border-radius:10px;
    height:46px;
  }

  .form-control::placeholder{ color:#9ca3af; }

  .btn-warning{
    background:#ffd54a;
    color:#111;
    border:none;
  }
  .btn-warning:hover{ background:#facc15; }

  .signup{ display:flex; gap:8px; align-items:center; }
  .signup a{ color:#ffd54a; text-decoration:none; }
  .signup a:hover{ color:#facc15; }
</style>
