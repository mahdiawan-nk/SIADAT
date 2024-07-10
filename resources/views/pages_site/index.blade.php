@extends('layout.site.app')

@section('pages')
    <!-- Carousel Start -->
    <div class="container-fluid p-0">
        <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('static-file/sample-1.jpg') }}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h1 class="ml1 display-2 text-uppercase text-white">
                                <span class="text-wrapper">
                                    <span class="letters">SELAMAT DATANG DI WEBSITE LEMBAGA ADAT
                                        KAMPAR</span>
                                </span>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Carousel End -->

    <!-- Blog Start -->
    <div class="container-fluid py-6 px-5">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <h1 class="display-5 text-uppercase mb-4">Latest <span class="text-primary">News</span> From Our News
                Post</h1>
        </div>
        <div class="row g-5">
            @foreach ($berita as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="bg-light shadow rounded">
                        <div class="image-container" style="width: 100%; height: 450px;">
                            <img class="img-fluid mx-auto" src="{{ asset($item->thumbnail) }}" alt=""
                                style="object-fit: cover; width: 100%; height: 100%;">
                        </div>
                        <div class="p-4">
                            <div class="d-flex justify-content-between mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-user text-primary me-2"></i>
                                    <span>{{ $item->user->nama_lengkap }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="ms-3"><i
                                            class="far fa-calendar-alt text-primary me-2"></i>{{ App\Helpers\DateTimes($item->created_at, 'd M, Y') }}</span>
                                </div>
                            </div>
                            <h4 class="text-uppercase mb-3">{{ $item->judul }}</h4>
                            <a class="text-uppercase fw-bold"
                                href="{{ route('berita.slug', ['slug' => $item->slug]) }}">Read More <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
    <!-- Blog End -->
    <!-- About Start -->
    <div class="container-fluid py-6 px-5">
        <div class="row g-5">
            <div class="col-lg-7">
                <h1 class="display-5 text-uppercase mb-4">SEKILAS KABUPATEN <span class="text-primary">KAMPAR</span></h1>
                <p>Kabupaten Kampar adalah sebuah wilayah kabupaten yang berada di provinsi Riau, Indonesia. Di samping
                    julukan sebagai Bumi Sarimadu, Kampar juga dikenal dengan julukan Serambi Mekkah di provinsi Riau.</p>
                <p>Kabupaten ini memiliki luas 11.289,28 km² atau 12,26% dari luas provinsi Riau dan jumlah penduduk
                    berdasarkan data Kementerian Dalam Negeri akhir tahun 2023 berjumlah 860.379 jiwa. Ibu kota Kampar
                    berada di Bangkinang.</p>
                <h4>Batas Wilayah :</h4>
                <div class="row gx-5 py-2">
                    <div class="col-sm-12 mb-2">
                        <p class="fw-bold mb-2"><i class="fa fa-check text-primary me-3"></i>Utara : Kabupaten Rokan Hulu
                            dan Kabupaten Siak</p>
                        <p class="fw-bold mb-2"><i class="fa fa-check text-primary me-3"></i>Timur : Kota Pekanbaru,
                            Kabupaten Siak dan Kabupaten Pelalawan</p>
                        <p class="fw-bold mb-2"><i class="fa fa-check text-primary me-3"></i>Selatan : Kabupaten Kuantan
                            Singingi</p>
                        <p class="fw-bold mb-2"><i class="fa fa-check text-primary me-3"></i>Barat : Kabupaten Lima Puluh
                            Kota, Kabupaten Sijunjung (Sumatera Barat)</p>
                    </div>
                </div>
                <p class="mb-4">Kabupaten Kampar dengan luas lebih kurang 211.289,28 km² merupakan daerah yang terletak
                    antara 1°00’40” Lintang Utara sampai 0°27’00” Lintang Selatan dan 100°28’30” – 101°14’30” Bujur Timur.
                </p>
                <img src="img/signature.jpg" alt="">
            </div>
            <div class="col-lg-5 pb-5" style="min-height: 400px;">
                <div class="position-relative bg-dark-radial h-100 ms-5">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d107359.58977162665!2d101.11044086060504!3d0.26814883092341024!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d56d02db94ae05%3A0x340d7402572f2633!2sKec.%20Kampar%2C%20Kabupaten%20Kampar%2C%20Riau!5e0!3m2!1sid!2sid!4v1718681370959!5m2!1sid!2sid"
                        width="100%" height="615" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
    <script>
        var textWrapper = document.querySelector('.ml1 .letters');
        textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

        anime.timeline({
                loop: true
            })
            .add({
                targets: '.ml1 .letter',
                scale: [0.3, 1],
                opacity: [0, 1],
                translateZ: 0,
                easing: "easeOutExpo",
                duration: 600,
                delay: (el, i) => 70 * (i + 1)
            }).add({
                targets: '.ml1 .line',
                scaleX: [0, 1],
                opacity: [0.5, 1],
                easing: "easeOutExpo",
                duration: 700,
                offset: '-=875',
                delay: (el, i, l) => 80 * (l - i)
            }).add({
                targets: '.ml1',
                opacity: 0,
                duration: 1000,
                easing: "easeOutExpo",
                delay: 1000
            });
    </script>
@endsection
