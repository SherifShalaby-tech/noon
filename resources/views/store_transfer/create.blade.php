@extends('layouts.app')
@section('title', __('lang.add_transfer'))
@push('css')
    <!-- Main Faile Css  -->
    <link rel="stylesheet" href="{{ asset('salescreen/css/main.css')}}" />
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.add_transfer')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="">@lang('lang.store_transfer')</a></li>
                        <li class="breadcrumb-item active" aria-current="page"></li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <div class="widgetbar">
                        <a type="button" class="btn btn-primary" href="{{route('store_transfer.index')}}">@lang('lang.store_transfer')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @livewire('store-transfer.create')
@endsection
@push('javascripts')
@endpush
