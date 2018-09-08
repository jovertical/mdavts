 <aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
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
                        <span class="hide-menu">System Users</span>
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
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>