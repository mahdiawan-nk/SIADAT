<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Kelembagaan Adat Kampar</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('static-file/logo-kampar.png') }}" type="image/x-icon">

    <!-- Google Web Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.gstatic.com"> --}}
    <link href="{{ asset('site/css/font-google.css') }}" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="{{ asset('site/lib/font-awesome') }}/css/all.min.css" rel="stylesheet">
    {{-- <link href="{{ asset('site') }}/css/bootstrap-icons.css" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('site') }}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="{{ asset('site') }}/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="{{ asset('site') }}/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('site') }}/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('site') }}/css/style.css" rel="stylesheet">
    <style>
        .page-header {
            height: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(4, 15, 40, .7), rgba(4, 15, 40, .7)), url('{{ asset('static-file/header-bg.jpg') }}') center center no-repeat;
            background-size: cover;
        }
    </style>
    @yield('css')
</head>

<body>
    <!-- Navbar Start -->
    @include('layout.site.navigation')
    <!-- Navbar End -->


    @yield('pages')

    <!-- Footer Start -->
    @include('layout.site.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="{{ asset('site/js') }}/jquery-3.4.1.min.js"></script>
    <script src="{{ asset('site/js') }}/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('site') }}/lib/easing/easing.min.js"></script>
    <script src="{{ asset('site') }}/lib/waypoints/waypoints.min.js"></script>
    <script src="{{ asset('site') }}/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="{{ asset('site') }}/lib/tempusdominus/js/moment.min.js"></script>
    <script src="{{ asset('site') }}/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="{{ asset('site') }}/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="{{ asset('site') }}/lib/isotope/isotope.pkgd.min.js"></script>
    <script src="{{ asset('site') }}/lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('site') }}/js/main.js"></script>
    @yield('script')
</body>

</html>
