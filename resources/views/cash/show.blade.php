@extends('layouts.app')
@section('title', __('lang.view_details'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.view_details')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{url('/')}}">@lang('lang.dashboard')</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.cash')</li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.view_details')</li>
                    </ol>
                </div>
            </div>
   </div>
@endsection
@section('content')
     <!-- End Breadcrumbbar -->
    <!-- Start Contentbar -->
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="print-title">@lang('lang.cash')</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="modal-title">@lang( 'lang.cash_details' )</h4>
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <td><b>@lang('lang.date_and_time')</b></td>
                                    <td>{{ @format_datetime($cash_register->created_at) }}</td>
                                </tr>
                                <tr>
                                    <td><b>@lang('lang.cash_in')</b></td>
                                    <td>{{ @num_format($cash_register->total_cash_in) }}</td>
                                </tr>
                                <tr>
                                    <td><b>@lang('lang.cash_out')</b></td>
                                    <td>{{ @num_format($cash_register->total_cash_out) }}</td>
                                </tr>
                                <tr>
                                    <td><b>@lang('lang.total_sales')</b></td>
                                    <td>{{ @num_format($cash_register->total_sale - $cash_register->total_refund) }}</td>
                                </tr>
                                <tr>
                                    <td><b>@lang('lang.total_cash_sale')</b></td>
                                    <td>{{ @num_format($cash_register->total_cash_sales) }}
                                    </td>
                                </tr>
                                @if(session('system_mode') == 'restaurant')
                                <tr>
                                    <td><b>@lang('lang.dining_in')</b></td>
                                    <td>{{ @num_format($cash_register->total_dining_in) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td><b>@lang('lang.total_card_sale')</b></td>
                                    <td>{{ @num_format($cash_register->total_card_sales) }}</td>
                                </tr>
                                <tr>
                                    <td><b>@lang('lang.total_cheque_sale')</b></td>
                                    <td>{{ @num_format($cash_register->total_cheque_sales) }}</td>
                                </tr>
                                <tr>
                                    <td><b>@lang('lang.total_bank_transfer_sale')</b></td>
                                    <td>{{ @num_format($cash_register->total_bank_transfer_sales) }}</td>
                                </tr>
                                <tr>
                                    <td><b>@lang('lang.total_gift_card_sale')</b></td>
                                    <td>{{ @num_format($cash_register->total_gift_card_sales) }}</td>
                                </tr>
                                <tr>
                                    <td><b>@lang('lang.return_sales')</b></td>
                                    <td>{{ @num_format($cash_register->total_sell_return) }}</td>
                                </tr>
                                <tr>
                                    <td><b>@lang('lang.purchases')</b></td>
                                    <td>{{ @num_format($cash_register->total_purchases) }}</td>
                                </tr>
                                <tr>
                                    <td><b>@lang('lang.expenses')</b></td>
                                    <td>{{ @num_format($cash_register->total_expenses) }}</td>
                                </tr>
                                <tr>
                                    <td><b>@lang('lang.wages_and_compensation')</b></td>
                                    <td>{{ @num_format($cash_register->total_wages_and_compensation) }}</td>
                                </tr>
                                <tr>
                                    <td><b>@lang('lang.current_cash')</b></td>
                                    <td>{{ @num_format($cash_register->total_cash_sales +$cash_register->total_cash_in -$cash_register->total_cash_out -$cash_register->total_purchases -$cash_register->total_expenses -$cash_register->total_wages_and_compensation -$cash_register->total_sell_return) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <input type="hidden" name="cash_register_id" value="{{ $cash_register->id }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
