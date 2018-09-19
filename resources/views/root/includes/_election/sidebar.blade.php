<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- Back -->
                <li>
                    <a href="{{ route('root.elections.index') }}" class="waves-effect waves-dark" aria-expanded="false">
                        <i class="mdi mdi-arrow-left-bold"></i>
                        <span class="hide-menu">Back</span>
                    </a>
                </li>
                <!--/. Back -->

                <li class="nav-devider"></li>

                <li class="nav-small-cap">
                    <span>
                        {{ str_limit(strtoupper($election->name), 15) }}
                    </span>

                    <span class="label label-{{ $election->status_class }} float-right">
                        {{ ucfirst($election->status) }}
                    </span>
                </li>

                <!-- Dashboard -->
                <li>
                    <a href="{{ route('root.elections.dashboard', $election) }}" class="waves-effect waves-dark" aria-expanded="false">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <!--/. Dashboard -->

                <!-- Positions -->
                <li>
                    <a href="{{ route('root.elections.positions', $election) }}" class="waves-effect waves-dark" aria-expanded="false">
                        <i class="mdi mdi-tag-multiple"></i>
                        <span class="hide-menu">Positions</span>
                    </a>
                </li>
                <!--/. Positions -->

                <!-- Candidates -->
                <li>
                    <a href="{{ route('root.elections.candidates.index', $election) }}" class="waves-effect waves-dark" aria-expanded="false">
                        <i class="mdi mdi-account-multiple"></i>
                        <span class="hide-menu">Candidates</span>
                    </a>
                </li>
                <!--/. Candidates -->

                <!-- Control Numbers -->
                <li>
                    <a href="{{ route('root.elections.control-numbers.index', $election) }}" class="waves-effect waves-dark" aria-expanded="false">
                        <i class="mdi mdi-account-key"></i>
                        <span class="hide-menu">Control Numbers</span>
                    </a>
                </li>
                <!--/. Control Numbers -->

                <!-- Tally -->
                <li>
                    <a href="{{ route('root.elections.tally.index', $election) }}" class="waves-effect waves-dark" aria-expanded="false">
                        <i class="mdi mdi-archive"></i>
                        <span class="hide-menu">Tally</span>
                    </a>
                </li>
                <!--/. Tally -->
            </ul>
        </nav>
    </div>
    <!-- End Sidebar scroll-->
</aside>