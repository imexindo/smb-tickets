<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Register | Dashboard </title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies.">
    <meta name="keywords"
        content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard">
    <meta name="author" content="Phoenixcoded">

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
                            <h4 class="text-center f-w-500 mb-3">Sign up</h4>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control" placeholder="Name" name="name"
                                            required autofocus autocomplete="name" value="{{ old('name') }}">
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <input type="email" class="form-control" placeholder="Email Address" name="email"
                                    required autocomplete="email">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" class="form-control" placeholder="Password" id="password"
                                    name="password" required autocomplete="new-password">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" class="form-control" placeholder="Confirm Password"
                                    id="password-confirm" name="password_confirmation" required
                                    autocomplete="new-password">
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <div class="d-flex mt-1 justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input input-primary" type="checkbox" id="customCheckc1"
                                        checked="">
                                    <label class="form-check-label text-muted" for="customCheckc1">I agree to all the
                                        Terms
                                        & Condition</label>
                                </div>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">Sign up</button>
                            </div>
                        </form>
                        <div class="d-flex justify-content-between align-items-end mt-4">
                            <h6 class="f-w-500 mb-0">Don't have an Account?</h6>
                            <a href="/login" class="link-primary">Sign In</a>
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
