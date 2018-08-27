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
        <link href="/root/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="/root/material/css/style.css" rel="stylesheet">
        <!-- You can change the theme colors from here -->
        <link href="/root/material/css/colors/blue.css" id="theme" rel="stylesheet">

        <link href="/root/app/css/app.css" id="theme" rel="stylesheet">

        <style>
            html, body {
                height: 100%;
            }

            body {
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #80CBC4;
            }

            .main-content {
                margin: 0;
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
        </section>

        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="/root/assets/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="/root/assets/plugins/popper/popper.min.js"></script>
        <script src="/root/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="/root/material/js/jquery.slimscroll.js"></script>
        <!--Wave Effects -->
        <script src="/root/material/js/waves.js"></script>
        <!--Menu sidebar -->
        <!--stickey kit -->
        <script src="/root/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <script src="/root/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
        <!--Custom JavaScript -->
        <script src="/root/material/js/custom.min.js"></script>

        <!-- ============================================================== -->
        <!-- This page plugins -->
        <!-- ============================================================== -->
        <!--c3 JavaScript -->
        <script src="/root/assets/plugins/d3/d3.min.js"></script>
        <script src="/root/assets/plugins/c3-master/c3.min.js"></script>

        <!-- ============================================================== -->
        <!-- Style switcher -->
        <!-- ============================================================== -->
        <script src="/root/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

        <script src="/root/app/js/app.js"></script>

        @yield('scripts')
    </body>
</html>