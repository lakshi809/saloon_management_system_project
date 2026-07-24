{{-- Include common header section --}}
@include('includes/header_start')

{{-- ================= CSS Files ================= --}}

{{-- DataTables CSS --}}
<link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>

{{-- Responsive DataTables CSS --}}
<link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>

{{-- SweetAlert CSS --}}
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>

{{-- Form Plugin CSS --}}
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet"/>

{{-- Custom CSS --}}
<link href="{{ URL::asset('assets/css/custom_checkbox.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/css/jquery.notify.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/css/mdb.css')}}" rel="stylesheet" type="text/css"/>

{{-- CSRF Token for AJAX requests --}}
<meta name="csrf-token" content="{{ csrf_token() }}"/>

{{-- Include header end --}}
@include('includes/header_end')

{{-- ================= Page Header ================= --}}
<ul class="list-inline menu-left mb-0">

    {{-- Mobile menu button --}}
    <li class="list-inline-item">
        <button type="button" class="button-menu-mobile open-left waves-effect">
            <i class="ion-navicon"></i>
        </button>
    </li>

    {{-- Page title --}}
    <li class="hide-phone list-inline-item app-search">
        <h3 class="page-title">{{ $title }}</h3>
    </li>

</ul>

<div class="clearfix"></div>
</nav>

</div>

{{-- ================= Main Content ================= --}}
<div class="page-content-wrapper">
    <div class="container-fluid">

        <div class="col-lg-12">
            <div class="card m-b-20">

                <div class="card-body">

                    {{-- ================= Payment Log Table ================= --}}
                    <div class="table-rep-plugin">

                        <div class="table-responsive b-0" data-pattern="priority-columns">

                            {{-- DataTable --}}
                            <table id="datatable"
                                   class="table table-striped table-bordered"
                                   cellspacing="0"
                                   width="100%">

                                {{-- Table Header --}}
                                <thead>
                                <tr>
                                    <th>PAYMENT ID</th>
                                    <th>APPOINTMENT ID</th>
                                    <th>AMOUNT</th>
                                    <th>DATE & TIME</th>
                                </tr>
                                </thead>

                                {{-- Table Body --}}
                                <tbody>

                                {{-- Display all payment records --}}
                                @foreach($payments as $payment)

                                    <tr>

                                        {{-- Payment ID --}}
                                        <td>{{ $payment->idpayment }}</td>

                                        {{-- Appointment ID --}}
                                        <td>APT-{{ $payment->appointment_idappointment }}</td>

                                        {{-- Payment Amount --}}
                                        <td>{{ $payment->amount }}</td>

                                        {{-- Payment Date and Time --}}
                                        <td>{{ $payment->created_at }}</td>

                                    </tr>

                                @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>
                    {{-- End Payment Table --}}

                </div>
            </div>
        </div>

    </div>
</div>

{{-- Include footer start --}}
@include('includes/footer_start')

{{-- ================= JavaScript Files ================= --}}

{{-- Form Plugins --}}
<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}"></script>

{{-- Initialize Form Plugins --}}
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

{{-- SweetAlert --}}
<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{ URL::asset('assets/pages/sweet-alert.init.js')}}"></script>

{{-- Initialize DataTables --}}
<script src="{{ URL::asset('assets/pages/datatables.init.js')}}"></script>

{{-- Form Validation --}}
<script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>

{{-- Notification Plugins --}}
<script src="{{ URL::asset('assets/js/bootstrap-notify.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery.notify.min.js')}}"></script>

<script>

    // Execute after page loads
    $(document).ready(function () {

        // Enable Parsley form validation
        $('form').parsley();

        // Add CSRF token to all AJAX requests
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

    // Activate or deactivate a record using AJAX
    function adMethod(dataID, tableName) {

        $.post('activateDeactivate', {
            id: dataID,
            table: tableName
        }, function (data) {

            // Callback after status update
        });

    }

</script>

{{-- Include common footer --}}
@include('includes/footer_end')