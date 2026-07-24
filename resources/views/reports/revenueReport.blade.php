{{-- Include the common header start section --}}
@include('includes/header_start')

{{-- DataTables CSS --}}
<link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>

{{-- Responsive DataTables CSS --}}
<link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>

{{-- Sweet Alert CSS --}}
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>

{{-- Form plugin CSS files --}}
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet"/>

{{-- Custom CSS --}}
<link href="{{ URL::asset('assets/css/custom_checkbox.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/css/jquery.notify.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/css/mdb.css')}}" rel="stylesheet" type="text/css"/>

{{-- CSRF token for AJAX requests --}}
<meta name="csrf-token" content="{{ csrf_token() }}"/>

{{-- Include the common header end section --}}
@include('includes/header_end')

{{-- ================= Page Title ================= --}}
<ul class="list-inline menu-left mb-0">

    {{-- Mobile menu button --}}
    <li class="list-inline-item">
        <button type="button" class="button-menu-mobile open-left waves-effect">
            <i class="ion-navicon"></i>
        </button>
    </li>

    {{-- Page heading --}}
    <li class="hide-phone list-inline-item app-search">
        <h3 class="page-title">Revenue Report</h3>
    </li>

</ul>

<div class="clearfix"></div>
</nav>
</div>

{{-- ================= Page Content ================= --}}
<div class="page-content-wrapper">
    <div class="container-fluid">

        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">

                    {{-- Revenue Report Search Form --}}
                    <form action="{{ route('revenueReport') }}" method="get">

                        <div class="row">

                            {{-- CSRF Protection --}}
                            {{ csrf_field() }}

                            {{-- Date Range Selection --}}
                            <div class="form-group col-md-5">

                                <label>Select Date Range:</label>

                                <div class="input-daterange input-group" id="date-range">

                                    {{-- Start Date --}}
                                    <input
                                        placeholder="From"
                                        type="text"
                                        autocomplete="off"
                                        class="form-control"
                                        value=""
                                        id="startDate"
                                        name="startDate"/>

                                    &nbsp;&nbsp;&nbsp;&nbsp;

                                    {{-- End Date --}}
                                    <input
                                        placeholder="To"
                                        type="text"
                                        autocomplete="off"
                                        class="form-control"
                                        value=""
                                        id="endDate"
                                        name="endDate"/>

                                </div>

                            </div>

                            {{-- Search Button --}}
                            <div class="form-group col-md-2" style="padding-top: 28px">
                                <button type="submit" class="btn btn-md btn-primary waves-effect">
                                    Search
                                </button>
                            </div>

                        </div>

                    </form>

                    {{-- ================= Revenue Report Table ================= --}}
                    <div class="table-rep-plugin">

                        <div class="table-responsive b-0" data-pattern="priority-columns">

                            {{-- DataTable with Export Options --}}
                            <table class="table table-striped table-bordered"
                                   id="datatable-buttons"
                                   cellspacing="0"
                                   width="100%">

                                {{-- Table Header --}}
                                <thead>
                                <tr>
                                    <th>APPOINTMENT ID</th>
                                    <th>CLIENT</th>
                                    <th>APPOINTMENT DATE</th>
                                    <th>APPOINTMENT TIME SLOT</th>
                                    <th>TOTAL AMOUNT (LKR)</th>
                                </tr>
                                </thead>

                                {{-- Table Body --}}
                                <tbody>

                                {{-- Check whether appointment data exists --}}
                                @if(isset($appointments))

                                    {{-- Check whether records are available --}}
                                    @if(count($appointments)!=0)

                                        {{-- Display each appointment --}}
                                        @foreach($appointments as $appointment)

                                            <tr>

                                                {{-- Appointment Number --}}
                                                <td>APT-{{$appointment->idappointment}}</td>

                                                {{-- Client Name --}}
                                                <td>
                                                    {{$appointment->User->first_name}}
                                                    {{$appointment->User->last_name}}
                                                </td>

                                                {{-- Appointment Date --}}
                                                <td>{{$appointment->date}}</td>

                                                {{-- Appointment Time Slot --}}
                                                <td>{{$appointment->TimeSlot->time_slot}}</td>

                                                {{-- Appointment Amount --}}
                                                <td>{{$appointment->amount}}</td>

                                            </tr>

                                        @endforeach

                                        {{-- Display Grand Total --}}
                                        <tr>

                                            <td><b>Total</b></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                            <td>
                                                <b>{{$total}}</b>
                                            </td>

                                        </tr>

                                    @else

                                        {{-- Display message if no records are found --}}
                                        <tr>
                                            <td colspan="5" style="text-align:center;font-weight:bold;">
                                                Sorry no results found.
                                            </td>
                                        </tr>

                                    @endif

                                @endif

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

{{-- End Page Content --}}
</div>

{{-- Include footer start --}}
@include('includes/footer_start')

{{-- ================= Plugin JavaScript Files ================= --}}

{{-- Form Plugins --}}
<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}"></script>

{{-- Form Plugin Initialization --}}
<script src="{{ URL::asset('assets/pages/form-advanced.js')}}"></script>

{{-- DataTables Scripts --}}
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>

{{-- DataTables Export Buttons --}}
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/vfs_fonts.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.html5.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.print.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.colVis.min.js')}}"></script>

{{-- Responsive DataTables --}}
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

{{-- Sweet Alert --}}
<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{ URL::asset('assets/pages/sweet-alert.init.js')}}"></script>

{{-- DataTable Initialization --}}
<script src="{{ URL::asset('assets/pages/datatables.init.js')}}"></script>

{{-- Form Validation --}}
<script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>

{{-- Notification Plugins --}}
<script src="{{ URL::asset('assets/js/bootstrap-notify.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery.notify.min.js')}}"></script>

<script>

    // Execute when page is fully loaded
    $(document).ready(function () {

        // Enable Parsley validation
        $('form').parsley();

        // Attach CSRF token to every AJAX request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    });

    // Prevent mouse wheel from changing number input values
    $(document).on("wheel", "input[type=number]", function () {
        $(this).blur();
    });

</script>

{{-- Include common footer --}}
@include('includes/footer_end')