@extends('layouts.app')
@section('title', __('lang.show_customer_price_offer'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.customer_price_offer')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
{{--                        <li class="breadcrumb-item"><a href="#">@lang('lang.employees')</a></li>--}}
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.customer_price_offer')</li>
                    </ol>
                </div>
            </div>
            {{-- +++++++++++++++++++ "انشاء عرض سعر للعميل" +++++++++++++++++++ --}}
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    {{-- ++++++++++++++++++++ create purchase_order ++++++++++++ --}}
                    <a href="{{route('customer_price_offer.create')}}" class="btn btn-primary" target="__blank">
                        @lang('lang.create_customer_price_offer')
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <livewire:customer-price-offer.index />
@endsection

