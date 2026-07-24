@include('includes/header_start')

<!-- Morris Chart CSS -->
<link rel="stylesheet" href="assets/plugins/morris/morris.css">

<!-- CSRF Token for AJAX Requests -->
<meta name="csrf-token" content="{{ csrf_token() }}" />

@include('includes/header_end')

<!-- Top Navigation Bar -->
<nav>
    <ul class="list-inline menu-left mb-0">

        <!-- Sidebar Toggle Button -->
        <li class="list-inline-item">
            <button type="button" class="button-menu-mobile open-left waves-effect">
                <i class="ion-navicon"></i>
            </button>
        </li>

        <!-- Page Title -->
        <li class="hide-phone list-inline-item app-search">
            <h3 class="page-title">{{$title}}</h3>
        </li>

    </ul>

    <div class="clearfix"></div>
</nav>

</div>

<!-- Main Page Content -->
<div class="page-content-wrapper">
    <div class="container-fluid">

        <!-- Dashboard Summary Cards -->
        <div class="row">

            <!-- Pending Appointments -->
            <div class="col-md-6">
                <div class="card mb-3" style="background-color: #fce4ec; color: #ad1457;">
                    <div class="card-header">
                        <h4>Pending</h4>
                    </div>

                    <div class="card-body">
                        <h4 class="card-title">{{$pendingApp}}</h4>
                        <p class="card-text">Awaiting Confirmation.</p>
                    </div>
                </div>
            </div>

            <!-- Cancelled Appointments -->
            <div class="col-md-6">
                <div class="card mb-3" style="background-color: #fce4ec; color: #ad1457;">
                    <div class="card-header">
                        <h4>Canceled</h4>
                    </div>

                    <div class="card-body">
                        <h4 class="card-title">{{$canceledApp}}</h4>
                        <p class="card-text">Total cancelled today.</p>
                    </div>
                </div>
            </div>

            <!-- Completed Appointments -->
            <div class="col-md-6">
                <div class="card mb-3" style="background-color: #fce4ec; color: #ad1457;">
                    <div class="card-header">
                        <h4>Completed</h4>
                    </div>

                    <div class="card-body">
                        <h4 class="card-title">{{$completedApp}}</h4>
                        <p class="card-text">Successfully served.</p>
                    </div>
                </div>
            </div>

            <!-- Display New Clients Card Only for Admin/Staff -->
            @if(Auth::check() && Auth::user()->role != 4)
            <div class="col-md-6">
                <div class="card mb-3" style="background-color: #fce4ec; color: #ad1457;">
                    <div class="card-header">
                        <h4>New Clients</h4>
                    </div>

                    <div class="card-body">
                        <h4 class="card-title">{{$totCustomers}}</h4>
                        <p class="card-text">Daily registrations.</p>
                    </div>
                </div>
            </div>
            @endif

        </div>

        <!-- Income Chart Section -->
        <div class="row mt-4">

            <div class="col-12">

                <div class="card m-b-30">

                    <div class="card-body">

                        <!-- Morris Bar Chart -->
                        <div id="incomeChart" style="height: 300px;"></div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

</div>

@include('includes/footer_start')

<!-- Morris Chart Library -->
<script src="assets/plugins/morris/morris.min.js"></script>

<!-- Raphael Library (Required for Morris Charts) -->
<script src="assets/plugins/raphael/raphael-min.js"></script>

<!-- Dashboard JavaScript -->
<script src="assets/pages/dashborad.js"></script>

<script type="text/javascript">

    // Execute when page is fully loaded
    $(document).ready(function() {

        // Configure CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Retrieve income chart data from server
        $.post('incomeChart', {}, function(chartData) {

            var data = [];

            // Convert response data into Morris Chart format
            for (let i = 0; i < chartData.length; i++) {

                data.push({
                    y: chartData[i].jobcard_date,
                    a: chartData[i].jobcard_total
                });

            }

            // Generate Morris Bar Chart
            Morris.Bar({

                element: 'incomeChart',

                data: data,

                xkey: 'y',

                ykeys: ['a'],

                labels: ['Income'],

                // Set different colors for chart bars
                barColors: function(row, series, type) {

                    var colors = ['#ad1457', '#e91e63', '#f06292', '#ec407a'];

                    return colors[row.x % colors.length];

                },

                hideHover: 'auto',

                gridLineColor: '#eef0f2',

                resize: true

            });

        });

    });

</script>

@include('includes/footer_end')