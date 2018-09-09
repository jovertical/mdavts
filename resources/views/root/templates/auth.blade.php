<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>{{ config('app.name') }}</title>

        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="/root/assets/images/favicon2.png">

        <!-- Bootstrap Core CSS -->
        <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="/material/css/dark.css" rel="stylesheet">

        <!-- You can change the theme colors from here -->
        <link href="/material/css/colors/green-dark.css" id="theme" rel="stylesheet">

        @yield('styles')
    </head>

    <body>

        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
        </div>

        <section id="wrapper">
            <div class="login-register" style="background-image:url(/assets/images/background/MDA-Login.jpg);">

                @yield ('content')
            </div>
        </section>

        <!-- All Jquery -->
        <!-- ============================================================== -->
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

        <script>
            // to male the ui fit in darker theme.
            $('input').addClass('text-white');

            // to male the ui fit in darker theme.
            $('input').addClass('text-white');

            $('select, select > option:enabled').addClass('text-white');
        </script>

        @yield('scripts')
    </body>
</html>