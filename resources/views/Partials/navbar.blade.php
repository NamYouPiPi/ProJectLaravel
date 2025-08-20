<header class="nav">
  <nav class="nav-container">
    <!-- Logo -->
    <a href="{{ route('fe.cinemagic') }}" class="logo">🎬 Cinemagic</a>

    <!-- Links (always use named routes in the /cinemagic group) -->
    <ul class="links">
      <li><a href="{{ route('fe.cinemagic') }}">Home</a></li>
      <li><a href="{{ route('fe.review') }}">Reviews</a></li>
      <li><a href="{{ route('fe.booking') }}">Booking</a></li>
      <li><a href="{{ route('fe.movies') }}">Movies</a></li>
      <li><a href="{{ route('fe.menu') }}">Menu</a></li>
    </ul>

    <!-- Actions -->
    <div class="actions">
      <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#customerAuthModal">
        Sign in
      </button>
    </div>
  </nav>
</header>

{{-- ================= Customer Sign-in Modal ================= --}}
<div class="modal fade" id="customerAuthModal" tabindex="-1" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-light border-0 rounded-3">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title">Customer Sign in</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body pt-3">
        <form method="POST"
              action="{{ Route::has('customer.login') ? route('customer.login') : url('/customer/login') }}">
          @csrf

          <div class="mb-3 input-group">
            <span class="input-group-text">@</span>
            <input type="email" name="email" class="form-control" placeholder="customer@example.com" required>
          </div>

          <div class="mb-3 input-group">
            <span class="input-group-text">🔒</span>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="rememberCustomer" name="remember">
            <label class="form-check-label" for="rememberCustomer">Remember me</label>
          </div>

          <button type="submit" class="btn btn-warning w-100">Sign in</button>
        </form>

        <hr class="border-secondary my-4">

        <div class="text-center">
          <small class="text-secondary">Don’t have an account?</small>
          <button class="btn btn-outline-light btn-sm ms-2"
                  data-bs-target="#customerSignupModal" data-bs-toggle="modal">
            Sign up
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ================= Customer Sign-up Modal ================= --}}
<div class="modal fade" id="customerSignupModal" tabindex="-1" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-light border-0 rounded-3">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title">Create your account</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body pt-3">
        <form method="POST"
              action="{{ Route::has('customer.register') ? route('customer.register') : url('/customer/register') }}">
          @csrf

          <div class="mb-3 input-group">
            <span class="input-group-text">👤</span>
            <input type="text" name="name" class="form-control" placeholder="Full name" required>
          </div>

          <div class="mb-3 input-group">
            <span class="input-group-text">@</span>
            <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
          </div>

          <div class="mb-3 input-group">
            <span class="input-group-text">🔒</span>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>

          <button type="submit" class="btn btn-warning w-100">Create Account</button>
        </form>

        <div class="text-center mt-3">
          <button class="btn btn-link text-secondary p-0"
                  data-bs-target="#customerAuthModal" data-bs-toggle="modal">
            Back to sign in
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ================= Scoped Styles ================= --}}
<style>
  .nav{background:#0b1017;border-bottom:1px solid #151b25}
  .nav-container{max-width:1200px;margin:auto;padding:14px 20px;display:flex;align-items:center;justify-content:space-between}
  .logo{font-weight:700;color:#ffd54a;text-decoration:none}
  .links{list-style:none;display:flex;gap:20px;margin:0;padding:0}
  .links a{color:#cbd5e1;text-decoration:none}
  .links a:hover{color:#fff}
  .actions{display:flex;align-items:center;gap:10px}
  .btn{padding:8px 14px;border-radius:10px;font-weight:600;text-decoration:none;border:none}
  .btn-warning{background:#ffd54a;color:#111}
  .btn-warning:hover{background:#facc15;color:#111}

  /* Dark modal inputs */
  .modal .form-control, .modal .form-select { background:#111827; color:#e5e7eb; border-color:#1f2937; }
  .modal .form-control::placeholder { color:#9ca3af; }
  .modal .input-group-text { background:#0f172a; color:#e5e7eb; border-color:#1f2937; }
</style>

{{-- Bootstrap (for modal + scroll lock) --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
