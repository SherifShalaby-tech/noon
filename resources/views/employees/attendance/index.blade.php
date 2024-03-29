@extends('layouts.app')
@section('title', __('lang.attend_and_leave'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.attend_and_leave')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.attendance_list')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                        @lang('lang.add_attendance_and_leave')
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
                        <h4 class="print-title">@lang('lang.attendance_list')</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- ++++++++++++++++++++++++++ Table ++++++++++++++++++++++++++  --}}
                            <div class="col-sm-12">
                                <br>
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
                                        @foreach ($attendances as $attendance)
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
                                            {{-- ++++++++++++++ status ++++++++++++++++ --}}
                                            <td>
                                                {{-- ///// status == late ///// --}}
                                                @if($attendance->status == 'late')
                                                    <span class="badge badge-danger p-2">
                                                        {{__('lang.' . $attendance->status)}}
                                                    </span>
                                                {{-- ///// status == present ///// --}}
                                                @elseif ($attendance->status == 'present')
                                                    <span class="badge badge-success p-2">
                                                        {{__('lang.' . $attendance->status)}}
                                                    </span>
                                                {{-- ///// status == on_leave ///// --}}
                                                @else
                                                    <span class="badge badge-warning p-2">
                                                        {{__('lang.' . $attendance->status)}}
                                                    </span>
                                                @endif

                                                @if($attendance->status == 'late')
                                                    @php
                                                        $check_in_data = [];
                                                        $employee = App\Models\Employee::find($attendance->employee_id);
                                                        if(!empty($employee))
                                                        {
                                                            $check_in_data = $employee->check_in;
                                                        }
                                                        $day_name = Illuminate\Support\Str::lower(\Carbon\Carbon::parse($attendance->date)->format('l'));
                                                        $late_time = 0;
                                                        if(!empty($check_in_data[$day_name]))
                                                        {
                                                            $check_in_time = $check_in_data[$day_name];
                                                            $late_time = \Carbon\Carbon::parse($attendance->check_in)->diffInMinutes($check_in_time);
                                                        }
                                                    @endphp
                                                    @if($late_time > 0)
                                                        +{{$late_time}}
                                                    @endif
                                                @endif
                                                @if($attendance->status == 'on_leave')
                                                    @php
                                                        $leave = App\Models\Leave::leftjoin('leave_types', 'leave_type_id','leave_types.id')
                                                                                ->where('employee_id', $attendance->employee_id)
                                                                                ->where('start_date', '>=', $attendance->date)
                                                                                ->where('start_date', '<=', $attendance->date)
                                                                                ->select('leave_types.name')
                                                                                ->first()
                                                    @endphp
                                                    @if(!empty($leave))
                                                        {{$leave->name}}
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                {{ucfirst($attendance->created_by)}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

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

</script>
@endsection
