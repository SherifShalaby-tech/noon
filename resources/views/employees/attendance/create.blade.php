@extends('layouts.app')
@section('title', __('lang.add_attendance_and_leave'))
    @section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.attend_and_leave')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.attend_and_leave')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{route('attendance.index')}}" class="btn btn-primary">
                        @lang('lang.attend_and_leave')
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endsection
@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>@lang('lang.attendance')</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <br>
                            {!! Form::open(['url' => route('attendance.store'), 'method' => 'post']) !!}
                            {{-- "index" of "each row" --}}
                            <input type="hidden" name="index" id="index" value="0">
                            <div class="row">
                                {{-- add "new_row" to table --}}
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary add_row" id="add_row">
                                        +@lang('lang.add_row')
                                    </button>
                                </div>
                            </div>
                            <br>
                            {{-- ++++++++++++++++++++ Table ++++++++++++++++++++ --}}
                            <table class="table" id="attendance_table">
                                {{-- /////////// table_thead /////////// --}}
                                <thead>
                                    <tr>
                                        <th>@lang('lang.date')</th>
                                        <th>@lang('lang.employee')</th>
                                        <th>@lang('lang.check_in')</th>
                                        <th>@lang('lang.check_out')</th>
                                        <th>@lang('lang.status')</th>
                                        <th>@lang('lang.created_by')</th>
                                        <th>@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                {{-- /////////// table_tbody /////////// --}}
                                <tbody class="table_tbody">
                                    <tr>
                                        <td>
                                            <input type="date" class="form-control date" name="date" required>
                                        </td>
                                        <td>
                                            {!! Form::select('employees', $employees, null ,
                                            ['class' => 'form-control select2', 'placeholder' => __('lang.please_select'),'data-live-search' => 'true', 'required']) !!}
                                        </td>
                                        <td>
                                            <input type="time" class="form-control time" name="check_in" id="check_in_id" required>
                                        </td>
                                        <td>
                                            <input type="time" class="form-control time" name="check_out" id="check_out_id"  required>
                                        </td>
                                        <td>
                                            {!! Form::select('status',
                                                [   'present' => 'Present', 'late'=> 'Late', 'on_leave' => 'On Leave'],
                                                    null , ['class' => 'form-control select2' , 'id'=>'status_id' , 'data-live-search' => 'true',
                                                    'placeholder' => __('lang.please_select'), 'required'
                                                ]) !!}
                                        </td>
                                        <td>
                                            {{ucfirst(Auth::user()->name)}}
                                        </td>
                                        {{-- ++++++++ delete row ++++++++ --}}
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-xs btn-danger deleteRow">
                                                <i class="fa fa-close"></i>
                                            </a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-primary" value="@lang('lang.save')"
                                        name="submit">
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    // +++++++++++++ add "new_row" to table +++++++++++++
    $('#add_row').click(function(){
        row_index = parseInt($('#index').val());
        row_index = row_index + 1;
        $('#index').val(row_index);
        $.ajax({
            method: 'get',
            url: '/attendance/get-attendance-row/'+row_index,
            data: {  },
            contentType: 'html',
            success: function(result) {
                $('#attendance_table tbody').append(result);
            },
        });
    });
    // +++++++++++++ remove "row" to table +++++++++++++
    $('.table_tbody').on('click','.deleteRow',function(){
        $(this).parent().parent().remove();
    });
    // Assuming check_in and check_out are the IDs of your input fields
    $('#check_in_id, #check_out_id').on('change', function() {
        var checkInValue = $('#check_in_id').val();
        var checkOutValue = $('#check_out_id').val();
        // Check if both check_in and check_out values are set
        if (checkInValue && checkOutValue) {
            // Set the value of the status select box to "present"
            $('#status_id').val('present').trigger('change'); // Use trigger('change') to trigger the change event
        }
    });
</script>
@endsection
