@include('includes.header_account')

<!-- ========================= -->
<!-- Login Page Starts -->
<!-- ========================= -->

<!-- Background Section -->
<div class="accountbg"
     style="background: linear-gradient(to bottom, #fce4ec 0%, #f06292 100%);">
</div>

<div class="wrapper-page">

    <!-- Login Card Container -->
    <div class="card"
         style="
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid #fce4ec;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(252, 228, 236, 0.4);
         ">

        <div class="card-body">

            <!-- System Logo -->
            <h3 class="text-center m-0">
                <a href="index" class="logo logo-admin">
                    <img src="assets/images/scissor.png" width="120" alt="Logo">
                </a>
            </h3>

            <div class="p-3">

                <!-- Welcome Message -->
                <h4 class="text-bold font-20 m-b-5 text-center" style="color: #4a148c;">
                    Welcome Saloon Sandaliya
                </h4>

                <p class="text-bold text-center" style="color: #4a148c;">
                    Sign in to continue
                </p>

                <!-- Display Login Error Message -->
                @if(\Session::has('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                        <p>{{ \Session::get('error') }}</p>

                    </div>
                @endif

                <!-- Display Warning Message -->
                @if(\Session::has('warning'))
                    <div class="alert alert-dismissible"
                         style="background-color: #f8bbd0; color: #ad1457; border: 1px solid #e91e63;">

                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                        <p>{{ \Session::get('warning') }}</p>

                    </div>
                @endif

                <!-- Login Form -->
                <form class="form-horizontal m-t-30"
                      action="{{ route('login') }}"
                      method="POST">

                    <!-- Username Input -->
                    <div class="form-group">

                        <label for="user_name" style="color: #4a148c;">
                            Username
                        </label>

                        <input type="text"
                               class="form-control"
                               id="user_name"
                               name="username"
                               placeholder="Enter username"
                               style="
                                    background-color: rgba(255,255,255,0.5);
                                    border: 1px solid #fce4ec;
                                    color: #4a148c;
                               ">

                        <!-- Username Validation Error -->
                        <small class="text-danger">
                            {{ $errors->first('username') }}
                        </small>

                    </div>

                    <!-- Password Input -->
                    <div class="form-group">

                        <label for="password" style="color: #4a148c;">
                            Password
                        </label>

                        <input type="password"
                               class="form-control"
                               id="password"
                               name="password"
                               placeholder="Enter password"
                               style="
                                    background-color: rgba(255,255,255,0.5);
                                    border: 1px solid #fce4ec;
                                    color: #4a148c;
                               ">

                        <!-- Password Validation Error -->
                        <small class="text-danger">
                            {{ $errors->first('password') }}
                        </small>

                    </div>

                    <!-- CSRF Security Token -->
                    <input type="hidden"
                           name="_token"
                           value="{{ Session::token() }}">

                    <!-- Login Button -->
                    <div class="col-sm-6 text-right">

                        <button class="btn w-md waves-effect waves-light"
                                type="submit"
                                style="
                                    background: linear-gradient(to right, #f06292, #ec407a);
                                    color: #fff;
                                    border: none;
                                    font-weight: bold;
                                ">

                            Log In

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- Client Registration Link -->
    <div class="m-t-40 text-center">

        <p style="color: #4a148c; font-weight: 500;">

            Don't have an account?

            <a href="{{ route('clientSignup') }}"
               class="font-500 font-14 font-secondary"
               style="color: #7b1fa2;">

                Sign Up

            </a>

        </p>

    </div>

</div>

<!-- ========================= -->
<!-- Login Page Ends -->
<!-- ========================= -->

@include('includes.footer_account')