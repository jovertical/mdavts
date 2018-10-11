 <aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                <!-- Users -->
                <li>
                    <a href="#" class="has-arrow waves-effect waves-dark" aria-expanded="false">
                        <i class="mdi mdi-account-multiple"></i>
                        <span class="hide-menu">Users</span>
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
                <!--/. Users -->

                <!-- School -->
                <li>
                    <a href="#" class="has-arrow waves-effect waves-dark" aria-expanded="false">
                        <i class="mdi mdi-school"></i>
                        <span class="hide-menu">School</span>
                    </a>

                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="{{ route('root.grades.index') }}">Grades</a>
                        </li>

                        <li>
                            <a href="{{ route('root.sections.index') }}">Sections</a>
                        </li>
                    </ul>
                </li>
                <!--/. School -->

                <!-- Election System -->
                <li>
                    <a href="#" class="has-arrow waves-effect waves-dark" aria-expanded="false">
                        <i class="mdi mdi-widgets"></i>
                        <span class="hide-menu">Election System</span>
                    </a>

                    <ul aria-expanded="false" class="collapse">
                        
                        <li>
                            <a href="{{ route('root.partylists.index') }}">Party Lists</a>
                        </li>
                        <li>
                            <a href="{{ route('root.positions.index') }}">Positions</a>
                        </li>
                        <li>
                            <a href="{{ route('root.elections.index') }}">Elections</a>
                        </li>
                    </ul>
                </li>
                <!--/. Election System -->

                <!-- System -->
                <li>
                    <a href="#" class="has-arrow waves-effect waves-dark" aria-expanded="false">
                        <i class="mdi mdi-chip"></i>
                        <span class="hide-menu">System</span>
                    </a>

                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="{{ route('root.system.settings') }}">Settings</a>
                        </li>
                    </ul>
                </li>
                <!--/. System -->
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>