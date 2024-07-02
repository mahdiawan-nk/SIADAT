@extends('layout.site.app')

@section('pages')
    <!-- Page Header Start -->
    <div class="container-fluid page-header">
        <h1 class="display-3 text-uppercase text-white mb-3">profil</h1>
        <div class="d-inline-flex text-white">
            <h3 class="text-uppercase m-0"><a href="">{{ $title }}</a></h3>
        </div>
    </div>
    <!-- Page Header Start -->
    <div class="container py-6 px-5" style="min-height:80vh">
        <div class="row g-5">
            <div class="col-lg-12">
                {!! preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $data ? $data->content : '') !!}
                {{-- {{ $data ? $data->content : '' }} --}}
            </div>
        </div>
    </div>
@endsection
