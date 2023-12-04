@extends('layouts.app')
@section('title', __('lang.attend_and_leave'))
@section('breadcrumbbar')
    <style>
        .table-top-head {
            top: 85px;
        }
    </style>
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between mb-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title  @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.attend_and_leave')</h4>
                    <div class="breadcrumb-list">
                        <ul
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7"
                                    href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.attendance_list')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div
                        class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
                        <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                            @lang('lang.add_attendance_and_leave')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div
                            class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                            <h4 class="print-title">@lang('lang.attendance_list')</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- +++++++++++++ Table +++++++++++++ --}}
                                <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif"
                                    style="margin-top:25px ">
                                    <div class="div1"></div>
                                </div>
                                <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                    <div class="div2 table-scroll-wrapper">
                                        <!-- content goes here -->
                                        <div style="min-width: 1300px;max-height: 90vh;overflow: auto">

                                            <table class="table dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>@lang('lang.date')</th>
                                                        <th>@lang('lang.employee_name')</th>
                                                        <th>@lang('lang.check_in')</th>
                                                        <th>@lang('lang.check_out')</th>
                                                        <th>@lang('lang.status')</th>
                                                        <th>@lang('lang.created_by')</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    {{-- @foreach ($attendances as $attendance)
                                                    <tr>
                                                        <td>
                                                            {{@format_date($attendance->date)}}
                                                        </td>
                                                        <td>
                                                            {{$attendance->employee_name}}
                                                        </td>
                                                        <td>
                                                            {{\Carbon\Carbon::parse($attendance->check_in)->format('h:i:s A')}}
                                                        </td>
                                                        <td>
                                                            {{\Carbon\Carbon::parse($attendance->check_out)->format('h:i:s A')}}
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge @attendance_status($attendance->status)">{{__('lang.' . $attendance->status)}}</span>
                                                            @if ($attendance->status == 'late')
                                                            @php
                                                            $check_in_data = [];
                                                            $employee = App\Models\Employee::find($attendance->employee_id);
                                                            if(!empty($employee)){
                                                            $check_in_data = $employee->check_in;
                                                            }
                                                            $day_name =
                                                            Illuminate\Support\Str::lower(\Carbon\Carbon::parse($attendance->date)->format('l'));
                                                            $late_time = 0;
                                                            if(!empty($check_in_data[$day_name])){
                                                            $check_in_time =$check_in_data[$day_name];
                                                            $late_time =
                                                            \Carbon\Carbon::parse($attendance->check_in)->diffInMinutes($check_in_time);
                                                            }
                                                            @endphp
                                                            @if ($late_time > 0)
                                                            +{{$late_time}}
                                                            @endif
                                                            @endif
                                                            @if ($attendance->status == 'on_leave')
                                                            @php
                                                            $leave = App\Models\Leave::leftjoin('leave_types', 'leave_type_id',
                                                            'leave_types.id')
                                                            ->where('employee_id', $attendance->employee_id)
                                                            ->where('start_date', '>=', $attendance->date)
                                                            ->where('start_date', '<=', $attendance->date)
                                                                ->select('leave_types.name')
                                                                ->first()
                                                                @endphp
                                                                @if (!empty($leave))
                                                                {{$leave->name}}
                                                                @endif
                                                                @endif
                                                        </td>
                                                        <td>
                                                            {{ucfirst($attendance->created_by)}}
                                                        </td>
                                                    </tr>
                                                    @endforeach --}}
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script></script>
@endsection
