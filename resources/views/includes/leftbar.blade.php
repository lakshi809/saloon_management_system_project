<style>
    /* ==========================================
       Custom Sidebar Styles
       ========================================== */

    /* Set the sidebar background color */
    .side-menu {
        background-color: #f06292 !important;
    }

    /* Set the menu text color */
    #sidebar-menu > ul > li > a {
        color: #000000 !important;
    }

    /* Change menu appearance when hovered */
    #sidebar-menu > ul > li > a:hover {
        color: #000000 !important;
        background-color: rgba(0, 0, 0, 0.1) !important;
    }

    /* Set the sidebar icon color */
    #sidebar-menu > ul > li > a > i {
        color: #000000 !important;
    }

    /* Set the menu title color */
    .menu-title {
        color: #000000 !important;
    }
</style>

<!-- ==========================================
     Page Loader
     Displays a loading animation while the page loads.
     ========================================== -->
<div id="preloader">
    <div id="status">
        <div class="spinner"></div>
    </div>
</div>

<!-- Temporary message for testing -->
<div>
    LEFTBAR OK
</div>

<!-- ==========================================
     Main Wrapper
     ========================================== -->
<div id="wrapper">

    <!-- Left Sidebar -->
    <div class="left side-menu">

        <!-- ==========================================
             Application Logo
             ========================================== -->
        <div class="topbar-left">
            <div>
                <a href="{{ url('index') }}" class="logo">
                    <img src="{{ asset('assets/images/scissor.png') }}" width="100" alt="Logo">
                </a>
            </div>
        </div>

        <!-- Sidebar Navigation -->
        <div class="sidebar-inner slimscrollleft">
            <div id="sidebar-menu">

                <ul>

                    <!-- ==========================================
                         Main Menu
                         ========================================== -->
                    <li class="menu-title">Main</li>

                    <!-- Dashboard -->
                    <li>
                        <a href="{{ url('index') }}">
                            <i class="fa fa-area-chart"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- My Account -->
                    <li>
                        <a href="{{ url('myAccount') }}">
                            <i class="fa fa-user"></i>
                            <span>My Account</span>
                        </a>
                    </li>

                    <!-- ==========================================
                         Appointment Menu
                         ========================================== -->
                    <li class="menu-title">Appointments</li>

                    <!-- Make Appointment -->
                    <li>
                        <a href="{{ url('makeAppointment') }}">
                            <i class="fa fa-calendar-plus-o"></i>
                            <span>Make Appointment</span>
                        </a>
                    </li>

                    <!-- Appointment Log -->
                    <li>
                        <a href="{{ url('appointmentLog') }}">
                            <i class="fa fa-tasks"></i>
                            <span>Appointment Log</span>
                        </a>
                    </li>

                    <!-- ==========================================
                         Master Files (Admin & Staff Only)
                         ========================================== -->
                    @if(Auth::check() && in_array(Auth::user()->role, ['1','3']))

                        <li class="menu-title">Master Files</li>

                        <!-- Client Management -->
                        <li>
                            <a href="{{ url('clientManagement') }}">
                                <i class="fa fa-users"></i>
                                <span>Client Management</span>
                            </a>
                        </li>

                        <!-- User Management (Admin Only) -->
                        @if(Auth::user()->role == '1')
                            <li>
                                <a href="{{ url('userManagement') }}">
                                    <i class="fa fa-user-circle"></i>
                                    <span>User Management</span>
                                </a>
                            </li>
                        @endif

                    @endif

                    <!-- ==========================================
                         Finance Module (Admin & Staff Only)
                         ========================================== -->
                    @if(Auth::check() && in_array(Auth::user()->role, ['1','3']))

                        <li class="menu-title">Finance</li>

                        <!-- Payment Log -->
                        <li>
                            <a href="{{ url('paymentLog') }}">
                                <i class="fa fa-credit-card"></i>
                                <span>Payment Log</span>
                            </a>
                        </li>

                    @endif

                    <!-- ==========================================
                         System Module
                         ========================================== -->
                    @if(Auth::check() && in_array(Auth::user()->role, ['1','3','2']))

                        <li class="menu-title">System</li>

                        <!-- Category Management -->
                        <li>
                            <a href="{{ url('category') }}">
                                <i class="fa fa-book"></i>
                                <span>Category</span>
                            </a>
                        </li>

                    @endif

                    <!-- ==========================================
                         Reports Module
                         ========================================== -->
                    @if(Auth::check() && in_array(Auth::user()->role, ['1','3']))

                        <li class="menu-title">Reports</li>

                        <!-- Revenue Report (Admin Only) -->
                        @if(Auth::user()->role == '1')
                            <li>
                                <a href="{{ url('revenueReport') }}">
                                    <i class="fa fa-file-text-o"></i>
                                    <span>Revenue Report</span>
                                </a>
                            </li>
                        @endif

                        <!-- Client Report (Admin & Staff) -->
                        @if(in_array(Auth::user()->role, ['1','3']))
                            <li>
                                <a href="{{ url('clientReport') }}">
                                    <i class="fa fa-file-text-o"></i>
                                    <span>Client Report</span>
                                </a>
                            </li>
                        @endif

                    @endif

                    <!-- ==========================================
                         Other Features
                         ========================================== -->
                    <li class="menu-title">Others</li>

                    <!-- Feedback -->
                    <li>
                        <a href="{{ url('feedback') }}">
                            <i class="fa fa-comments"></i>
                            <span>Feedback</span>
                        </a>
                    </li>

                </ul>

            </div>
        </div>

    </div>

</div>