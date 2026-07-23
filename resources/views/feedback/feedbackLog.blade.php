@include('includes/header_start')

<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
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

            @if(isset($feedbacks) && count($feedbacks) > 0)

                @foreach($feedbacks as $fb)
                <div class="card m-b-20 feedback-card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-start flex-wrap">

                            <div>
                                <h5 class="m-b-5">
                                    {{ $fb->user->first_name ?? 'Unknown' }} {{ $fb->user->last_name ?? '' }}
                                </h5>
                                <p class="text-muted m-b-5">
                                    Appointment: APT-{{ $fb->appointment_idappointment }}
                                    &nbsp;|&nbsp;
                                    {{ \Carbon\Carbon::parse($fb->created_at)->format('d M Y, h:i A') }}
                                </p>
                            </div>

                            <div class="text-right">
                                @if($fb->is_published)
                                    <span class="badge badge-pill badge-success">Published</span>
                                @else
                                    <span class="badge badge-pill badge-secondary">Hidden</span>
                                @endif
                            </div>

                        </div>

                        <div class="star-display m-t-10 m-b-10">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fb->rating)
                                    <span class="star-filled">&#9733;</span>
                                @else
                                    <span class="star-empty">&#9733;</span>
                                @endif
                            @endfor
                            <span class="rating-number">({{ $fb->rating }}/5)</span>
                        </div>

                        <p class="feedback-comment m-b-15">
                            {{ $fb->comment ?: 'No comment provided.' }}
                        </p>

                        <button type="button" class="btn btn-sm btn-info"
                                onclick="togglePublish({{ $fb->idfeedback }})">
                            {{ $fb->is_published ? 'Hide' : 'Publish' }}
                        </button>

                    </div>
                </div>
                @endforeach

            @else

                <div class="card m-b-20">
                    <div class="card-body text-center text-muted">
                        No feedback submitted yet.
                    </div>
                </div>

            @endif

        </div>
    </div> <!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->

<style>
    .feedback-card {
        border-left: 4px solid #f06292;
    }
    .star-display {
        font-size: 22px;
        letter-spacing: 2px;
    }
    .star-filled {
        color: #ffb400;
    }
    .star-empty {
        color: #ddd;
    }
    .rating-number {
        font-size: 14px;
        color: #888;
        letter-spacing: normal;
        margin-left: 6px;
        vertical-align: middle;
    }
    .feedback-comment {
        font-size: 15px;
        color: #444;
    }
</style>


@include('includes/footer_start')

<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-notify.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery.notify.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    function togglePublish(id) {
        $.post('{{ route("toggleFeedbackPublish") }}', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id
        }, function (data) {
            if (data.success) {
                location.reload();
            }
        });
    }
</script>

@include('includes/footer_end')