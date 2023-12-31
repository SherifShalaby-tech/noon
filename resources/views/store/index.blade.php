@extends('layouts.app')
@section('title', __('lang.stores'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.stores')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="#">@lang('lang.settings')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.stores')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add-store" href="{{route('store.create')}}">@lang('lang.add_store')</button>
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
                    <h4 class="print-title">@lang('lang.stores')</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table dataTable">
                            <thead>
                            <tr>
                                <th>@lang('lang.name')</th>
                                <th>@lang('lang.branch')</th>
                                <th>@lang('lang.phone_number')</th>
                                <th>@lang('lang.email')</th>
                                <th>@lang('lang.manager_name')</th>
                                <th>@lang('lang.manager_mobile_number')</th>
                                <th class="notexport">@lang('lang.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stores as $store)
                                <tr>
                                    <td>{{$store->name}}</td>
                                    <td>{{!empty($store->branch) ? $store->branch->name : ''}}</td>
                                    <td>{{$store->phone_number}}</td>
                                    <td>{{$store->email}}</td>
                                    <td>{{$store->manager_name}}</td>
                                    <td>{{$store->manager_mobile_number}}</td>
                                    <td class="no-print">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات                                            <span class="caret"></span></button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <li>
                                                    <a data-href="{{route('store.edit', $store->id)}}"
                                                       data-container=".view_modal" class="btn btn-modal"><i
                                                            class="dripicons-document-edit"></i> @lang('lang.edit')</a>                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a data-href="{{route('store.destroy', $store->id)}}"
{{--                                                       data-check_password="{{action('UserController@checkPassword', Auth::user()->id) }}"--}}
                                                       class="btn delete_item text-red delete_item"><i
                                                            class="fa fa-trash"></i>
                                                        @lang('lang.delete')</a>
                                                </li>
                                            </ul>
                                        </div>
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
     @include('store.create')
@endsection
<div class="view_modal no-print" ></div>
