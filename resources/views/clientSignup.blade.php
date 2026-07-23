@include('includes.header_account')



<!-- Begin page -->

<!--Background Image-->
{{--<div class="accountbg" style="background-image:url('assets/images/image.png')"> </div>--}}

<!--Background Gradient-->
<div class="accountbg" style="background: linear-gradient(to bottom, #ff80ab 0%, #e91e63 100%);"> </div>


<div class="wrapper-page" >

    <div class="card" style="background-color: rgba(255, 255, 255, 0.9); color: #000; font-family: poppins; border: 2px solid #fce4ec;">
        <div class="card-body">
            <div class="p-3" style="position: relative;">
                
                <div style="position: absolute; right: 15px; top: 10px;">
                    <img src="{{ URL::asset('assets/images/scissor.png') }}" width="80" alt="logo">
                </div>

                <h4 class="font-22 m-b-30 text-center" style="color: #000; padding-top: 15px;">Sign Up</h4>

                <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('saveClient') }}" method="POST" id="saveUser">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label style="color: #000;">First Name<span style="color: red">*</span></label>
                        <input type="text" class="form-control" id="fName" autocomplete="off" name="fName" placeholder="First Name">
                        <small class="text-danger" id="fNameError"></small>
                    </div>

                    <div class="form-group">
                        <label style="color: #000;">Last Name<span style="color: red">*</span></label>
                        <input type="text" class="form-control" id="lName" autocomplete="off" name="lName" placeholder="Last Name">
                        <small class="text-danger" id="lNameError"></small>
                    </div>

                    <div class="form-group">
                        <label style="color: #000;">Contact No<span style="color: red"> *</span></label>
                        <input type="number" class="form-control" id="contactNo" autocomplete="off" name="contactNo" placeholder="+(94) XX XXX XXXX">
                        <small class="text-danger" id="contactNoError"></small>
                    </div>

                    <div class="form-group">
                        <label style="color: #000;">Gender<span style="color: red">*</span></label>
                        <select class="form-control" name="gender" id="gender" required>
                            <option> Male </option>
                            <option> Female </option>
                        </select>
                        <small class="text-danger" id="genderError"></small>
                    </div>

                    <div class="form-group">
                        <label style="color: #000;">Date of Birth<span style="color: red">*</span></label>
                        <input type="date" class="form-control" id="date" autocomplete="off" name="date" placeholder="Date of Birth">
                        <small class="text-danger" id="dateError"></small>
                    </div>

                    <div class="form-group">
                        <label for="username" style="color: #000;">User Name<span style="color: red">*</span></label>
                        <input type="email" class="form-control" id="username" autocomplete="off" name="username"
                               placeholder="example@email.com">
                        <small class="text-danger" id="usernameError"></small>
                    </div>

                    <div class="form-group">
                        <label for="password" style="color: #000;">Password<span style="color: red">*</span></label>
                        <input type="password" class="form-control" id="password" autocomplete="off" name="password" placeholder="Enter password">
                        <small class="text-danger" id="passwordError"></small>
                    </div>


                    <div class="form-group row m-t-30">
                        <div class="col-12 text-center">
                            <button class="btn w-md waves-effect waves-light" style="background-color: #1e98e9; color: #fff;" type="submit">Register</button>
                        </div>
                    </div>


                </form>


            </div>
        </div>
    </div>


</div>



@include('includes.footer_account')

<script src="{{ URL::asset('assets/js/jquery.notify.min.js')}}"></script>

<script type="text/javascript">

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    });
    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });





    //Sign Up
    $("#saveUser").on("submit", function (event) {

            $("#fNameError").html('');
            $("#lNameError").html('');
            $("#contactNoError").html('');
            $("#genderError").html('');
            $("#dateError").html('');
            $("#usernameError").html('');
            $("#passwordError").html('');


            event.preventDefault();

            $.ajax({
                url: "{{ route('saveClient') }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function (data) {

                 if (data.errors != null) {

                        if(data.errors.fName) {
                            var p = document.getElementById('fNameError');
                            p.innerHTML = data.errors.fName[0];
                        }

                         if(data.errors.lName) {
                             var p = document.getElementById('lNameError');
                             p.innerHTML = data.errors.lName[0];
                         }

                        if(data.errors.contactNo) {
                            var p = document.getElementById('contactNoError');
                            p.innerHTML = data.errors.contactNo[0];
                        }

                        if(data.errors.gender) {
                            var p = document.getElementById('genderError');
                            p.innerHTML = data.errors.gender[0];
                        }

                        if(data.errors.date) {
                            var p = document.getElementById('dateError');
                            p.innerHTML = data.errors.date[0];
                        }

                        if(data.errors.username) {
                            var p = document.getElementById('usernameError');
                            p.innerHTML = data.errors.username[0];
                        }

                         if(data.errors.password) {
                             var p = document.getElementById('passwordError');
                             p.innerHTML = data.errors.password[0];
                         }


                    }



                    if (data.success != null) {


                        notify({
                            type: "success", //alert | success | error | warning | info
                            title: 'Registration Success',
                            autoHide: true, 
                            delay: 300, //number ms
                            onClose: function() {
                                window.location.href = "{{ url('signin') }}";
                            },
                            position: {
                                x: "right",
                                y: "top"
                            },
                            icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',

                            message: data.success,
                        });

                        setTimeout(function () {
                            window.location.href = "{{ url('signin') }}";

                        }, 2000);


                    }



                }
            });
        }
    );

</script>
