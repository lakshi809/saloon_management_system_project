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

<!-- Page title -->
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
<!-- Top Bar End -->

<!-- ==================
     PAGE CONTENT START
     ================== -->

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">

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
                                    <th>Status</th>
                                    <th>Options</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(isset($appointments))
                                    @if(count($appointments)>0)
                                        @foreach($appointments as $apnt)
                                            <tr>
                                                <td>APT-{{$apnt->idappointment}}</td>
                                                <td>REG-{{$apnt->User->idmaster_user ?? ''}}</td>
                                                <td>{{$apnt->User->first_name ?? ''}} {{$apnt->User->last_name ?? ''}}</td>
                                                <td>{{$apnt->Category->category_name ?? 'N/A'}}</td>
                                                <td>{{$apnt->date}}</td>
                                                <td>{{$apnt->TimeSlot->time_slot ?? 'N/A'}}</td>

                                                @if($apnt->status==0)
                                                    <td>
                                                        <span class="badge badge-pill badge-warning">Pending</span>
                                                    </td>
                                                @endif

                                                @if($apnt->status==1)
                                                    <td>
                                                        <span class="badge badge-pill badge-success">Completed</span>
                                                    </td>
                                                @endif

                                                @if($apnt->status==2)
                                                    <td>
                                                        <span class="badge badge-pill badge-danger">Canceled</span>
                                                    </td>
                                                @endif

                                                <td>
                                                    @if($apnt->status==0)

                                                        {{-- Role mapping: 1 = Admin, 2 = Client, 3 = Staff --}}
                                                        @if (\Illuminate\Support\Facades\Auth::user()->role == 1 ||
                                                            \Illuminate\Support\Facades\Auth::user()->role == 3)
                                                            <p>
                                                                <button type="button"
                                                                        class="btn btn-primary btn-sm"
                                                                        onclick="setPaymentAmount({{$apnt->idappointment}},{{$apnt->amount}},'{{$apnt->User->first_name ?? ''}} {{$apnt->User->last_name ?? ''}}')"
                                                                        data-toggle="modal"
                                                                        data-target="#paymentModal">
                                                                    Payment
                                                                </button>
                                                            </p>
                                                        @endif

                                                        @if (\Illuminate\Support\Facades\Auth::user()->role == 1 ||
                                                            \Illuminate\Support\Facades\Auth::user()->role == 3 ||
                                                            \Illuminate\Support\Facades\Auth::user()->role == 2)
                                                            <p>
                                                                <button type="button"
                                                                        class="btn btn-danger btn-sm"
                                                                        onclick="cancelAppointment({{$apnt->idappointment}})">
                                                                    Cancel
                                                                </button>
                                                            </p>
                                                        @endif

                                                    @endif

                                                    {{-- FEEDBACK / REVIEW: only for completed appointments --}}
                                                    @if($apnt->status==1)
                                                        @if (\Illuminate\Support\Facades\Auth::user()->role == 2 &&
                                                            $apnt->master_user_idmaster_user == \Illuminate\Support\Facades\Auth::user()->idmaster_user)

                                                            @if($apnt->Feedback)
                                                                <p>
                                                                    <span class="badge badge-pill badge-info">Reviewed</span>
                                                                </p>
                                                            @else
                                                                <p>
                                                                    <button type="button"
                                                                            class="btn btn-warning btn-sm"
                                                                            onclick="setReviewAppointment({{$apnt->idappointment}})"
                                                                            data-toggle="modal"
                                                                            data-target="#reviewModal">
                                                                        Review
                                                                    </button>
                                                                </p>
                                                            @endif

                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->

</div>


<!--Payment Modal Start-->
<div class="modal fade" id="paymentModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Make Payment</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" class="form-control" name="appointmentId"
                       id="appointmentId" />

                <div class="form-group">
                    <label>Client Name</label>
                    <input type="text" class="form-control" name="nameAppointment"
                           id="nameAppointment" placeholder="Name" readonly/>
                    <span class="text-danger" id="nameError"></span>
                </div>

                <div class="form-group">
                    <label>Appointment Cost</label>
                    <input type="text" class="form-control" name="amount_app" readonly
                           id="amount_app" required placeholder="0.00" />
                    <span class="text-danger" id="categoryError"></span>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-primary float-right"
                            onclick="savePayment()">
                        Save Payment
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>
<!--Payment Modal End-->


<!--Review Modal Start-->
<div class="modal fade" id="reviewModal" tabindex="-1"
     role="dialog"
     aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Leave a Review</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="reviewAppointmentId"/>

                <div class="form-group text-center">
                    <label class="d-block">Rating</label>
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5"/><label for="star5">&#9733;</label>
                        <input type="radio" id="star4" name="rating" value="4"/><label for="star4">&#9733;</label>
                        <input type="radio" id="star3" name="rating" value="3"/><label for="star3">&#9733;</label>
                        <input type="radio" id="star2" name="rating" value="2"/><label for="star2">&#9733;</label>
                        <input type="radio" id="star1" name="rating" value="1"/><label for="star1">&#9733;</label>
                    </div>
                    <span class="text-danger" id="ratingError"></span>
                </div>

                <div class="form-group">
                    <label>Comment</label>
                    <textarea class="form-control" id="reviewComment" rows="3"
                              placeholder="Share your experience..."></textarea>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-primary float-right"
                            onclick="submitReview()">
                        Submit Review
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>
<!--Review Modal End-->

<style>
    .star-rating {
        direction: rtl;
        display: inline-flex;
        font-size: 32px;
        unicode-bidi: bidi-override;
    }
    .star-rating input {
        display: none;
    }
    .star-rating label {
        color: #ccc;
        cursor: pointer;
        padding: 0 4px;
    }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ffb400;
    }
</style>


@include('includes/footer_start')

<!-- Plugins js -->
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
        $('form').parsley();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });

    function setPaymentAmount(appointmentId, amount, clientName) {
        $("#nameAppointment").val(clientName);
        $("#appointmentId").val(appointmentId);
        $("#amount_app").val(amount);
    }

    function savePayment() {
        var appointmentID = $("#appointmentId").val();
        var amount = $("#amount_app").val();

        $.post('{{ route("savePayment") }}', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            appointment_idappointment: appointmentID,
            amount: amount
        }, function (data) {
            if (data.success) {
                try {
                    notify({
                        type: "success",
                        title: 'Payment Saved',
                        autoHide: true,
                        delay: 2500,
                        position: { x: "right", y: "top" },
                        message: data.success,
                    });
                } catch (e) { console.log(e); }

                setTimeout(function () {
                    $('#paymentModal').modal('hide');
                }, 500);

                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        }).fail(function (xhr) {
            console.log('savePayment failed:', xhr.status, xhr.responseText.substring(0, 300));
            alert('Payment failed - check console');
        });
    }

    function cancelAppointment(aptId) {
        swal({
            title: 'Are you sure?',
            text: 'Want to cancel the appointment?',
            dangerMode: true,
            buttons: true,
            showCancelButton: true,
            confirmButtonText: 'YES',
            confirmButtonColor: '#CC0000',
            cancelButtonColor: '#00695c',
            cancelButtonText: 'NO',
            confirmButtonClass: 'btn btn-md btn-danger waves-effect',
            cancelButtonClass: 'btn btn-md btn-primary waves-effect',
            buttonsStyling: true
        }).then(function () {
            $.post('{{ route("cancelAppointment") }}', {
                _token: $('meta[name="csrf-token"]').attr('content'),
                aptId: aptId
            }, function (data) {
                if (data.success != null) {
                    try {
                        notify({
                            type: "success",
                            title: 'APPOINTMENT CANCELED',
                            autoHide: true,
                            delay: 2500,
                            position: { x: "right", y: "bottom" },
                            message: data.success,
                        });
                    } catch (e) { console.log(e); }
                    setTimeout(function () {
                        location.reload();
                    }, 800);
                }
            }).fail(function (xhr) {
                console.log('cancelAppointment failed:', xhr.status);
            });
        });
    }

    // ===== FEEDBACK / REVIEW =====

    function setReviewAppointment(appointmentId) {
        $("#reviewAppointmentId").val(appointmentId);
        $("input[name=rating]").prop('checked', false);
        $("#reviewComment").val('');
        $("#ratingError").text('');
    }

    function submitReview() {
        var appointmentId = $("#reviewAppointmentId").val();
        var rating = $("input[name=rating]:checked").val();
        var comment = $("#reviewComment").val();

        if (!rating) {
            $("#ratingError").text('Please select a star rating.');
            return;
        }
        $("#ratingError").text('');

        $.post('{{ route("saveFeedback") }}', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            appointment_idappointment: appointmentId,
            rating: rating,
            comment: comment
        }, function (data) {
            if (data.success) {
                try {
                    notify({
                        type: "success",
                        title: 'Review Submitted',
                        autoHide: true,
                        delay: 2500,
                        position: { x: "right", y: "top" },
                        message: data.success,
                    });
                } catch (e) { console.log(e); }

                setTimeout(function () {
                    $('#reviewModal').modal('hide');
                }, 500);

                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else if (data.errors) {
                var firstError = Object.values(data.errors)[0][0];
                $("#ratingError").text(firstError);
            }
        }).fail(function (xhr) {
            console.log('submitReview failed:', xhr.status, xhr.responseText.substring(0, 300));
            alert('Review submission failed - check console');
        });
    }
</script>

@include('includes/footer_end')