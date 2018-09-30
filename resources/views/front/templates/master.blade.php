<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name') }}</title>

        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon2.png">

        <!-- #stylesheet: Bootstrap -->
        <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- #stylesheet: Theme -->
        <link href="/material/css/material.css" rel="stylesheet">
        <link href="/material/css/colors/blue.css" id="theme" rel="stylesheet">

        <!-- #stylesheet: Magnific Popup -->
        <link href="/assets/plugins/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">

        <!-- #stylesheet: Custom Global -->
        <link href="/app/css/style.css" id="theme" rel="stylesheet">

        <style>
            html, body {
                height: 100%;
            }

            body {
                display: flex;
                justify-content: center;
                align-items: center;
                background-image: linear-gradient(to bottom right, #FF9800, #FFE082);
                background-size: 100%;
                background-repeat: repeat;
            }

            .main-content {
                margin: 0;
                padding: 0;
            }

            @media only screen and (min-width: 992px) {
                .wrapper-large {
                    width: 600px;
                }

                .wrapper-small {
                    width: 300px;
                }
            }

            @media only screen and (min-width: 1200px) {
                .wrapper-large {
                    width: 800px;
                }

                .wrapper-small {
                    width: 400px;
                }
            }
        </style>

        @yield('styles')
    </head>

    <body>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
        </div>

        <section>
            <div class="main-content">
                @yield('content')
            </div>

            @yield('modals')
        </section>

        <script src="/assets/plugins/jquery/jquery.min.js"></script>
        <script src="/assets/plugins/popper/popper.min.js"></script>
        <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="/material/js/jquery.slimscroll.js"></script>
        <script src="/material/js/waves.js"></script>
        <script src="/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <script src="/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="/material/js/custom.min.js"></script>
        <script src="/assets/plugins/d3/d3.min.js"></script>
        <script src="/assets/plugins/c3-master/c3.min.js"></script>
        <script src="/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

        <!-- #script: Magnific Popup -->
        <script src="/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
        <script src="/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>

        <!-- #script: Custom Global -->
        <script src="/app/js/script.js"></script>

        @yield('scripts')
    </body>
</html>