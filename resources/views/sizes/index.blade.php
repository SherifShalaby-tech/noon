@extends('layouts.app')
@section('title', __('sizes.sizes'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('sizes.sizes')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('sizes.sizes')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
                        <i class="fa fa-plus"></i> {{ __('Add') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('sizes.create')
@endsection
@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('sizes.sizes')</h5>
                    </div>
                    <div class="card-body">
                        @if (@isset($sizes) && !@empty($sizes) && count($sizes) > 0 )
                            <div class="table-responsive">
                                <table  class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('sizes.sizename')</th>
                                            <th>@lang('added_by')</th>
                                            <th>@lang('updated_by')</th>
                                            <th>@lang('action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sizes as $index=>$size)
                                            <tr>
                                                <td>{{ $index+1 }}</td>
                                                <td>{{ $size->name }}</td>
                                                <td>
                                                    @if ($size->user_id  > 0 and $size->user_id != null)
                                                        {{ $size->created_at->diffForHumans() }} <br>
                                                        {{ $size->created_at->format('Y-m-d') }}
                                                        ({{ $size->created_at->format('h:i') }})
                                                        {{ ($size->created_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                        {{ $size->createBy?->name }}
                                                    @else
                                                    {{ __('no_update') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($size->last_update  > 0 and $size->last_update != null)
                                                        {{ $size->updated_at->diffForHumans() }} <br>
                                                        {{ $size->updated_at->format('Y-m-d') }}
                                                        ({{ $size->updated_at->format('h:i') }})
                                                        {{ ($size->updated_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                        {{ $size->updateBy?->name }}
                                                    @else
                                                    {{ __('no_update') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @include('sizes.action')
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <tfoot>
                                    <tr>
                                        <th colspan="12">
                                            <div class="float-right">
                                                {!! $sizes->appends(request()->all())->links() !!}
                                            </div>
                                        </th>
                                    </tr>
                                </tfoot>
                            </div>
                        @else
                        <div class="alert alert-danger">
                            {{ __('categories.data_no_found') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
