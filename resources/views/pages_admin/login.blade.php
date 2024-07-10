<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LAK</title>



    <link rel="shortcut icon" href="{{ asset('admin') }}/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('admin') }}/compiled/css/app.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/compiled/css/app-dark.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/compiled/css/auth.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/base.min.css" />
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-3 d-none d-lg-block"></div>
            <div class="col-lg-4 col-12 my-auto mx-auto">
                <di class="card mb-0">
                    <div class="card-body">
                        <div id="auth-left p-0">
                            <div class="d-flex flex-column justify-content-center">
                                <img src="{{ asset('static-file/logo-kampar.png') }}" alt="logo-kampar"
                                    class="w-25 mx-auto">
                                <p class="auth-subtitle mb-5 text-center">Lembaga Adat Kampar</p>
                            </div>
                            <form method="POST" id="auth-user">
                                @csrf
                                <div class="form-group position-relative has-icon-left mb-4">
                                    <input type="text" class="form-control" name="username" placeholder="Username">
                                    <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left mb-4">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                    <div class="form-control-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                </div>
                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-1">Log
                                    in</button>
                            </form>
                        </div>
                    </div>
                </di>

            </div>
            <div class="col-lg-3 d-none d-lg-block">
            </div>
        </div>

    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function() {
        $('form#auth-user').submit(function(e) {
            e.preventDefault();
            e.stopImmediatePropagation()

            $.ajax({
                type: "POST",
                url: "{{ route('api.auth.user') }}",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(response) {
                    let timerInterval;
                    Swal.fire({
                        title: response.message,
                        html: "sedang Redirect ke halaman panel-admin dalam <b></b> milliseconds.",
                        timer: 2500,
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                            const timer = Swal.getPopup().querySelector("b");
                            timerInterval = setInterval(() => {
                                timer.textContent =
                                    `${Swal.getTimerLeft()}`;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {

                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location.href = "{{ route('panel-admin.home') }}"
                        }
                    });

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal Login",
                        text: jqXHR.responseJSON.message,
                    });
                }
            });

        });
    });
</script>

</html>
