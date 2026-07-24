            <!-- ==========================================
                 Main Content Area
                 ========================================== -->
            <div class="content-page">

                <!-- Page Content -->
                <div class="content">

                    <!-- ==========================================
                         Top Navigation Bar
                         ========================================== -->
                    <div class="topbar">

                        <nav class="navbar-custom">

                            <!-- Search Bar (Currently Disabled) -->
                            {{--
                            <div class="search-wrap" id="search-wrap">
                                <div class="search-bar">
                                    <input class="search-input" type="search" placeholder="Search" />
                                    <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                                        <i class="mdi mdi-close-circle"></i>
                                    </a>
                                </div>
                            </div>
                            --}}

                            <!-- Top Navigation Menu -->
                            <ul class="list-inline float-right mb-0">

                                <!-- Search Icon (Currently Disabled) -->
                                {{--
                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link waves-effect toggle-search" href="#" data-target="#search-wrap">
                                        <i class="mdi mdi-magnify noti-icon"></i>
                                    </a>
                                </li>
                                --}}

                                <!-- Fullscreen Button -->
                                <li class="list-inline-item dropdown notification-list hidden-xs-down">
                                    <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                                        <i class="mdi mdi-fullscreen noti-icon"></i>
                                    </a>
                                </li>

                                <!-- Notifications (Currently Disabled) -->
                                {{--
                                Notification dropdown code is commented out because
                                the notification feature is not currently in use.
                                --}}

                                <!-- ==========================================
                                     User Profile Menu
                                     ========================================== -->
                                <li class="list-inline-item dropdown notification-list">

                                    <!-- User Profile Icon -->
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user"
                                       data-toggle="dropdown"
                                       href="#"
                                       role="button"
                                       aria-haspopup="false"
                                       aria-expanded="false">

                                        <img src="{{ URL::asset('assets/images/myaccountprofile.png')}}"
                                             height="60"
                                             width="40"
                                             class="img-fluid mb-6" />

                                    </a>

                                    <!-- User Dropdown Menu -->
                                    <div class="dropdown-menu dropdown-menu-right profile-dropdown">

                                        <!-- Other profile options are currently disabled -->

                                        <!-- Logout Button -->
                                        <a class="dropdown-item"
                                           href="javascript:void(0);"
                                           onclick="confirmLogout()"
                                           style="background-color: #000000 !important; color: #ffffff !important;">

                                            <i class="dripicons-exit"
                                               style="color: #ffffff !important;"></i>
                                            Logout
                                        </a>

                                        <!-- Logout Confirmation Script -->
                                        <script type="text/javascript">

                                            // Display a confirmation message before logging out
                                            function confirmLogout() {

                                                if (confirm('Do you want to logout?')) {

                                                    // Redirect the user to the logout route
                                                    window.location.href = "{{ route('logout') }}";
                                                }
                                            }

                                        </script>

                                    </div>
                                </li>

                            </ul>