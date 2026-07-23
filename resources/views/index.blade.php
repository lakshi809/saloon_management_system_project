@include('includes/header_start')

<!--Morris Chart CSS -->
<link rel="stylesheet" href="assets/plugins/morris/morris.css">
<meta name="csrf-token" content="{{ csrf_token() }}" />

@include('includes/header_end')

<nav>
    <ul class="list-inline menu-left mb-0">
        <li class="list-inline-item">
            <button type="button" class="button-menu-mobile open-left waves-effect">
                <i class="ion-navicon"></i>
            </button>
        </li>
        <li class="hide-phone list-inline-item app-search">
            <h3 class="page-title">{{$title}}</h3>
        </li>
    </ul>
    <div class="clearfix"></div>
</nav>

</div>

<div class="page-content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3" style="background-color: #fce4ec; color: #ad1457;">
                    <div class="card-header"><h4>Pending</h4></div>
                    <div class="card-body">
                        <h4 class="card-title">{{$pendingApp}}</h4>
                        <p class="card-text">Awaiting Confirmation.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-3" style="background-color: #fce4ec; color: #ad1457;">
                    <div class="card-header"><h4>Canceled</h4></div>
                    <div class="card-body">
                        <h4 class="card-title">{{$canceledApp}}</h4>
                        <p class="card-text">Totaled cancelled today.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-3" style="background-color: #fce4ec; color: #ad1457;">
                    <div class="card-header"><h4>Completed</h4></div>
                    <div class="card-body">
                        <h4 class="card-title">{{$completedApp}}</h4>
                        <p class="card-text">Successfully served.</p>
                    </div>
                </div>
            </div>

            @if(Auth::check() && Auth::user()->role != 4)
            <div class="col-md-6">
                <div class="card mb-3" style="background-color: #fce4ec; color: #ad1457;">
                    <div class="card-header"><h4>New Clients</h4></div>
                    <div class="card-body">
                        <h4 class="card-title">{{$totCustomers}}</h4>
                        <p class="card-text">Daily registrations.</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div id="incomeChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</div>

@include('includes/footer_start')

<script src="assets/plugins/morris/morris.min.js"></script>
<script src="assets/plugins/raphael/raphael-min.js"></script>
<script src="assets/pages/dashborad.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $.post('incomeChart', {}, function(chartData) {
            var data = [];
            for (let i = 0; i < chartData.length; i++) {
                data.push({
                    y: chartData[i].jobcard_date,
                    a: chartData[i].jobcard_total
                });
            }
            Morris.Bar({
                element: 'incomeChart',
                data: data,
                xkey: 'y',
                ykeys: ['a'],
                labels: ['Income'],
                barColors: function (row, series, type) {
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