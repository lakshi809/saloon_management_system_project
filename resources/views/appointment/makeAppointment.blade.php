
@include('includes/header_start')

<link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet"/>
<link href="{{ URL::asset('assets/css/custom_checkbox.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/css/jquery.notify.css')}}" rel="stylesheet" type="text/css">

<meta name="csrf-token" content="{{ csrf_token() }}"/>

@include('includes/header_end')

<ul class="list-inline menu-left mb-0">
    <li class="list-inline-item">
        <button type="button" class="button-menu-mobile open-left waves-effect">
            <i class="ion-navicon"></i>
        </button>
    </li>
    <li class="hide-phone list-inline-item app-search">
        <h3 class="page-title">{{ $title }}</h3>
    </li>
</ul>

<div class="clearfix"></div>
</nav>
</div>

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-8"></div>
                        <div class="col-lg-4">
                            <button type="button" class="btn btn-primary float-right"
                                    data-toggle="modal" data-target="#addAppointmentModal">
                                Add Appointment
                            </button>
                        </div>
                    </div>

                    <br/>

                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped table-bordered"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Appointment ID</th>
                                    <th>Client ID</th>
                                    <th>Client Name</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Time Slot</th>
                                </tr>
                                </thead>
                                <tbody>
@if(isset($appointments) && count($appointments) > 0)
    @foreach($appointments as $apnt)
        <tr>
            <td>APT-{{ $apnt->idappointment }}</td>
            <td>REG-{{ $apnt->master_user_idmaster_user }}</td>
            <td>
                @if($apnt->User)
                    {{ $apnt->User->first_name }} {{ $apnt->User->last_name }}
                @else
                    N/A
                @endif
            </td>
            <td>
                @if($apnt->Category)
                    {{ $apnt->Category->category_name }}
                @endif
            </td>
            <td>{{ $apnt->date }}</td>
            <td>
                @if($apnt->TimeSlot)
                    {{ $apnt->TimeSlot->time_slot }}
                @else
                    N/A
                @endif
            </td>
        </tr>
    @endforeach
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

</div>

<!--Add Appointment Modal-->
<div class="modal fade" id="addAppointmentModal" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-primary float-right"
                                onclick="saveAppointment()">
                            Save Appointment
                        </button>
                    </div>
                </div>

                <div class="row">
                    <!-- Client -->
<div class="col-md-4 sm-12">
    <div class="form-group">
        <label>Client</label>

        @if($userRole == 2)

            <input type="text"
                   class="form-control"
                   value="{{ $userLogged->first_name }} {{ $userLogged->last_name }}"
                   readonly>

            <input type="hidden"
                   name="client"
                   id="client"
                   value="{{ $userLogged->idmaster_user }}">

        @else

            <select name="client" id="client" class="form-control">
                <option value="">Select Client</option>

                @foreach($clients as $client)
                    <option value="{{ $client->id }}">
                        {{ $client->name }}
                    </option>
                @endforeach

            </select>

        @endif

        <small class="text-danger" id="clientError"></small>
    </div>
</div>

                 
    
   

                    <!-- Category -->
                    <div class="col-md-4 sm-12">
                        <div class="form-group">
                            <label>Category</label>
                            <select onchange="showAmount(this.value)" class="form-control"
                                    name="category" id="category" required>
                                <option disabled value="" selected>Select Category</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <small class="text-danger" id="categoryError"></small>
                        </div>
                    </div>

                    <!-- Stylist -->
                    <div class="col-md-4 sm-12">
                        <div class="form-group">
                            <label>Stylist</label>
                            <select class="form-control"
                                    name="stylist" id="stylist" required>
                                <option disabled value="" selected>Select Stylist</option>
                                @if(isset($stylists))
                                    @foreach($stylists as $stylist)
                                        <option value="{{ $stylist->id}}" {{ (count($stylists) == 1) ? 'selected' : '' }}>
                                            {{ $stylist->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <small class="text-danger" id="StylistError"></small>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" name="amount" id="amount"
                                   class="form-control" value="" />
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" class="form-control"
                                   id="date" name="date"
                                   min="{{ date('Y-m-d') }}"
                                   max="{{ $maxDays->format('Y-m-d') }}"/>
                            <small class="text-danger" id="dateError"></small>
                        </div>
                    </div>

                    <!-- Time Slot -->
                    <div class="col-md-4 sm-12">
                        <div class="form-group">
                            <label>Time Slot</label>
                            <div id="timeSlotBOx">
                                <select class="form-control" name="timeSlot" id="timeSlot" required>
                                    <option disabled value="" selected>Select Time Slot</option>
                                </select>
                            </div>
                            <small class="text-danger" id="timeSlotError"></small>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end modal-body -->
        </div> <!-- end modal-content -->
    </div> <!-- end modal-dialog -->
</div> <!-- end modal -->
<br>

@include('includes/footer_start')

<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/pages/form-advanced.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/vfs_fonts.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.html5.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.print.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{ URL::asset('assets/pages/sweet-alert.init.js')}}"></script>
<script src="{{ URL::asset('assets/pages/datatables.init.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-notify.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery.notify.min.js')}}"></script>

<script type="text/javascript">
   
$(document).ready(function () {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
// Initialize Select2 for Client Selection only if it's a real <select> (admin/staff view)
if ($('#client').is('select')) {
    $('#client').select2({
        dropdownParent: $('#addAppointmentModal'),
        width: '100%'
    });
}

// Initialize Select2 for Stylist Selection
$('#stylist').select2({
    dropdownParent: $('#addAppointmentModal'),
    width: '100%'
});

   

    // Select2 fires its own event - bind both to be safe
    $('#stylist').on('change select2:select', function () {
        getTimeSlot();
    });

    // Date: bind change AND input, delegated so nothing can detach it
    $(document).on('change input', '#date', function () {
        getTimeSlot();
    });

    // ▼▼▼ ADD IT HERE - loads slots when modal opens if values already set ▼▼▼
    $('#addAppointmentModal').on('shown.bs.modal', function () {
        getTimeSlot();
    });
    // ▲▲▲

});
    function saveAppointment() {
        var client = $('#client').length ? $('#client').val() : '';
        var category = $('#category').val();
        var date     = $('#date').val();
        var timeSlot = $('#timeSlot').val();
        var stylist  = $('#stylist').val();

        $('#categoryError').html('');
        $('#clientError').html('');
        $('#dateError').html('');
        $('#timeSlotError').html('');
        $('#StylistError').html('');

        $.post("{{ route('saveAppointment') }}", {
    _token:   $('meta[name="csrf-token"]').attr('content'),
    category: category,
    date:     date,
    timeSlot: timeSlot,
    stylist:  stylist,
    client:   client
}, function (data) {

            if (data.errors) {
                if (data.errors.category)
                    $('#categoryError').html(data.errors.category[0]);
                if (data.errors.client)
                    $('#clientError').html(data.errors.client[0]);
                if (data.errors.date)
                    $('#dateError').html(data.errors.date[0]);
                if (data.errors.timeSlot)
                    $('#timeSlotError').html(data.errors.timeSlot[0]);
                if (data.errors.stylist)
                    $('#StylistError').html(data.errors.stylist[0]);
            }

            if (data.success) {
                notify({
                    type: "success",
                    title: 'Appointment Saved',
                    autoHide: true,
                    delay: 2500,
                    position: {x: "right", y: "top"},
                    icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                    message: data.success,
                });
                setTimeout(function () {
                    $('#addAppointmentModal').modal('hide');
                }, 200);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        });
    }

    function showAmount(categoryId) {
        $.ajax({
            url: "{{ route('showAmount') }}",
            type: "POST",
           data: {
    _token:     $('meta[name="csrf-token"]').attr('content'),
    categoryId: categoryId
},
            success: function (data) {
                $('#amount').val(data.amount);
            }
        });
    }

    function getTimeSlot() {
        
        var date    = $('#date').val();
        var stylist = $('#stylist').val();

        if (date && stylist) {
            $.ajax({
                url: "{{ route('getTimeSlot') }}",
                type: "POST",
               data: {
    _token:  $('meta[name="csrf-token"]').attr('content'),
    date:    date,
    stylist: stylist
},
                success: function (data) {
                    $('#timeSlotBOx').html(data);
                }
            });
        }
    }

    $('.modal').on('hidden.bs.modal', function () {
        $('#categoryError').html('');
        $('#clientError').html('');
        $('#dateError').html('');
        $('#timeSlotError').html('');
        $('#StylistError').html('');
        $('input').val('');
    });
</script>

@include('includes/footer_end')