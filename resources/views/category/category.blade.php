@include('includes/header_start')

<link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<!-- Responsive datatable examples -->
<link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">

<!-- Plugins css -->
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet"/>
<link href="{{ URL::asset('assets/css/custom_checkbox.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/css/jquery.notify.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/mdb.css')}}" rel="stylesheet" type="text/css">

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

                    <div class="row">

                        <div class="col-lg-8">
                        </div>

                        <div class="col-lg-4">
                            <button type="button" class="btn btn-primary  float-right"
                                    data-toggle="modal"  data-target="#addCategoryModal" >
                                Add Category
                            </button>
                        </div>

                    </div>



                <br/>




             <!--Data Table Start-->

                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">


                            <table id="datatable"   class="table table-striped table-bordered"
                                   cellspacing="0"
                                   width="100%">

                                <thead>
                                    <tr>
    <th>CATEGORY NAME</th>
    <th>AMOUNT</th>
    

    @if(Auth::user()->role == 1)
        <th>STATUS</th>
    @endif

    <th>OPTIONS</th>
</tr>
                                  



                                <tbody>

                                @if(isset($categories))
                                    @if(count($categories)>0)
                                        @foreach($categories as $category)

                                            <tr>
                                                <td>{{$category->category_name}}</td>

                                                <td>{{$category->amount}}</td>


                                     <!-- Status Start -->
@if(Auth::check() && in_array(Auth::user()->role, ['1']))
<td>
    <p>
       <input type="checkbox"
       onchange="adMethod('{{ $category->idcategory }}', 'category', 'cl{{ $category->idcategory }}')"
       id="{{ 'cl' . $category->idcategory }}"
       switch="none"
       {{ $category->status == 1 ? 'checked' : '' }} />

        <label for="{{ 'cl' . $category->idcategory }}"
               data-on-label="On"
               data-off-label="Off">
        </label>
    </p>
</td>
@endif
<!-- Status End -->   



                                     <!--Options Start-->
                                                <td>

                                                    <p>

                                                        <button type="button" title="View"
                                                                class="btn btn-sm btn-default  waves-effect waves-light"
                                                                data-toggle="modal"

                                                                data-name="{{ $category->category_name }}"
                                                                data-amount="{{ $category->amount }}"

                                                                id="viewCategoryID"
                                                                data-target="#viewCategoryModal">
                                                            <i class="fa fa-eye"></i>
                                                        </button>

                                                        <button type="button"
                                                                class="btn btn-sm btn-warning  waves-effect waves-light"
                                                                data-toggle="modal"

                                                                data-id="{{ $category->idcategory }}"
                                                                data-name="{{ $category->category_name }}"
                                                                data-amount="{{ $category->amount }}"

                                                                id="uCategoryID"
                                                                data-target="#CategoryModal"><i
                                                                    class="fa fa-edit"></i>
                                                        </button>

                                                        <button type="button"
                                                                class="btn btn-sm btn-danger  waves-effect waves-light"
                                                                onclick="deleteCategory({{ $category->idcategory}})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>

                                                    </p>

                                                </td>
                                       <!--Options End-->


                                            </tr>


                                        @endforeach
                                    @endif
                                @endif

                                </tbody>

                            </table>

                        </div>
                    </div>


              <!--Data Table End-->





                </div>
            </div>
        </div>
    </div> <!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->








<!-- Add Category Modal Start-->
  @if(Auth::check() && in_array(Auth::user()->role, ['1']))
<div class="modal fade" id="addCategoryModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Category Name <span style="color:red">*</span> </label>
                        <input type="text" class="form-control" name="category"
                               id="category" required placeholder="Category Name" />
                        <span class="text-danger" id="categoryError"></span>
                    </div>

                    <div class="form-group">
                        <label>Amount <span style="color:red">*</span> </label>
                        <input type="number" class="form-control" name="amount"
                               id="amount" required placeholder="Amount" />
                        <span class="text-danger" id="amountError"></span>
                    </div>

                    <div class="form-group">
                        <button type="button"  class="btn btn-primary float-right"
                                onclick="saveCategory()" >
                          Save Category
                          @endif
                        </button>
                    </div>

                </div>

        </div>

    </div>
</div>
<!-- Add Category Modal End-->







<!--View Category modal Start-->
<div class="modal fade" id="viewCategoryModal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title mt-0">Category Details</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group">

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Category Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="viewCategory" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Amount</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="viewAmount" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-md btn-outline-primary waves-effect float-right" data-dismiss="modal" >Close</button>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<!--View Category modal End-->








<!-- Update Category Modal Start-->
 @if(Auth::check() && in_array(Auth::user()->role, ['1']))
<div class="modal fade" id="updateCategoryModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title mt-0">Update Category</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>

            <div class="modal-body">


                <div class="form-group">
                    <label>Category Name</label>


                    <input type="hidden" id="hiddenCategoryId" name="hiddenCategoryId">


                    <input type="text" class="form-control" name="updateCategory"
                           id="updateCategory" required placeholder="Category Name"/>
                    <span class="text-danger" id="updateCategoryError"></span>
                </div>


                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" class="form-control" name="updateAmount"
                           id="updateAmount" required placeholder="Category Amount"/>
                    <span class="text-danger" id="updateAmountError"></span>
                </div>



                <div class="form-group">
                    <button type="button"  class="btn btn-primary float-right"
                            onclick="updateCategory()" >
                        Update Category</button>
                 @endif       
                </div>

            </div>

        </div>

    </div>
</div>
<!-- Update Category Modal End-->







@include('includes/footer_start')

<!-- Plugins js -->
<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}"
        type="text/javascript"></script>

<!-- Plugins Init js -->
<script src="{{ URL::asset('assets/pages/form-advanced.js')}}"></script>

<!-- Required datatable js -->
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/vfs_fonts.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.html5.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.print.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{ URL::asset('assets/pages/sweet-alert.init.js')}}"></script>

<!-- Datatable init js -->
<script src="{{ URL::asset('assets/pages/datatables.init.js')}}"></script>

<!-- Parsley js -->
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









    //Change Status Start
    // FIX: previously this callback did nothing with the response, so if the
    // server failed to update (validation error, wrong table name, exception,
    // etc.) the checkbox still looked "changed" until you refreshed and saw
    // the real DB value. Now we check data.success / data.error and revert
    // the checkbox visually if the update did not actually happen.
    function adMethod(dataID, tableName, checkboxId) {

        var $checkbox = $('#' + checkboxId);

        $.post('activateDeactivate', {id: dataID, table: tableName})
            .done(function (data) {

                console.log('activateDeactivate response:', data);

                if (data && data.success) {
                    notify({
                        type: "success",
                        title: 'STATUS UPDATED',
                        autoHide: true,
                        delay: 1200,
                        position: { x: "right", y: "top" },
                        icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                        message: data.success,
                    });
                } else {
                    // Server responded but did not confirm success -> revert checkbox
                    $checkbox.prop('checked', !$checkbox.prop('checked'));
                    notify({
                        type: "error",
                        title: 'UPDATE FAILED',
                        autoHide: true,
                        delay: 2000,
                        position: { x: "right", y: "top" },
                        message: (data && data.error) ? data.error : 'Status could not be updated.',
                    });
                }
            })
            .fail(function (xhr) {
                console.log('activateDeactivate error:', xhr.responseText);
                // Request itself failed (500, CSRF mismatch, network, etc.) -> revert checkbox
                $checkbox.prop('checked', !$checkbox.prop('checked'));
                notify({
                    type: "error",
                    title: 'UPDATE FAILED',
                    autoHide: true,
                    delay: 2000,
                    position: { x: "right", y: "top" },
                    message: 'Something went wrong while updating status.',
                });
            });
    }
    //Change Status End








//Save Category Start
    function saveCategory() {

        var category=$("#category").val();
        var amount=$("#amount").val();


        $.post('saveCategory', {

            category:category,
            amount:amount

        },function (data) {

            if (data.errors != null) { //If there is validation errors

                if(data.errors.category){
                    var p = document.getElementById('categoryError');
                    p.innerHTML = data.errors.category[0];
                }

                if(data.errors.amount){
                    var p = document.getElementById('amountError');
                    p.innerHTML = data.errors.amount[0];
                }

            }


            if(data.success != null){ //if there is no errors
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'CATEGORY SAVED',
                    autoHide: true, //true | false
                    delay: 1500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                    message: data.success,
                });


                setTimeout(function () {
                    location.reload();
                }, 1500);

            }

        })

    }
    //Save Category End






//View Category Details Start

    $(document).on('click', '#viewCategoryID', function () {

        var categoryName = $(this).data("name");
        var amount = $(this).data("amount");



        $("#viewCategory").val(categoryName);
        $("#viewAmount").val(amount);

    });

    //View Category Details End










//Update Category Start
    $(document).on('click', '#uCategoryID', function () {

        var categoryId = $(this).data("id");

        var categoryName = $(this).data("name");
        var amount = $(this).data("amount");



        $("#hiddenCategoryId").val(categoryId);

        $("#updateCategory").val(categoryName);
        $("#updateAmount").val(amount);

    });

    function updateCategory() {

        var hiddenCategoryId=$("#hiddenCategoryId").val();

        var category=$("#updateCategory").val();
        var amount=$("#updateAmount").val();


        $.post('updateCategory',{

            hiddenCategoryId:hiddenCategoryId,

            category:category,
            amount:amount

        },function (data) {


            if (data.errors != null) { //If there is validation errors

                if(data.errors.category){
                    var p = document.getElementById('updateCategoryError');
                    p.innerHTML = data.errors.category[0];
                }

                if(data.errors.amount){
                    var p = document.getElementById('updateAmountError');
                    p.innerHTML = data.errors.amount[0];
                }

            }



            if(data.success != null){
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'CATEGORY UPDATED',
                    autoHide: true, //true | false
                    delay: 1500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                    message: data.success,
                });

                setTimeout(function () {
                    location.reload();
                }, 1500);


            }
        })
    }
 //Update Category End








//Delete Category Start
    function deleteCategory(id) {

        $.post('deleteCategory', {

            id:id

        }, function (data) {

            if(data.success){
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'CATEGORY DELETED',
                    autoHide: true, //true | false
                    delay: 1500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                    message: data.success,
                });

                setTimeout(function () {
                    location.reload();
                }, 1500);


            }

        });
    }
    //Delete Category End











    //Hide Validation errors after closing the modal without refreshing
    $('.modal').on('hidden.bs.modal', function () {

                        //Add Category
                                $('#categoryError').html('');
                                $('#amountError').html('');


                        //Update Category
                                $('#updateCategoryError').html('');
                                $('#updateAmountError').html('');


                $('input').val(''); //Clear input values of input fields

    });





</script>

@include('includes/footer_end')