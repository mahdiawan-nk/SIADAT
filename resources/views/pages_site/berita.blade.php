@extends('layout.site.app')

@section('pages')
    <!-- Page Header Start -->
    <div class="container-fluid page-header">
        <h1 class="display-3 text-uppercase text-white mb-3">berita</h1>
    </div>
    <!-- Page Header Start -->
    <div class="container-fluid py-6 px-5" style="min-height:80vh">

        <div class="row g-5">
            @foreach ($data as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="bg-light shadow-lg rounded">
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
        <div class="d-flex justify-content-center mt-5">
            {{ $data->links() }}
        </div>
    </div>
@endsection
