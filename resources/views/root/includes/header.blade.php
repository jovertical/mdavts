<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <!-- Logo icon -->
                <b>
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img src="/root/assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                    <!-- Light Logo icon -->
                    <img src="/root/assets/images/logo-light-icon1.png" style= "width: 60px;" alt="homepage" class="light-logo" />
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span>
                    <!-- dark Logo text -->
                    <img src="/root/assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                    <!-- Light Logo text -->
                    <img src="/root/assets/images/logo-light-text1.png" style= "width: 150px" class="light-logo" alt="homepage" />
                </span>
            </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto mt-md-0">
                <!-- This is  -->
                <li class="nav-item">
                    <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)">
                        <i class="mdi mdi-menu"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)">
                        <i class="ti-menu"></i>
                    </a>
                </li>
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
                <!-- Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ avatar_thumbnail_path(Auth::user()) }}" alt="img" class="profile-pic" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right scale-up">
                        <ul class="dropdown-user">
                            <li>
                                <div class="dw-user-box text-center">
                                    <div class="u-img">
                                        <img src="{{ avatar_thumbnail_path(Auth::user()) }}" alt="img">
                                    </div>

                                    <div class="my-2"></div>

                                    <div class="u-text">
                                        <h4>{{ Auth::user()->full_name }}</h4>
                                        <p class="text-muted">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{ route('root.account.profile') }}">
                                    <i class="ti-user"></i> My Profile</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{route ('root.account.password') }}">
                                    <i class="ti-settings"></i> Change Password</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{ route('root.auth.signout') }}">
                                    <i class="fa fa-power-off"></i> Signout
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->