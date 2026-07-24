@include('includes.header_account')

<!-- CSRF token for AJAX. Delete this line if header_account already has it. -->
<meta name="csrf-token" content="{{ csrf_token() }}"/>

<!-- ============================== -->
<!-- Client Registration Page Starts -->
<!-- ============================== -->

<!-- Background Image (Currently Disabled) -->
{{--<div class="accountbg" style="background-image:url('assets/images/image.png')"></div>--}}

<!-- Background Gradient -->
<div class="accountbg" style="background: linear-gradient(to bottom, #ff80ab 0%, #e91e63 100%);"></div>

<div class="wrapper-page">

    <!-- Registration Card -->
    <div class="card" style="background-color: rgba(255, 255, 255, 0.9); color: #000; font-family: poppins; border: 2px solid #fce4ec;">

        <div class="card-body">

            <div class="p-3" style="position: relative;">

                <!-- Salon Logo -->
                <div style="position: absolute; right: 15px; top: 10px;">
                    <img src="{{ URL::asset('assets/images/scissor.png') }}" width="80" alt="logo">
                </div>

                <!-- Registration Page Title -->
                <h4 class="font-22 m-b-30 text-center" style="color: #000; padding-top: 15px;">
                    Sign Up
                </h4>

                <!-- General / server error message -->
                <div class="alert alert-danger" id="formError" style="display:none;"></div>

                <!-- Client Registration Form -->
                {{-- enctype="multipart/form-data" removed: there are no file inputs,
                     and .serialize() cannot send files anyway. --}}
                <form class="form-horizontal"
                      action="{{ route('saveClient') }}"
                      method="POST"
                      id="saveUser">

                    <!-- CSRF Protection -->
                    {{ csrf_field() }}

                    <!-- First Name -->
                    <div class="form-group">

                        <label style="color: #000;">
                            First Name <span style="color:red">*</span>
                        </label>

                        <input type="text"
                               class="form-control"
                               id="fName"
                               autocomplete="off"
                               name="fName"
                               maxlength="115"
                               placeholder="First Name">

                        <!-- Validation Error -->
                        <small class="text-danger" id="fNameError"></small>

                    </div>

                    <!-- Last Name -->
                    <div class="form-group">

                        <label style="color: #000;">
                            Last Name <span style="color:red">*</span>
                        </label>

                        <input type="text"
                               class="form-control"
                               id="lName"
                               autocomplete="off"
                               name="lName"
                               maxlength="115"
                               placeholder="Last Name">

                        <!-- Validation Error -->
                        <small class="text-danger" id="lNameError"></small>

                    </div>

                    <!-- Contact Number -->
                    {{-- Was type="number", which silently discards "+", spaces and
                         brackets. Anyone typing the old "+(94) XX XXX XXXX"
                         placeholder submitted an empty value. The server rule is
                         exactly 10 digits, so the placeholder now matches it. --}}
                    <div class="form-group">

                        <label style="color:#000;">
                            Contact No <span style="color:red">*</span>
                        </label>

                        <input type="tel"
                               class="form-control"
                               id="contactNo"
                               autocomplete="off"
                               name="contactNo"
                               inputmode="numeric"
                               maxlength="15"
                               placeholder="0771234567">

                        <!-- Validation Error -->
                        <small class="text-danger" id="contactNoError"></small>

                    </div>

                    <!-- Gender -->
                    {{-- THIS WAS THE MISSING FIELD. ClientController validates
                         'gender' => 'required', so without it every submission
                         failed and the button appeared to do nothing. --}}
                    <div class="form-group">

                        <label style="color:#000;">
                            Gender <span style="color:red">*</span>
                        </label>

                        <select class="form-control" id="gender" name="gender">
                            <option value="">-- Select Gender --</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>

                        <!-- Validation Error -->
                        <small class="text-danger" id="genderError"></small>

                    </div>

                    <!-- Date of Birth -->
                    <div class="form-group">

                        <label style="color:#000;">
                            Date of Birth <span style="color:red">*</span>
                        </label>

                        <input type="date"
                               class="form-control"
                               id="date"
                               autocomplete="off"
                               name="date"
                               max="{{ date('Y-m-d') }}">

                        <!-- Validation Error -->
                        <small class="text-danger" id="dateError"></small>

                    </div>

                    <!-- Username / Email -->
                    <div class="form-group">

                        <label for="username" style="color:#000;">
                            User Name <span style="color:red">*</span>
                        </label>

                        <input type="email"
                               class="form-control"
                               id="username"
                               autocomplete="off"
                               name="username"
                               placeholder="example@email.com">

                        <!-- Validation Error -->
                        <small class="text-danger" id="usernameError"></small>

                    </div>

                    <!-- Password -->
                    <div class="form-group">

                        <label for="password" style="color:#000;">
                            Password <span style="color:red">*</span>
                        </label>

                        <input type="password"
                               class="form-control"
                               id="password"
                               autocomplete="off"
                               name="password"
                               placeholder="Enter password (min 6 characters)">

                        <!-- Validation Error -->
                        <small class="text-danger" id="passwordError"></small>

                    </div>

                    <!-- Register Button -->
                    <div class="form-group row m-t-30">

                        <div class="col-12 text-center">

                            <button class="btn w-md waves-effect waves-light"
                                    type="submit"
                                    id="registerBtn"
                                    style="background-color:#1e98e9; color:#fff;">

                                Register

                            </button>

                        </div>

                    </div>

                    <!-- Link back to Sign In -->
                    <div class="form-group row m-t-20">
                        <div class="col-12 text-center">
                            <p style="color:#000; margin-bottom:0;">
                                Already have an account?
                                <a href="{{ url('signin') }}" style="color:#1e98e9;">Sign In</a>
                            </p>
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@include('includes.footer_account')

<!-- Notification Plugin -->
<script src="{{ URL::asset('assets/js/jquery.notify.min.js')}}"></script>

<script type="text/javascript">

    // Everything is bound inside ready() so the handler can never attach before
    // jQuery or the form element exist.
    $(document).ready(function () {

        // Configure CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Prevent mouse wheel from changing number input values
        $(document).on("wheel", "input[type=number]", function () {
            $(this).blur();
        });


        // Client Registration Form Submission
        $("#saveUser").on("submit", function (event) {

            // Prevent normal form submission
            event.preventDefault();

            var $btn = $("#registerBtn");

            // Clear previous validation messages
            $("#fNameError").html('');
            $("#lNameError").html('');
            $("#contactNoError").html('');
            $("#genderError").html('');      // this clear line used to be missing
            $("#dateError").html('');
            $("#usernameError").html('');
            $("#passwordError").html('');
            $("#formError").hide().html('');

            // Block double submissions
            $btn.prop("disabled", true).text("Registering...");

            // Submit form using AJAX
            $.ajax({

                url: "{{ route('saveClient') }}",
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',   // force JSON parsing so a bad response fails loudly

                success: function (data) {

                    $btn.prop("disabled", false).text("Register");

                    // Display validation errors
                    if (data.errors) {

                        if (data.errors.fName)
                            $("#fNameError").html(data.errors.fName[0]);

                        if (data.errors.lName)
                            $("#lNameError").html(data.errors.lName[0]);

                        if (data.errors.contactNo)
                            $("#contactNoError").html(data.errors.contactNo[0]);

                        if (data.errors.gender)
                            $("#genderError").html(data.errors.gender[0]);

                        if (data.errors.date)
                            $("#dateError").html(data.errors.date[0]);

                        if (data.errors.username)
                            $("#usernameError").html(data.errors.username[0]);

                        if (data.errors.password)
                            $("#passwordError").html(data.errors.password[0]);

                        // Catch any validation key the form has no field for.
                        // This is what would have made the gender bug visible
                        // instead of silent.
                        var handled = ['fName', 'lName', 'contactNo', 'gender',
                                       'date', 'username', 'password'];

                        var leftovers = [];

                        $.each(data.errors, function (key, messages) {
                            if ($.inArray(key, handled) === -1) {
                                leftovers.push(messages[0]);
                            }
                        });

                        if (leftovers.length) {
                            $("#formError").html(leftovers.join('<br>')).show();
                        }

                        return;
                    }

                    // Server returned an explicit error string
                    if (data.error) {
                        $("#formError").html(data.error).show();
                        return;
                    }

                    // Registration Successful
                    if (data.success) {

                        notify({
                            type: "success",
                            title: "Registration Success",
                            autoHide: true,
                            delay: 1500,
                            position: {
                                x: "right",
                                y: "top"
                            },
                            icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                            message: data.success
                        });

                        // Redirect to Login Page. The old code redirected from
                        // BOTH onClose and a setTimeout, which raced each other.
                        setTimeout(function () {
                            window.location.href = "{{ url('signin') }}";
                        }, 1500);

                        return;
                    }

                    // Valid JSON but no recognised key
                    $("#formError")
                        .html("Unexpected response from the server.")
                        .show();
                },

                // This handler was missing entirely. Any 419 / 422 / 500 used to
                // vanish without a trace, making the button look dead.
                error: function (xhr) {

                    $btn.prop("disabled", false).text("Register");

                    var message;

                    if (xhr.status === 419) {
                        message = "Session expired (CSRF token mismatch). Refresh the page and try again.";
                    } else if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        var msgs = [];
                        $.each(xhr.responseJSON.errors, function (k, v) {
                            msgs.push(v[0]);
                        });
                        message = msgs.join('<br>');
                    } else if (xhr.status === 404) {
                        message = "Route not found. Check that saveClient is registered as a POST route.";
                    } else if (xhr.status === 500) {
                        message = "Server error. Check storage/logs/laravel.log for details.";
                    } else {
                        message = "Request failed (" + xhr.status + " " + xhr.statusText + ").";
                    }

                    $("#formError").html(message).show();

                    console.error("saveClient failed:", xhr.status, xhr.responseText);
                }

            });

        });

    });

</script>

<!-- ============================== -->
<!-- Client Registration Page Ends -->
<!-- ============================== -->