@extends('layout.site.app')

@section('pages')
    <!-- Page Header Start -->
    <div class="container-fluid page-header">
        <h1 class="display-3 text-uppercase text-white mb-3">Baca Berita</h1>
    </div>
    <!-- Page Header Start -->
    <!-- Blog Start -->
    <div class="container-fluid py-6 px-5">
        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Blog Detail Start -->
                <div class="mb-5">
                    <h1 class="text-uppercase mb-4">{{ $data->judul }}</h1>
                    <div class="text-break">
                        {!! $data->isi !!}
                    </div>
                </div>
                <!-- Blog Detail End -->
            </div>

            <!-- Sidebar Start -->
            <div class="col-lg-4">
                <!-- Recent Post Start -->
                <div class="mb-5">
                    <h3 class="text-uppercase mb-4">Recent Post</h3>
                    <div class="bg-light p-4">
                        @foreach ($recent_post as $post)
                            <div class="d-flex mb-3">
                                <div class="w-25">
                                    <img class="img-fluid" src="{{ asset($post->thumbnail) }}"
                                        style="width: 100px; height: 100px; object-fit: cover;" alt="">
                                </div>

                                <a href="{{ route('berita.slug', ['slug' => $post->slug]) }}"
                                    class="h6 d-flex align-items-center bg-white text-uppercase px-3 mb-0 w-75">{{ $post->judul }}
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>
                <!-- Recent Post End -->
            </div>
            <!-- Sidebar End -->
        </div>
    </div>
    <!-- Blog End -->
@endsection
