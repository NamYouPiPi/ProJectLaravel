@extends('layouts.app')

@section('content')
    <!-- Promo Section -->
    <section class="px-4 py-5">
        <div class="container promo-section mx-auto">
            <div class="promo-card">
                <div class="row g-0 align-items-center">

                    <!-- Left Image -->
                    <div class="col-md-6 p-4">
                        <img id="carouselImage" src="./final image/photo_2025-08-22_18-50-51.jpg" alt="Legend App Promo"
                            class="img-fluid promo-image mx-auto d-block" />
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
            @foreach ($promotions as $promotion)

                <div class="col-sm-6 col-lg-4">
                    <div class="offer-card">
                        <img src="{{ 'storage/' . $promotion->proImage }}" alt="Movie" class="w-100">
                        <div class="p-3">
                            <h3 class="h5 fw-semibold mb-2">{{ $promotion->title }}</h3>
                            <p class="small text-gray-400 mb-0">{{ $promotion->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach



        </div>
</section>

    <!-- Bootstrap JS Bundle -->

    <!-- JavaScript for Image Carousel -->
    <script>
        const images = [
            'https://i.pinimg.com/1200x/4c/2b/16/4c2b16be507a2972e74b1ca12659e598.jpg',
            'https://i.pinimg.com/1200x/a2/3b/e0/a23be0b6f8bc93891164c27b03b0fa68.jpg',
            'https://i.pinimg.com/736x/d7/10/90/d71090d35a2f11c567e03b760e2bff28.jpg',
            'https://scontent.fpnh5-2.fna.fbcdn.net/v/t39.30808-6/539454908_1311255543693172_2860812698611203095_n.jpg?_nc_cat=107&cb=99be929b-7bdcbe47&ccb=1-7&_nc_sid=833d8c&_nc_eui2=AeEun0_HD7YO-s9X2VsaCX7Jo_QxL9SEOgyj9DEv1IQ6DKr-yNm63eam9ELvt2EZFu5BydzHtOicACVqO3yvvvC_&_nc_ohc=6RDTIA3Vsv0Q7kNvwHWO8FH&_nc_oc=AdkIF3nb9teMJK5-UddpigUcl5f0HrQFb38MngjvdXTbz3jx7wHoKan2kgnDK42J_rw&_nc_zt=23&_nc_ht=scontent.fpnh5-2.fna&_nc_gid=y7u0BMslOpwWxKOAphgCiw&oh=00_AfZRzv-oLaDuF4dAbLrPwzHbgFSi63OI0YgyzX4miGaGIw&oe=68BD9489'
        ];

        let current = 0;
        const carouselImage = document.getElementById('carouselImage');

        setInterval(() => {
            current = (current + 1) % images.length;
            carouselImage.src = images[current];
        }, 3000);
    </script>
@endsection
