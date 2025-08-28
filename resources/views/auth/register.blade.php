<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register | SMB Ticket</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('majestic/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('majestic/vendors/base/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
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
                        <div class="auth-form-light text-left pt-3 pb-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="{{ asset('assets/logo.png') }}" alt="logo"
                                    style="height: 55px; width: 50px;">
                            </div>
                            <h4>New here?</h4>
                            <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                            <form class="pt-3" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" name="name" placeholder="Name"
                                        required autofocus autocomplete="name" value="{{ old('name') }}">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg" name="email" placeholder="Email">
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" name="password" id="password"
                                        placeholder="Password" required autocomplete="new-password">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="password-confirm"
                                        name="password_confirmation" placeholder="Confirm Password" required
                                        autocomplete="new-password">
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN UP</button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Already have an account? <a href="/login" class="text-primary">Login</a>
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
