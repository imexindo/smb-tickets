<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login | SMB Ticket</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('majestic/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('majestic/vendors/base/vendor.bundle.base.css') }}">

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('majestic/css/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}" />
    <style>
        body {
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 550px;
            height: 550px;
            background: url("{{ asset('assets/logo.png') }}") no-repeat top left;
            background-size: contain;
            filter: blur(5px);
            opacity: 1;
            z-index: 0;
        }
    </style>



</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="{{ asset('assets/logo.png') }}" alt="logo"
                                    style="height: 55px; width: 50px;">
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <form class="pt-3" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg" id="floatingInput"
                                        name="email" value="{{ old('email') }}" placeholder="Email" required
                                        autofocus>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="floatingInput1"
                                        name="password" placeholder="Password" required>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div class="mt-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                        SIGN IN
                                    </button>
                                </div>

                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <a href="{{ route('password.request') }}" class="auth-link text-black">Forgot
                                        password?</a>
                                </div>

                                <div class="text-center mt-4 font-weight-light">
                                    Don't have an account?
                                    <a href="{{ route('register') }}" class="text-primary">Create an account</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('majestic/vendors/base/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="{{ asset('majestic/js/off-canvas.js') }}"></script>
    <script src="{{ asset('majestic/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('majestic/js/template.js') }}"></script>
    <!-- endinject -->
</body>

</html>
