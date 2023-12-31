@extends('layouts.app')
@section('title', __('lang.employee_module'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        {{-- ///////// left side //////////// --}}
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">@lang('lang.add_employee')</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('employees.index')}}">@lang('lang.employees')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('lang.add_employee')</li>
                </ol>
            </div>
        </div>
        {{-- ///////// right side //////////// --}}
        <div class="widgetbar">
            <a  class="btn btn-primary" href="{{route('employees.index')}}">@lang('lang.employee')</a>
            {{--  <a style="color: white" href="{{ action('EmployeeController@create') }}" class="btn btn-info"><i--}}
            {{--             class="dripicons-plus"></i>--}}
            {{--              @lang('lang.add_new_employee')</a>--}}
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>@lang('lang.add_employee')</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- ////////////////////// employee's products ////////////////////// --}}
                            <div class="col-md-12 text-center">
                                <h3>@lang('lang.employee_products')</h3>
                            </div>
                            {{-- ======== Filters ======== --}}
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    @include('employees.partials.filters')
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <form class="form-group" id="productForm" action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- ++++++++++++++++++++++ employee's products ++++++++++++++++++++  --}}
                                    <div class="row mt-4 m-auto">
                                        {{-- ++++++++++++++ employee's products Table ++++++++++ --}}
                                        <table id="datatable-buttons" class="table table-striped table-bordered m-auto">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    {{-- "select_all" checkbox --}}
                                                    <th> <input type="checkbox" id="select_all_ids"/> </th>
                                                    <th>@lang('lang.product_name')</th>
                                                    <th>@lang('lang.sku')</th>
                                                    <th>@lang('lang.category')</th>
                                                    <th>@lang('lang.subcategories_name')</th>
                                                    <th>@lang('lang.brand')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($employee_products as $index=>$product)
                                                    <tr>
                                                        <td>{{ $index+1 }}</td>
                                                        {{-- "select" checkbox --}}
                                                        <td>
                                                            {{-- get "all checked products" --}}
                                                            <input type="checkbox" name="ids[]" class="checkbox_ids" value="{{$product->id}}" />
                                                        </td>
                                                        <td title="@lang('lang.product_name')">{{$product->name}}</td>
                                                        <td title="@lang('lang.sku')">{{$product->sku}}</td>
                                                        <td title="@lang('lang.category')">{{$product->category->name??''}}</td>
                                                        <td title="@lang('lang.subcategories_name')">
                                                            {{$product->subCategory1->name??''}} <br>
                                                            {{$product->subCategory2->name??''}} <br>
                                                            {{$product->subCategory3->name??''}}
                                                        </td>
                                                        <td title="@lang('lang.brand')">{{!empty($product->brand)?$product->brand->name:''}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <br/>
                                    {{-- +++++++++++++++++ employee [ name , store , email ] +++++++++++++++++ --}}
                                    <div class="row">
                                        {{-- ============= name ============= --}}
                                        <div class="col-sm-6">
                                            <label for="fname">@lang('lang.name'):*</label>
                                            <input type="text" class="form-control" name="name" id="name" required
                                                   placeholder="Name">
                                        </div>
                                        {{-- ============= email ============= --}}
                                        <div class="col-sm-6">
                                            <label for="email">@lang('lang.email'):*
                                                <small>(@lang('lang.it_will_be_used_for_login'))</small></label>
                                            <input type="email" class="form-control" name="email" id="email" required
                                                   placeholder="Email">
                                        </div>
                                    </div>
                                    {{-- +++++++++++++++++ password , confirm_password +++++++++++++++++ --}}
                                    <div class="row mt-4">
                                        {{-- ========== password ========== --}}
                                        <div class="col-sm-6">
                                            <label for="password">@lang('lang.password'):*</label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                    placeholder="Create New Password">
                                        </div>
                                        {{-- ========== confirm_password ========== --}}
                                        <div class="col-sm-6">
                                            <label for="pass">@lang('lang.confirm_password'):*</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                     name="password_confirmation" placeholder="Conform Password">
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++++ branch , stores ++++++++++++++++++++  --}}
                                    <div class="row mt-4">
                                        {{-- ========== branch ========== --}}
                                        <div class="col-sm-6">
                                            <label for="branch_id">@lang('lang.branch')</label>
                                            {!! Form::select('branch_id', $branches, null, ['class' => 'form-control select2','placeholder' => __('lang.please_select') , 'data-live-search' => 'true', 'id' => 'branch_id']) !!}
                                        </div>
                                        {{-- ========== stores ========== --}}
                                        <div class="col-sm-6">
                                            <label for="store_id">@lang('lang.stores')</label>
                                            {!! Form::select('store_id[]', $stores, null, ['class' => 'form-control select2', 'multiple', 'data-live-search' => 'true', 'id' => 'store_id']) !!}
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++++ date_of_start_working , date_of_birth ++++++++++++++++++++  --}}
                                    <div class="row mt-4">
                                        {{-- ============= date_of_start_working ============= --}}
                                        <div class="col-sm-6">
                                            <label for="date_of_start_working">@lang('lang.date_of_start_working')</label>
                                            <input type="date" class="form-control"
                                                   name="date_of_start_working" id="date_of_start_working"
                                                   placeholder="@lang('lang.date_of_start_working')">
                                        </div>
                                        {{-- ============= date_of_birth ============= --}}
                                        <div class="col-sm-6">
                                            <label for="date_of_birth">@lang('lang.date_of_birth')</label>
                                            <input type="date" class="form-control" name="date_of_birth"
                                                   id="date_of_birth" placeholder="@lang('lang.date_of_birth')">
                                        </div>

                                    </div>
                                    {{-- ++++++++++++++++++++++ job_type , phone_number ++++++++++++++++++++  --}}
                                    <div class="row mt-4">
                                        {{-- ============= job_type ============= --}}
                                        <div class="col-sm-6">
                                            <label for="job_type">@lang('lang.jobs')</label>
                                            {!! Form::select('job_type_id', $jobs, null, ['class' => 'form-control selectpicker', 'placeholder' => __('lang.select_job_type'), 'data-live-search' => 'true' , 'id'=>'job_type_id']) !!}
                                        </div>
                                        {{-- ============= phone_number ============= --}}
                                        <div class="col-sm-6">
                                            <label for="mobile">@lang('lang.phone_number'):*</label>
                                            <input type="mobile" class="form-control" name="mobile" id="mobile"
                                                   placeholder="@lang('lang.mobile')">
                                        </div>

                                    </div>
                                    {{-- ++++++++++++++++++++++ upload_files , profile_photo ++++++++++++++++++++  --}}
                                    <div class="row mt-4">
                                        {{-- ============= upload_files ============= --}}
                                        <div class="col-sm-6">
                                            <label for="upload_files">@lang('lang.upload_files')</label>
                                            {!! Form::file('upload_files[]', ['class' => 'form-control', 'multiple']) !!}
                                        </div>
                                        {{-- ============= profile_photo ============= --}}
                                        <div class="col-md-6">
                                            <label for="photo">@lang('lang.profile_photo')</label>
                                            <input type="file" name="photo" id="photo" class="form-control" />
                                        </div>
                                    </div>
                                    {{-- ++++++++++++++++++++++ حدد أيام العمل في الأسبوع ++++++++++++++++++++  --}}
                                    {{-- ============= حدد أيام العمل في الأسبوع ============= --}}
                                    <div class="row mt-4">
                                        @foreach ($leave_types as $leave_type)
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="i-checks">
                                                        <input id="number_of_leaves{{ $leave_type->id }}"
                                                               name="number_of_leaves[{{ $leave_type->id }}][enabled]"
                                                               type="checkbox" value="1">
                                                        <label
                                                            for="number_of_leaves{{ $leave_type->id }}"><strong>{{ $leave_type->name }}</strong></label>
                                                        <input type="number" class="form-control"
                                                               name="number_of_leaves[{{ $leave_type->id }}][number_of_days]"
                                                               id="number_of_leaves" placeholder="{{ $leave_type->name }}"
                                                               readonly value="{{ $leave_type->number_of_days_per_year }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    {{-- ++++++++++++++++++++++ salary_details ++++++++++++++++++++  --}}
                                    <div class="row mt-4">
                                        <!-- Button salary modal -->
                                        <button type="button" style="margin-left: 15px;" class="btn btn-primary"
                                                data-toggle="modal" data-target="#salary_details">
                                            @lang('lang.salary_details')
                                        </button>
                                        @include('employees.partials.salary_details')
                                    </div>
                                    <br>
                                    <br>
                                    {{-- +++++++++++++++++++ حدد أيام العمل في الأسبوع ++++++++++++++++++++ --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label
                                                for="working_day_per_week">@lang('lang.select_working_day_per_week')</label>
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>@lang('lang.check_in')</th>
                                                        <th>@lang('lang.check_out')</th>
                                                        <th>@lang('lang.evening_shift')</th>
                                                        <th id="label1" class="hidden">@lang('lang.check_in')</th>
                                                        <th id="label2" class="hidden">@lang('lang.check_out')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($week_days as $key => $week_day)
                                                        <tr>
                                                            {{-- "working_day_per_week" checkbox --}}
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="i-checks">
                                                                        <input id="working_day_per_week{{ $key }}" name="working_day_per_week[{{ $key }}]" type="checkbox" value="1">
                                                                        <label for="working_day_per_week{{ $key }}"><strong>{{ $week_day }}</strong></label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            {{-- "check_in" inputField --}}
                                                            <td>
                                                                {{-- {!! Form::text('check_in[' . $key . ']', null, ['class' => 'form-control input-md check_in time_picker']) !!}  --}}
                                                                {{-- <input type="datetime-local" class="form-control" name="check_in[{{ $key }}]" id="input10{{ $key }}"> --}}
                                                                <input type="time" class="form-control" name="check_in[{{ $key }}]" id="input10{{ $key }}">
                                                            </td>
                                                            {{-- "check_out" inputField --}}
                                                            <td>
                                                                {{-- <input type="datetime-local" class="form-control" name="check_out[{{ $key }}]" id="input20{{ $key }}"> --}}
                                                                {{-- {!! Form::text('check_out[' . $key . ']', null, ['class' => 'form-control input-md check_out time_picker']) !!} --}}
                                                                <input type="time" class="form-control" name="check_out[{{ $key }}]" id="input20{{ $key }}">
                                                            </td>
                                                            {{-- ++++++++++++++++++ Evening Shift +++++++++++++++ --}}
                                                            <td >
                                                                <input type="checkbox" class="checkbox-toggle" id="checkbox2{{ $key }}" name="evening_shift_checkbox[{{ $key }}]">
                                                            </td>
                                                            {{--  "تسجيل الدخول" , "تسجيل الخروج" --}}
                                                            <td>
                                                                <table class="hidden inputFields_evening_shift" id="inputFields_evening_shift{{ $key }}">
                                                                    <tr>
                                                                        {{-- تسجيل الدخول --}}
                                                                        <td>
                                                                            {{-- <input type="datetime-local" class="form-control" name="evening_shift_check_in[{{ $key }}]" id="input1{{ $key }}"> --}}
                                                                            <input type="time" class="form-control" name="evening_shift_check_in[{{ $key }}]" id="input1{{ $key }}">
                                                                        </td>
                                                                        {{-- تسجيل الخروج --}}
                                                                        <td>
                                                                            {{-- <input type="datetime-local" class="form-control" name="evening_shift_check_out[{{ $key }}]" id="input2{{ $key }}"> --}}
                                                                            <input type="time" class="form-control" name="evening_shift_check_out[{{ $key }}]" id="input2{{ $key }}">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            {{-- <br/>  --}}
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    {{-- +++++++++++++++++++ permission +++++++++++++++++++ --}}
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <h3>@lang('lang.user_rights')</h3>
                                        </div>
                                        <div class="col-md-12">
                                            @include('employees.partials.permission')
                                        </div>
                                    </div>
                                    {{-- +++++++++++++ save Button +++++++++++ --}}
                                    <div class="row mt-4">
                                        <div class="col-sm-12">
                                            <div class="text-right">
                                                <input type="submit" id="submit-btn" class="btn btn-primary"
                                                       value="@lang('lang.save')" name="submit">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('javascripts')
    <script>

        $(document ).ready(function() {
            $('.checked_all').change(function() {
                tr = $(this).closest('tr');
                var checked_all = $(this).prop('checked');

                tr.find('.check_box').each(function(item) {
                    if (checked_all === true) {
                        $(this).prop('checked', true)
                    } else {
                        $(this).prop('checked', false)
                    }
                })
            })
            // +++++++++++++++++++++++++++++++++ Permissions Table +++++++++++++++++++++++++++++++++
            $('.all_module_check_all').change(function() {
                var all_module_check_all = $(this).prop('checked');
                $('#permission_table > tbody > tr').each((i, tr) => {
                    $(tr).find('.check_box').each(function(item) {
                        if (all_module_check_all === true) {
                            $(this).prop('checked', true)
                        } else {
                            $(this).prop('checked', false)
                        }
                    })
                    $(tr).find('.module_check_all').each(function(item) {
                        if (all_module_check_all === true) {
                            $(this).prop('checked', true)
                        } else {
                            $(this).prop('checked', false)
                        }
                    })
                    $(tr).find('.checked_all').each(function(item) {
                        if (all_module_check_all === true) {
                            $(this).prop('checked', true)
                        } else {
                            $(this).prop('checked', false)
                        }
                    })

                })
            })
            // when check "first checkbox" then check "all checkboxes" in the same column
            $('.module_check_all').change(function() {
                let moudle_id = $(this).closest('tr').data('moudle');
                if ($(this).prop('checked')) {
                    $('.sub_module_permission_' + moudle_id).find('.checked_all').prop('checked', true);
                    $('.sub_module_permission_' + moudle_id).find('.check_box').prop('checked', true);
                } else {
                    $('.sub_module_permission_' + moudle_id).find('.checked_all').prop('checked', false);
                    $('.sub_module_permission_' + moudle_id).find('.check_box').prop('checked', false);
                }
            })
            // "details checkboxes" column : when check "details checkbox" Then check "all checkboxes" of "details" column
            $(document).on('change', '.view_check_all', function() {
                if ($(this).prop('checked')) {
                    $('.check_box_view').prop('checked', true);
                } else {
                    $('.check_box_view').prop('checked', false);
                }
            });
            // "انشاء" column : when check "انشاء checkbox" Then check "all checkboxes" of in the "same row"
            $(document).on('change', '.create_check_all', function() {
                if ($(this).prop('checked')) {
                    $('.check_box_create').prop('checked', true);
                } else {
                    $('.check_box_create').prop('checked', false);
                }
            });
            // "edit" column : when check "تعديل checkbox" Then check "all checkboxes" of in the "same row"
            $(document).on('change', '.edit_check_all', function() {
                if ($(this).prop('checked')) {
                    $('.check_box_edit').prop('checked', true);
                } else {
                    $('.check_box_edit').prop('checked', false);
                }
            });
            // "حذف" column : when check "حذف checkbox" Then check "all checkboxes" of in the "same row"
            $(document).on('change', '.delete_check_all', function() {
                if ($(this).prop('checked')) {
                    $('.check_box_delete').prop('checked', true);
                } else {
                    $('.check_box_delete').prop('checked', false);
                }
            });
            // Check All checkboxes in the same column
            $(document).on('focusout', '.check_in', function() {
                $('.check_in').val($(this).val())
            })
            $(document).on('focusout', '.check_out', function() {
                $('.check_out').val($(this).val())
            })
            // +++++++++++++++++ Evening Shift +++++++++++++++++
            // Get all the checkboxes and input fields
            const checkboxes = document.querySelectorAll('.checkbox-toggle');
            const inputFields = document.querySelectorAll('.inputFields_evening_shift');
            const label1 = document.getElementById('label1');
            const label2 = document.getElementById('label2');
            // when checkbox of "evening shift" is "checked" then appear "two input fields"
            checkboxes.forEach((checkbox, index) =>
            {
                checkbox.addEventListener('change', function ()
                {
                    if (checkbox.checked){
                        inputFields[index].classList.remove('hidden');
                        updateLabelsVisibility();
                    }else{
                        inputFields[index].classList.add('hidden');
                        updateLabelsVisibility();
                    }
                });
                // Check the initial state of checkboxes and show/hide labels accordingly
                if (checkbox.checked) {
                    label1.classList.remove('hidden');
                    label2.classList.remove('hidden');
                }else{
                    label1.classList.add('hidden');
                    label2.classList.add('hidden');
                }
                // ++++++++++++++++++++ updateLabelsVisibility() ++++++++++++++++++++
                function updateLabelsVisibility()
                {
                    let anyCheckboxChecked = false;
                    checkboxes.forEach(function(checkbox)
                    {
                        if (checkbox.checked) {
                            anyCheckboxChecked = true;
                        }
                    });
                    if (anyCheckboxChecked) {
                        label1.classList.remove('hidden');
                        label2.classList.remove('hidden');
                    }else {
                        label1.classList.add('hidden');
                        label2.classList.add('hidden');
                    }
                }
                // Initially update labels visibility based on the checked state of checkboxes
                updateLabelsVisibility();
            });
            // ======================================== Checkboxes of "products" table ========================================
            // when click on "all checkboxs" , it will checked "all checkboxes"
            $('#select_all_ids').click(function() {
                $('.checkbox_ids').prop('checked', $(this).prop('checked'));
            });
            // ++++++++++++++++++++ Get "job_type" Permissions +++++++++++++++++++++++++
            // when select "job_type" , it will get "all permissions" of "selected job type"
            $('#job_type_id').change(function()
            {
                var jobTypeId = $(this).val();
                console.log("The Selected 'job_type' = "+jobTypeId);
                // Make an AJAX request to fetch permissions based on the selected job type
                $.ajax({
                    url: '/get-job-type-permissions/' + jobTypeId, // Replace with your actual route
                    type: 'GET',
                    success: function (data)
                    {
                        updatePermissionCheckboxes(data);
                        console.log(data);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching job type permissions:', error);
                    }
                });
            });
            // ------- updatePermissionCheckboxes() -------------
            function updatePermissionCheckboxes(permissions)
            {
                // Uncheck all checkboxes first
                $('.check_box').prop('checked', false);
                // Check checkboxes based on permissions array
                permissions.forEach(function (permission) {
                    $('input[name="permissions[' + permission + ']"]').prop('checked', true);
                });
            }
        });
    </script>
@endpush
