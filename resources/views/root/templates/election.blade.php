<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>{{ config('app.name') }}</title>

        <!-- Favicon icon -->
        <link rel="shortcut icon" type="image/x-icon" sizes="16x16" href="/assets/images/favicon2.png">

        <!-- #stylesheet: Bootstrap -->
        <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- #stylesheet: jQuery Toast -->
        <link href="/assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">

        <!-- #stylesheet: Magnific Popup -->
        <link href="/assets/plugins/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">

        <!-- #stylesheet: Custom Global -->
        <link href="/app/css/style.css">

        <!-- #stylesheet: Custom Root -->
        <link href="/root/app/css/style.css">

        @yield('styles')

        <!-- #stylesheet: Theme -->
        <link href="/material/css/dark.css" rel="stylesheet">
        <link href="/material/css/colors/green-dark.css" id="theme" rel="stylesheet">
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
            @include('root.includes._election.sidebar')

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

        <script src="/assets/plugins/jquery/jquery.min.js"></script>
        <script src="/assets/plugins/popper/popper.min.js"></script>
        <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="/material/js/jquery.slimscroll.js"></script>
        <script src="/material/js/waves.js"></script>
        <script src="/material/js/sidebarmenu.js"></script>
        <script src="/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <script src="/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="/material/js/custom.min.js"></script>

        <script src="/assets/plugins/d3/d3.min.js"></script>
        <script src="/assets/plugins/c3-master/c3.min.js"></script>
        <script src="/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
        <script src="/assets/plugins/toast-master/js/jquery.toast.js"></script>
        <script src="/assets/plugins/toast-master/js/jquery.toast.js"></script>

        <!-- #script: Magnific Popup -->
        <script src="/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
        <script src="/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>

        <!-- #script: Custom Global -->
        <script src="/app/js/script.js"></script>

        <!-- #script: Custom Root -->
        <script src="/root/app/js/script.js"></script>

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

            // to male the ui fit in darker theme.
            $('input').addClass('text-white');

            $('select, select > option:enabled').addClass('text-white');
        </script>

        {!! Notify::notification() !!}

        @yield('scripts')
    </body>
</html>