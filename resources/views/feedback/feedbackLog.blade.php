@include('includes/header_start')
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/jquery.notify.css')}}" rel="stylesheet" type="text/css">
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@include('includes/header_end')
<!-- Page title -->
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="col-lg-12">
@if(isset($feedbacks) && count($feedbacks) > 0)
@foreach($feedbacks as $fb)
<div class="card m-b-15 feedback-card">
<div class="card-body">

    <div class="feedback-top-row">

        <div class="feedback-user-info">
            <h5 class="feedback-name">
                @if($fb->user)
                    {{ $fb->user->first_name }}
                    {{ $fb->user->last_name }}
                @else
                    Unknown Client
                @endif
            </h5>
            <p class="text-muted feedback-appointment">
                Appointment: APT-{{ $fb->appointment_idappointment }}
            </p>
        </div>

        @if(Auth::check() && Auth::user()->role == 1)
        <div class="feedback-admin-controls">
            @if($fb->is_published)
                <span class="badge badge-success">Published</span>
            @else
                <span class="badge badge-secondary">Hidden</span>
            @endif
            <button type="button"
                class="btn btn-sm btn-info"
                onclick="togglePublish({{ $fb->idfeedback }})">
                {{ $fb->is_published ? 'Hide' : 'Publish' }}
            </button>
        </div>
        @endif

    </div>

    <div class="star-display">
        @for($i=1;$i<=5;$i++)
            @if($i <= $fb->rating)
                <span class="star-filled">&#9733;</span>
            @else
                <span class="star-empty">&#9733;</span>
            @endif
        @endfor
        <span class="rating-number">({{ $fb->rating }}/5)</span>
    </div>

    <p class="feedback-comment">
        {{ $fb->comment ?: 'No comment provided.' }}
    </p>

</div>
</div>
@endforeach
@else
<div class="card">
<div class="card-body text-center">
No feedback submitted yet.
</div>
</div>
@endif
        </div>
    </div>
</div>


    </div> <!-- container -->
</div> <!-- Page content Wrapper -->
</div> <!-- content -->
<style>
    /* Root fix: let content-page grow instead of clipping at viewport height */
    .content-page {
        overflow-y: auto !important;
        overflow-x: hidden !important;
        height: auto !important;
    }
    #wrapper {
        overflow: visible !important;
        height: auto !important;
    }

    .feedback-card {
        border-left: 4px solid #f06292;
    }
    .feedback-card .card-body {
        padding: 14px 18px;
    }

    .feedback-top-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 8px;
    }
    .feedback-user-info {
        flex: 1 1 auto;
    }
    .feedback-name {
        margin-bottom: 2px;
        font-size: 16px;
    }
    .feedback-appointment {
        margin-bottom: 0;
        font-size: 13px;
    }

    .feedback-admin-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .star-display {
        font-size: 18px;
        letter-spacing: 2px;
        margin-top: 6px;
        margin-bottom: 4px;
    }
    .star-filled {
        color: #ffb400;
    }
    .star-empty {
        color: #ddd;
    }
    .rating-number {
        font-size: 13px;
        color: #888;
        letter-spacing: normal;
        margin-left: 6px;
        vertical-align: middle;
    }
    .feedback-comment {
        font-size: 14px;
        color: #444;
        margin-bottom: 0;
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