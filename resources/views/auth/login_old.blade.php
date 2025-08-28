<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>SMB Claims | Login</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon"> <!-- [Font] Family -->
    <link rel="stylesheet" href="{{ asset('ablepro/src/assets/fonts/inter/inter.css') }}" id="main-font-link" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('ablepro/src/assets/fonts/tabler-icons.min.css') }}">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('ablepro/src/assets/fonts/feather.css') }}">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('ablepro/src/assets/fonts/fontawesome.css') }}">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('ablepro/src/assets/fonts/material.css') }}">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('ablepro/dist/assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('ablepro/dist/assets/css/style-preset.css') }}">

    <style>
        body {
            background-image: url('/assets/bg.jpg') !important;
            background-size: cover;
        }
    </style>
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
    data-pc-theme_contrast="" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="#"><img src="{{ asset('assets/smb_claims.png') }}" alt="img"
                                    style="width: 200px; margin-bottom: 20px;"></a>
                        </div>
                        <h4 class="text-center f-w-500 mb-3">Sign In</h4>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="email" name="email" class="form-control" id="floatingInput"
                                    placeholder="Email Address">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                            </div>
                            <div class="form-group mb-3">
                                <input type="password" name="password" class="form-control" id="floatingInput1" placeholder="Password">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="d-flex mt-1 justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input input-primary" type="checkbox" id="customCheckc1"
                                        checked="">
                                    <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
                                </div>
                                <h6 class="text-secondary f-w-400 mb-0">Forgot Password?</h6>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>

                        <div class="d-flex justify-content-between align-items-end mt-4">
                            <h6 class="f-w-500 mb-0">Don't have an Account?</h6>
                            <a href="/register" class="link-primary">Create Account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <!-- Required Js -->
    <script src="{{ asset('ablepro/dist/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('ablepro/dist/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('ablepro/dist/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('ablepro/dist/assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('ablepro/dist/assets/js/script.js') }}"></script>
    <script src="{{ asset('ablepro/dist/assets/js/theme.js') }}"></script>
    <script src="{{ asset('ablepro/dist/assets/js/plugins/feather.min.js') }}"></script>

    <script>
        change_box_container('false');
    </script>


    <script>
        layout_caption_change('true');
    </script>




    <script>
        layout_rtl_change('false');
    </script>


    <script>
        preset_change("preset-1");
    </script>

</body>
<!-- [Body] end -->

</html>
