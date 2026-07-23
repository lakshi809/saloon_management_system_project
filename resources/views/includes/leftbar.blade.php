<style>
    
    .side-menu {
        background-color:  #f06292 !important;
    }
    
    #sidebar-menu > ul > li > a {
        color: #000000 !important;
    }
    
    #sidebar-menu > ul > li > a:hover {
        color: #000000 !important; 
        background-color: rgba(0, 0, 0, 0.1) !important;
    }
    #sidebar-menu > ul > li > a > i {
        color: #000000 !important;
    }
    .menu-title {
        color: #000000 !important;
    }
</style>

<!-- Loader -->
<div id="preloader">
    <div id="status">
        <div class="spinner"></div>
    </div>
</div>

<div>
    LEFTBAR OK
</div>

<!-- Begin page -->
<div id="wrapper">

    <div class="left side-menu">

        <!-- LOGO -->
        <div class="topbar-left">
            <div>
                <a href="{{ url('index') }}" class="logo">
                    <img src="{{ asset('assets/images/scissor.png') }}" width="100" alt="Logo">
                </a>
            </div>
        </div>

        <div class="sidebar-inner slimscrollleft">
            <div id="sidebar-menu">

                <ul>

                    <!-- MAIN -->
                    <li class="menu-title">Main</li>

                    <li>
                        <a href="{{ url('index') }}">
                            <i class="fa fa-area-chart"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('myAccount') }}">
                            <i class="fa fa-user"></i>
                            <span>My Account</span>
                        </a>
                    </li>

                    <!-- APPOINTMENTS -->
                    <li class="menu-title">Appointments</li>

                    <!-- FIXED: removed role condition (so it always shows) -->
                    <li>
                        <a href="{{ url('makeAppointment') }}">
                            <i class="fa fa-calendar-plus-o"></i>
                            <span>Make Appointment</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('appointmentLog') }}">
                            <i class="fa fa-tasks"></i>
                            <span>Appointment Log</span>
                        </a>
                    </li>

                    <!-- MASTER FILES -->
                    @if(Auth::check() && in_array(Auth::user()->role, ['1','3']))
                    
                        <li class="menu-title">Master Files</li>

                        <li>
                            <a href="{{ url('clientManagement') }}">
                                <i class="fa fa-users"></i>
                                <span>Client Management</span>
                            </a>
                        </li>

                        @if(Auth::user()->role == '1')
                            <li>
                                <a href="{{ url('userManagement') }}">
                                    <i class="fa fa-user-circle"></i>
                                    <span>User Management</span>
                                </a>
                            </li>
                        @endif

                    @endif

                    <!-- FINANCE -->
                    @if(Auth::check() && in_array(Auth::user()->role, ['1','3']))
                    
                        <li class="menu-title">Finance</li>

                        <li>
                            <a href="{{ url('paymentLog') }}">
                                <i class="fa fa-credit-card"></i>
                                <span>Payment Log</span>
                            </a>
                        </li>

                    @endif

                    <!-- SYSTEM -->
                    @if(Auth::check() && in_array(Auth::user()->role, ['1','3','2']))
                    
                        <li class="menu-title">System</li>

                        <li>
                            <a href="{{ url('category') }}">
                                <i class="fa fa-book"></i>
                                <span>Category</span>
                            </a>
                        </li>

                    @endif

                   <!-- REPORTS -->

            <!-- REPORTS -->

 @if(Auth::check() && in_array(Auth::user()->role, ['1','3']))


    <li class="menu-title">Reports</li>
    @if(Auth::user()->role == '1')

    <!-- Revenue Report - Admin Only -->
    

        <li>
            <a href="{{ url('revenueReport') }}">
                <i class="fa fa-file-text-o"></i>
                <span>Revenue Report</span>
            </a>
        </li>

    @endif


    <!-- Client Report - Admin and Staff -->
    @if(in_array(Auth::user()->role, ['1','3']))

        <li>
            <a href="{{ url('clientReport') }}">
                <i class="fa fa-file-text-o"></i>
                <span>Client Report</span>
            </a>
        </li>

    @endif

@endif



                 <!-- OTHERS -->
                    <li class="menu-title">Others</li>

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