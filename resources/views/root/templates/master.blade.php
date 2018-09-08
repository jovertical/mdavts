<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>{{ config('app.name') }}</title>

        <!-- Favicon icon -->
        <link rel="shortcut icon" type="image/x-icon" sizes="16x16" href="/root/assets/images/favicon2.png">

        <!-- Bootstrap Core CSS -->
        <link href="/root/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="/root/material/css/style.css" rel="stylesheet">

        <!-- You can change the theme colors from here -->
        <link href="/root/material/css/colors/green-dark.css" id="theme" rel="stylesheet">

        <!-- toast CSS -->
        <link href="/root/assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">

        <link href="/root/assets/plugins/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">

        <link href="/root/app/css/app.css">

        @yield('styles')
    </head>

    <body class="fix-header fix-sidebar card-no-border">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
        </div>

        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            @include('root.includes.header')
            @include('root.includes.sidebar')

            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            @yield('modals')
        </div>

        <script src="/root/assets/plugins/jquery/jquery.min.js"></script>
        <script src="/root/assets/plugins/popper/popper.min.js"></script>
        <script src="/root/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="/root/material/js/jquery.slimscroll.js"></script>
        <script src="/root/material/js/waves.js"></script>
        <script src="/root/material/js/sidebarmenu.js"></script>
        <script src="/root/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <script src="/root/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="/root/material/js/custom.min.js"></script>

        <script src="/root/assets/plugins/d3/d3.min.js"></script>
        <script src="/root/assets/plugins/c3-master/c3.min.js"></script>
        <script src="/root/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
        <script src="/root/assets/plugins/toast-master/js/jquery.toast.js"></script>
        <script src="/root/assets/plugins/toast-master/js/jquery.toast.js"></script>

        <script src="/root/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
        <script src="/root/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>

        <script src="/root/app/js/app.js"></script>

        <script>
            $('.fullscreen-toggler').on('click', function (event) {
                var el = $(this);
                if (! el.data('toggled')) {
                    el.data('toggled', true);

                    openFullscreen(document.documentElement);
                } else {
                    el.data('toggled', false);

                    closeFullscreen();
                }
            });

            $('input').addClass('text-white');

            $('select option:enabled').addClass('text-white');

            $('select').on('change', function(event) {
                $(this).addClass('text-white')
            });
        </script>

        {!! Notify::notification() !!}

        @yield('scripts')
    </body>
</html>