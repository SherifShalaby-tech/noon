@extends('layouts.app')
@section('title', __('lang.plans'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.plans')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        @if((request()->segment(2).'/'.request()->segment(3)) == "representative/plan")
                            <li class="breadcrumb-item active"><a href="{{ route('representatives.index') }}">@lang('lang.representatives')</a></li>
                        @else
                        <li class="breadcrumb-item active"><a href="#">@lang('lang.delivery')</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.plans')</li>
                    </ol>
                </div>
            </div>
             <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    @if((request()->segment(2).'/'.request()->segment(3)) == "representative/plan")
                        <a class="btn btn-primary" href="{{ route('representatives.plansList') }}">@lang('lang.show_plans')</a>
                    @else

                        <a class="btn btn-primary" href="{{route('delivery_plan.plansList')}}">@lang('lang.show_plans')</a>
                    @endif
                 </div>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="col-md-12  no-print">
            <div class="card mt-3">
                <div class="card-header d-flex align-items-center">
                    <h4 class="print-title">@lang('lang.delivery')</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                            <tr>
                                <th>@lang('lang.profile_photo')</th>
                                <th>@lang('lang.employee_name')</th>
                                <th>@lang('lang.email')</th>
                                <th>@lang('lang.phone_number')</th>
                                <th>@lang('lang.stores')</th>
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                            </thead>
                            <tbody>

                                @foreach($delivery_men as $key => $employee)
                                    <tr>
                                        <td>
                                            @if (!empty($employee->photo))
                                                <img src="{{"/uploads/". $employee->photo}}" alt="photo" width="50" height="50">
                                            @else
                                                <img src="{{"/uploads/". session('logo')}}" alt="photo" width="50" height="50">
                                            @endif
                                        </td>
                                        <td>
                                            {{!empty($employee->user) ? $employee->user->name : ''}}
                                        </td>
                                        <td>
                                            {{!empty($employee->user) ? $employee->user->email : ''}}
                                        </td>
                                        <td>
                                            {{$employee->mobile}}
                                        </td>
                                        <td>
                                            @foreach($employee->stores()->get() as $store)
                                                {{$store->name}}
                                            @endforeach
                                        </td>
                                        <td>
                                             <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                                     aria-haspopup="true" aria-expanded="false">
                                                 @lang('lang.action')
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                                <li>
                                                    <a href="{{route('delivery.create', $employee->id)}}"
                                                       class="btn"><i
                                                            class="fa fa-pencil-square-o"></i>
                                                         @lang('lang.add_plan') </a>
                                                </li>
                                                <li class="divider"></li>

                                            </ul>
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


@endsection

