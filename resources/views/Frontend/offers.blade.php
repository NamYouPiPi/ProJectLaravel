@extends('layouts.app')

@section('content')
  <!-- Promo Section -->
  <section class="px-4 py-5">
    <div class="container promo-section mx-auto">
      <div class="promo-card">
        <div class="row g-0 align-items-center">

          <!-- Left Image -->
          <div class="col-md-6 p-4">
            <img
              id="carouselImage"
              src="./final image/photo_2025-08-22_18-50-51.jpg"
              alt="Legend App Promo"
              class="img-fluid promo-image mx-auto d-block"
            />
          </div>

          <!-- Right Content -->
          <div class="col-md-6 p-4 text-center text-md-start">
            <h2 class="h2 fw-bold mb-3 text-white" style="line-height: 1.2;">
              បញ្ចុះតម្លៃពិសេស សម្រាប់សមាជិក Aurura Cinemas
            </h2>

            <div class="row g-2 mb-3 text-yellow-custom">
              <div class="col-4">
                <p class="h4 fw-bold mb-1">10%</p>
                <p class="small text-white mb-0">ចំណាយលើសំបុត្រ</p>
              </div>
              <div class="col-4">
                <p class="h4 fw-bold mb-1">10%</p>
                <p class="small text-white mb-0">លើម្ហូប & ពិសារ</p>
              </div>
              <div class="col-4">
                <p class="h4 fw-bold mb-1">5%</p>
                <p class="small text-white mb-0">លើការទិញសាច់ប្រាក់</p>
              </div>
            </div>

            <div class="mt-3 d-flex justify-content-center justify-content-md-start gap-3 flex-wrap">
              <a href="#" class="btn btn-white-custom px-3 py-2 rounded">
                បើកបញ្ចូល App
              </a>
              <a href="#" class="link-custom align-self-center">
                www.AURURA.com.kh
              </a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- Promotion Title -->
  <div class="container">
    <h2 class="display-3 fw-bold mb-4 px-2">Promotion</h2>
    <hr class="border-light fw-bold">
  </div>

  <!-- Offers Grid -->
  <section class="container section-max-width mx-auto px-4 py-5">
    <div class="row g-4">

      <!-- Card 1 -->
      <div class="col-sm-6 col-lg-4">
        <div class="offer-card">
          <img src="./final image/movies.avif" alt="Movie" class="w-100">
          <div class="p-3">
            <h3 class="h5 fw-semibold mb-2">Hurry up! The Undertaker is now showing!</h3>
            <p class="small text-gray-400 mb-0">Book your tickets at any Legend location.</p>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-sm-6 col-lg-4">
        <div class="offer-card">
          <img src="./final image/Screenshot 2025-08-25 141659.png" alt="Membership" class="w-100">
          <div class="p-3">
            <h3 class="h5 fw-semibold mb-2">Unlock Incredible Perks</h3>
            <p class="small text-gray-400 mb-0">Get discounts with Legend Membership Card!</p>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-sm-6 col-lg-4">
        <div class="offer-card">
          <img src="./final image/Screenshot 2025-08-25 155908.png" alt="Movie" class="w-100">
          <div class="p-3">
            <h3 class="h5 fw-semibold mb-2">Hurry up! The Undertaker is now showing!</h3>
            <p class="small text-gray-400 mb-0">Book your tickets at any Legend location.</p>
          </div>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="col-sm-6 col-lg-4">
        <div class="offer-card">
          <img src="./final image/1536x864_Retail_Banner_3_Snacks_no_text-min.webp" alt="Membership" class="w-100">
          <div class="p-3">
            <h3 class="h5 fw-semibold mb-2">Unlock Incredible Perks</h3>
            <p class="small text-gray-400 mb-0">Get discounts with Legend Membership Card!</p>
          </div>
        </div>
      </div>

      <!-- You can add more cards here following the same pattern -->

    </div>
  </section>

  <!-- Bootstrap JS Bundle -->

  <!-- JavaScript for Image Carousel -->
  <script>
    const images = [
      'final image/photo_2025-08-22_19-09-38.jpg',
      'final image/photo_2025-08-22_19-09-27.jpg',
      'final image/photo_2025-08-22_18-49-13.jpg',
      'final image/photo_2025-08-22_19-10-34.jpg'
    ];

    let current = 0;
    const carouselImage = document.getElementById('carouselImage');

    setInterval(() => {
      current = (current + 1) % images.length;
      carouselImage.src = images[current];
    }, 5000);
  </script>
@endsection
