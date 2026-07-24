{{-- Include Header Start --}}
@include('includes/header_start')

{{-- SweetAlert2 CSS --}}
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">

{{-- Notification CSS --}}
<link href="{{ URL::asset('assets/css/jquery.notify.css')}}" rel="stylesheet" type="text/css">

{{-- CSRF Token for AJAX Requests --}}
<meta name="csrf-token" content="{{ csrf_token() }}"/>

{{-- Include Header End --}}
@include('includes/header_end')

<!-- Page Content -->
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="col-lg-12">

            {{-- Check whether feedback records are available --}}
            @if(isset($feedbacks) && count($feedbacks) > 0)

                {{-- Loop through each feedback --}}
                @foreach($feedbacks as $fb)

                <div class="card m-b-15 feedback-card">
                    <div class="card-body">

                        {{-- Top section containing customer details and admin controls --}}
                        <div class="feedback-top-row">

                            {{-- Customer Information --}}
                            <div class="feedback-user-info">

                                <h5 class="feedback-name">

                                    {{-- Display customer's full name if relationship exists --}}
                                    @if($fb->user)
                                        {{ $fb->user->first_name }}
                                        {{ $fb->user->last_name }}
                                    @else
                                        {{-- Show default text if customer record is unavailable --}}
                                        Unknown Client
                                    @endif

                                </h5>

                                {{-- Display Appointment Number --}}
                                <p class="text-muted feedback-appointment">
                                    Appointment: APT-{{ $fb->appointment_idappointment }}
                                </p>

                            </div>

                            {{-- Admin Only Controls --}}
                            @if(Auth::check() && Auth::user()->role == 1)

                            <div class="feedback-admin-controls">

                                {{-- Display current publish status --}}
                                @if($fb->is_published)
                                    <span class="badge badge-success">Published</span>
                                @else
                                    <span class="badge badge-secondary">Hidden</span>
                                @endif

                                {{-- Button to Publish / Hide Feedback --}}
                                <button
                                    type="button"
                                    class="btn btn-sm btn-info"
                                    onclick="togglePublish({{ $fb->idfeedback }})">

                                    {{ $fb->is_published ? 'Hide' : 'Publish' }}

                                </button>

                            </div>

                            @endif

                        </div>

                        {{-- Display Star Rating --}}
                        <div class="star-display">

                            {{-- Loop from 1 to 5 Stars --}}
                            @for($i=1;$i<=5;$i++)

                                {{-- Filled Star --}}
                                @if($i <= $fb->rating)
                                    <span class="star-filled">&#9733;</span>
                                @else
                                    {{-- Empty Star --}}
                                    <span class="star-empty">&#9733;</span>
                                @endif

                            @endfor

                            {{-- Numeric Rating --}}
                            <span class="rating-number">
                                ({{ $fb->rating }}/5)
                            </span>

                        </div>

                        {{-- Display Feedback Comment --}}
                        <p class="feedback-comment">

                            {{-- Show default message if comment is empty --}}
                            {{ $fb->comment ?: 'No comment provided.' }}

                        </p>

                    </div>
                </div>

                @endforeach

            @else

            {{-- Message displayed when no feedback exists --}}
            <div class="card">
                <div class="card-body text-center">
                    No feedback submitted yet.
                </div>
            </div>

            @endif

        </div>
    </div>
</div>

</div> <!-- Container -->
</div> <!-- Page Content Wrapper -->
</div> <!-- Content -->

<style>

    /* Allow page to grow naturally without clipping */
    .content-page {
        overflow-y: auto !important;
        overflow-x: hidden !important;
        height: auto !important;
    }

    /* Wrapper settings */
    #wrapper {
        overflow: visible !important;
        height: auto !important;
    }

    /* Feedback Card Style */
    .feedback-card {
        border-left: 4px solid #f06292;
    }

    /* Card Body Padding */
    .feedback-card .card-body {
        padding: 14px 18px;
    }

    /* Top Row Layout */
    .feedback-top-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 8px;
    }

    /* Customer Information Area */
    .feedback-user-info {
        flex: 1 1 auto;
    }

    /* Customer Name Style */
    .feedback-name {
        margin-bottom: 2px;
        font-size: 16px;
    }

    /* Appointment Text */
    .feedback-appointment {
        margin-bottom: 0;
        font-size: 13px;
    }

    /* Admin Button Section */
    .feedback-admin-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    /* Star Rating Display */
    .star-display {
        font-size: 18px;
        letter-spacing: 2px;
        margin-top: 6px;
        margin-bottom: 4px;
    }

    /* Filled Star Color */
    .star-filled {
        color: #ffb400;
    }

    /* Empty Star Color */
    .star-empty {
        color: #ddd;
    }

    /* Numeric Rating Style */
    .rating-number {
        font-size: 13px;
        color: #888;
        letter-spacing: normal;
        margin-left: 6px;
        vertical-align: middle;
    }

    /* Feedback Comment Style */
    .feedback-comment {
        font-size: 14px;
        color: #444;
        margin-bottom: 0;
    }

</style>

{{-- Include Footer Start --}}
@include('includes/footer_start')

{{-- SweetAlert2 JS --}}
<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>

{{-- Bootstrap Notify --}}
<script src="{{ URL::asset('assets/js/bootstrap-notify.js')}}"></script>

{{-- jQuery Notify --}}
<script src="{{ URL::asset('assets/js/jquery.notify.min.js')}}"></script>

<script type="text/javascript">

    // Execute when page is fully loaded
    $(document).ready(function () {

        // Attach CSRF token to every AJAX request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    });

    // Publish / Hide feedback using AJAX
    function togglePublish(id) {

        $.post('{{ route("toggleFeedbackPublish") }}', {

            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id

        }, function (data) {

            // Reload page if update is successful
            if (data.success) {
                location.reload();
            }

        });

    }

</script>

{{-- Include Footer End --}}
@include('includes/footer_end')