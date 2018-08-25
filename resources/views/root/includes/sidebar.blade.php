 <aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <div class="user-profile" style="background: url(/root/assets/images/background/user-info.jpg) no-repeat;">
            <!-- User profile image -->
            <div class="profile-img">
                <img src="{{ avatar_thumbnail_path(Auth::user()) }}" alt="user" />
            </div>
            <!-- User profile text-->
            <div class="profile-text"> <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{ Auth::user()->full_name }}</a>
                <div class="dropdown-menu animated flipInY"> <a href="{{ route('root.account.profile') }}" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                    <div class="dropdown-divider"></div> <a href="{{route ('root.account.password') }}" class="dropdown-item"><i class="ti-settings"></i> Change Password</a>
                    <div class="dropdown-divider"></div> <a href="{{ route('root.auth.signout') }}" class="dropdown-item"><i class="fa fa-power-off"></i> Signout</a> </div>
            </div>
        </div>
        <!-- End User profile text-->

        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <a href="{{ route('root.dashboard') }}" class="waves-effect waves-dark" aria-expanded="false">
                        <i class="mdi mdi-gauge"></i>
                        <span class="hide-menu">Dashboard </span>
                    </a>
                </li>

                <li>
                    <a href="#" class="has-arrow waves-effect waves-dark" aria-expanded="false">
                        <i class="mdi mdi-account-multiple"></i>
                        <span class="hide-menu">User Management</span>
                    </a>

                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="{{ route('root.admins.index') }}">Admins</a>
                        </li>

                        <li>
                            <a href="{{ route('root.users.index') }}">Users</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="has-arrow waves-effect waves-dark" aria-expanded="false">
                        <i class="mdi mdi-widgets"></i>
                        <span class="hide-menu">Election System</span>
                    </a>

                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="{{ route('root.elections.index') }}">Elections</a>
                        </li>
                        <li>
                            <a href="{{ route('root.positions.index') }}">Positions</a>
                        </li>
                        <li>
                            <a href="{{ route('root.candidates.index') }}">Candidates</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>