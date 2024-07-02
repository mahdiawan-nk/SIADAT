<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Lembaga Adat Kampar</title>



    <link rel="shortcut icon" href="{{ asset('admin') }}/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('admin') }}/compiled/css/app.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/compiled/css/app-dark.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/compiled/css/auth.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/base.min.css"/> --}}
    <link rel="stylesheet" href="{{ asset('admin') }}/extensions/choices.js/public/assets/styles/choices.css">
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-3"></div>
            <div class="col-lg-4 col-12 my-auto mx-auto">
                <div class="card mb-0">
                    <div class="card-body">
                        <div id="auth-left p-0" class="mt-0">
                            <div class="d-flex flex-column justify-content-center">
                                <img src="{{ asset('static-file/logo-kampar.png') }}" alt="logo-kampar" class="mx-auto"
                                    style="width:10% !important">
                                <p class="auth-subtitle mb-5 text-center mt-2">Lembaga Adat Kampar</p>
                            </div>
                            <form id="form-registrasi" class="needs-validation" novalidate>
                                @csrf
                                <div class="form-group position-relative ">
                                    <label for="nama_lengkap">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap"
                                        placeholder="Nama Lengkap" required>
                                </div>
                                <div class="form-group position-relative ">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control " name="username" id="username"
                                        placeholder="Username" required>
                                </div>
                                <div class="form-group position-relative ">
                                    <label for="email">email</label>
                                    <input type="email" class="form-control " name="email" id="email"
                                        placeholder="Email" required>
                                </div>
                                <div class="form-group position-relative">
                                    <label for="id_kenegerian">Kenegerian</label>
                                    <select name="id_kenegerian" id="id_kenegerian"
                                        class="choices form-select form-control" aria-placeholder="Kenegerian" required>
                                        <option value="">Kenegerian</option>
                                    </select>
                                </div>
                                <div class="form-group position-relative">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Password" required>
                                </div>
                                <div class="form-group position-relative  ">
                                    <label for="password_confirmation">Password Confirm</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        placeholder="Confirm Password" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg">Sign
                                    Up</button>
                            </form>
                            <div class="text-center mt-2 text-lg fs-4">
                                <p class='text-gray-600'>Already have an account? <a
                                        href="{{ route('panel-admin.login') }}" class="font-bold text-primary">Log
                                        in</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-3"></div>
        </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="{{ asset('admin') }}/extensions/choices.js/public/assets/scripts/choices.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var choices = new Choices('#id_kenegerian', {
            shouldSort: false,
            placeholder: true,
            placeholderValue: 'Select an option',
        });
        var listKenegerian = () => {
            $.ajax({
                type: "GET",
                url: '{{ route('data.kenegerian') }}',
                dataType: "JSON",
                success: function(response) {
                    var items = response.data.map(function(item) {
                        return {
                            value: item.id,
                            label: item.nama_kenegerian
                        };


                    });

                    // Set the choices with the fetched data
                    choices.setChoices(items, 'value', 'label', true);
                }
            });
        }

        listKenegerian()

        $('form#form-registrasi').submit(function(e) {
            e.preventDefault();
            e.stopImmediatePropagation()
            var form = $(this);
            $.ajax({
                type: "POST",
                url: "{{ route('registrasi.save') }}",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(response) {
                    console.log(response)
                    // let timerInterval;
                    Swal.fire({
                        icon: "success",
                        title: "Registrasi berhasil",
                        text: "Silahkan Login Menggunakan Username dan password anda daftarkan",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    }).then((result) => {

                        if (result.isConfirmed) {
                            window.location.href = "{{ route('panel-admin.home') }}"
                        }
                    });

                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr.responseJSON)
                    if (xhr.responseJSON) {
                        var errors = xhr.responseJSON.errors;
                        form.find('.form-control.is-invalid').removeClass('is-invalid');
                        form.find('.form-control.is-invalid').siblings('.invalid-tooltip')
                            .remove();
                        $.each(errors, function(key, value) {
                            var inputField = form.find('[name="' + key + '"]');
                            inputField.addClass('is-invalid');
                            inputField.parent().append(
                                '<div class="invalid-tooltip">' +
                                value + '</div>');
                        });

                    } else {

                    }
                }
            });

        });
    </script>
</body>

</html>
