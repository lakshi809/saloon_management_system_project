@include('includes.header_account')

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

                <!-- Client Registration Form -->
                <form class="form-horizontal"
                      enctype="multipart/form-data"
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
                               placeholder="Last Name">

                        <!-- Validation Error -->
                        <small class="text-danger" id="lNameError"></small>

                    </div>

                    <!-- Contact Number -->
                    <div class="form-group">

                        <label style="color:#000;">
                            Contact No <span style="color:red">*</span>
                        </label>

                        <input type="number"
                               class="form-control"
                               id="contactNo"
                               autocomplete="off"
                               name="contactNo"
                               placeholder="+(94) XX XXX XXXX">

                        <!-- Validation Error -->
                        <small class="text-danger" id="contactNoError"></small>

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
                               name="date">

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
                               placeholder="Enter password">

                        <!-- Validation Error -->
                        <small class="text-danger" id="passwordError"></small>

                    </div>

                    <!-- Register Button -->
                    <div class="form-group row m-t-30">

                        <div class="col-12 text-center">

                            <button class="btn w-md waves-effect waves-light"
                                    type="submit"
                                    style="background-color:#1e98e9; color:#fff;">

                                Register

                            </button>

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

    // Execute when page is loaded
    $(document).ready(function () {

        // Configure CSRF token for AJAX requests
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

    // Client Registration Form Submission
    $("#saveUser").on("submit", function (event) {

        // Clear previous validation messages
        $("#fNameError").html('');
        $("#lNameError").html('');
        $("#contactNoError").html('');
        $("#genderError").html('');
        $("#dateError").html('');
        $("#usernameError").html('');
        $("#passwordError").html('');

        // Prevent normal form submission
        event.preventDefault();

        // Submit form using AJAX
        $.ajax({

            url: "{{ route('saveClient') }}",
            type: 'POST',
            data: $(this).serialize(),

            success: function (data) {

                // Display validation errors
                if (data.errors != null) {

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
                }

                // Registration Successful
                if (data.success != null) {

                    // Display success notification
                    notify({

                        type: "success",

                        title: "Registration Success",

                        autoHide: true,

                        delay: 300,

                        onClose: function () {
                            window.location.href = "{{ url('signin') }}";
                        },

                        position: {
                            x: "right",
                            y: "top"
                        },

                        icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',

                        message: data.success

                    });

                    // Redirect to Login Page
                    setTimeout(function () {

                        window.location.href = "{{ url('signin') }}";

                    }, 2000);

                }

            }

        });

    });

</script>

<!-- ============================== -->
<!-- Client Registration Page Ends -->
<!-- ============================== -->