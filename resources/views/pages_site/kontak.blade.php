@extends('layout.site.app')

@section('pages')
    <!-- Page Header Start -->
    <div class="container-fluid page-header">
        <h1 class="display-3 text-uppercase text-white mb-3">Kontak</h1>
    </div>
    <!-- Page Header Start -->
    <div class="container-fluid py-6 px-5">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <h1 class="display-5 text-uppercase mb-4">Please <span class="text-primary">Feel Free</span> To Contact Us</h1>
        </div>
        <div class="row gx-1">
            <div class="col-lg-6 mb-5 mb-lg-0" style="height: 600px;">
                <iframe class="w-100 h-100"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d107359.58977162665!2d101.11044086060504!3d0.26814883092341024!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d56d02db94ae05%3A0x340d7402572f2633!2sKec.%20Kampar%2C%20Kabupaten%20Kampar%2C%20Riau!5e0!3m2!1sid!2sid!4v1718681370959!5m2!1sid!2sid"
                    frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
            <div class="col-lg-6" style="height: 600px;">
                <div class="card bg-light p-5" style="height: 600px;">
                    <div class="row g-3">
                        <div class="col-12 col-sm-12 border-0 bg-white text-center p-2">
                            <p>Catatan</p>
                            <p>{{ $data ? $data->catatan :''}}</p>
                        </div>
                        <div class="col-12 col-sm-12 fs-3 bg-white ps-4 py-2">
                            <i class="fa-regular fa-envelope me-2"></i><a href="mailto:someone@example.com">{{ $data ? $data->surel :''}}</a>
                        </div>
                        <div class="col-12 col-sm-12 fs-3 bg-white ps-4 py-2">
                            <i class="fa-solid fa-phone me-2"></i><a href="">{{ $data ? $data->telephone : ''}}</a>
                        </div>
                        <div class="col-12 col-sm-12 fs-3 bg-white ps-4 py-2">
                            <i class="fa-solid fa-location-dot me-2"></i><a href="">{{ $data ? $data->alamat :''}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
