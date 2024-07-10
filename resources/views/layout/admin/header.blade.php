<header>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-lg-0">
                    <li class="nav-item dropdown me-1">
                        <a class="nav-link active dropdown-toggle text-gray-600" href="#"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bi bi-envelope bi-sub fs-4'></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li>
                                <h6 class="dropdown-header">Mail</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">No new mail</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link active dropdown-toggle text-gray-600" href="#"
                            data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <i class='bi bi-bell bi-sub fs-4'></i>
                            <span class="badge badge-notification bg-danger">7</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end notification-dropdown"
                            aria-labelledby="dropdownMenuButton">
                            <li class="dropdown-header">
                                <h6>Notifications</h6>
                            </li>
                            <li class="dropdown-item notification-item">
                                <a class="d-flex align-items-center" href="#">
                                    <div class="notification-icon bg-primary">
                                        <i class="bi bi-cart-check"></i>
                                    </div>
                                    <div class="notification-text ms-4">
                                        <p class="notification-title font-bold">Successfully check out</p>
                                        <p class="notification-subtitle font-thin text-sm">Order ID #256
                                        </p>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-item notification-item">
                                <a class="d-flex align-items-center" href="#">
                                    <div class="notification-icon bg-success">
                                        <i class="bi bi-file-earmark-check"></i>
                                    </div>
                                    <div class="notification-text ms-4">
                                        <p class="notification-title font-bold">Homework submitted</p>
                                        <p class="notification-subtitle font-thin text-sm">Algebra math
                                            homework</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <p class="text-center py-2 mb-0"><a href="#">See all
                                        notification</a></p>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600">{{ \App\Helpers\getUserInfos()->nama_lengkap }}</h6>
                                <p class="mb-0 text-sm text-gray-600">
                                    {{ auth()->user()->role == 1 ? 'Administrator' : 'Operator Kenegerian' }}</p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="{{ asset('admin') }}/compiled/jpg/1.jpg">
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                        style="min-width: 11rem;">
                        <li>
                            <h6 class="dropdown-header">Hello, {{ \App\Helpers\getUserInfos()->nama_lengkap }}!</h6>
                        </li>
                        <li><a class="dropdown-item log-out" href="#" data-bs-toggle="modal"
                                data-bs-target="#user-profile"><i class="icon-mid bi bi-key-fill me-2"></i>
                                Ubah Password</a></li>
                        <li><a class="dropdown-item log-out" href="#" id="log-out"><i
                                    class="icon-mid bi bi-box-arrow-left me-2"></i>
                                Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="modal fade" id="user-profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content form-horizontal" id="form-update-passwords" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">My Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nama_lengkap">Nama Lengkap</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="nama_lengkap" class="form-control" name="nama_lengkap"
                                placeholder="{{ auth()->user()->nama_lengkap }}"
                                value="{{ auth()->user()->nama_lengkap }}">
                        </div>
                        <div class="col-md-4">
                            <label for="username">Username</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="username" class="form-control" name="username"
                                placeholder="{{ auth()->user()->username }}" value="{{ auth()->user()->username }}">
                        </div>
                        <div class="col-md-4">
                            <label for="email">E-mail</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" id="email" class="form-control" name="email"
                                placeholder="First Name" value="{{ auth()->user()->email }}">
                        </div>
                        <div class="col-12 col-md-8 offset-md-4 form-group">
                            <div class="form-check">
                                <div class="checkbox">
                                    <input type="checkbox" id="checkbox1" class="form-check-input">
                                    <label for="checkbox1">Update Password</label>
                                </div>
                            </div>
                            <div class="input-group form-password" hidden>
                                <input type="passwords" class="form-control" placeholder="password"
                                    aria-label="password">
                                <span class="input-group-text pt-0 pb-0" id="password" style="cursor: pointer"><i
                                        class="fa-regular fa-eye"></i></span>
                            </div>
                            <div id="passwordError" class="invalid-feedback" style="display: none;">
                                Password must be at least 8 characters long.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="subtmit" class="btn btn-primary btn-submit">Perbarui</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('checkbox1');
        const btnSubmit = document.querySelector('.btn-submit');
        const formPassword = document.querySelector('.form-password');
        const showPassword = document.querySelector('#password');
        const passwordField = formPassword.querySelector('input');
        const showPasswordIcon = formPassword.querySelector('.fa-eye');
        const hidePasswordIcon = formPassword.querySelector('.fa-eye-slash');
        const passwordError = document.getElementById('passwordError');
        passwordField.value = '';
        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
                btnSubmit.setAttribute('disabled', true);
                formPassword.removeAttribute('hidden');
            } else {
                btnSubmit.removeAttribute('disabled');
                passwordField.value = '';
                passwordError.style.display = 'none';
                formPassword.setAttribute('hidden', true);
            }
        });

        showPassword.addEventListener('click', function() {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                showPasswordIcon.classList.add('fa-eye-slash');
                showPasswordIcon.classList.remove('fa-eye');
            } else {
                passwordField.type = 'password';
                showPasswordIcon.classList.add('fa-eye');
                showPasswordIcon.classList.remove('fa-eye-slash');
            }
        });

        passwordField.addEventListener('input', function() {
            const password = passwordField.value;
            if (password.trim() === '') {
                // Jika password kosong atau hanya terdiri dari spasi
                passwordError.style.display = 'none';
            } else if (isValidPassword(password)) {
                // Jika password valid
                btnSubmit.removeAttribute('disabled');
                passwordError.style.display = 'none';
            } else {
                // Jika password tidak valid
                passwordError.style.display = 'block';
            }
        });

        function isValidPassword(password) {
            // Password must be at least 8 characters and include letters, numbers, and special characters
            const regex = /^.{8,}$/;
            return regex.test(password);
        }

    });
</script>
