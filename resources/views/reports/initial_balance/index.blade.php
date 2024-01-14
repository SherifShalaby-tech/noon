@extends('layouts.app')
@section('title', __('lang.initial_balance'))
@section('breadcrumbbar')
    <style>
        .table-top-head {
            top: 200px !important;
        }

        .table-scroll-wrapper {
            width: fit-content;
        }

        @media(min-width:1900px) {
            .table-scroll-wrapper {
                width: 100%;
            }
        }

        .rightbar {
            z-index: 2;
        }


        @media(max-width:991px) {
            .table-top-head {
                top: 200px !important
            }
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 310px !important
            }
        }

        .wrapper1 {
            margin-top: 15px;
        }

        .input-wrapper {
            width: 100% !important;
        }

        @media(max-width:767px) {
            .wrapper1 {
                margin-top: 115px;
            }

            .input-wrapper {
                width: 60%
            }
        }
    </style>
    <div class="animate-in-page">
        <div class="breadcrumbbar m-0 px-3 py-0">
            <div
                class="d-flex align-items-center justify-content-between @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div>
                    <h4 class="page-title @if (app()->isLocale('ar')) text-end @else text-start @endif">
                        @lang('lang.initial_balance')</h4>
                    <div class="breadcrumb-list">
                        <ul style=" list-style: none;"
                            class="breadcrumb m-0 p-0  d-flex @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7"
                                    href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif"><a
                                    style="text-decoration: none;color: #596fd7"
                                    href="{{ route('initial-balance.create') }}">@lang('lang.reports')</a>
                            </li>
                            <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active"
                                aria-current="page">@lang('lang.initial_balance')</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="animate-in-page">
        <section class="mb-0">
            <div class="col-md-22">
                <div class="card mt-1 mb-0">
                    <div
                        class="card-header d-flex align-items-center @if (app()->isLocale('ar')) justify-content-end @else justify-content-start @endif">
                        <h6 class="print-title ">
                            @lang('lang.initial_balance')</h6>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="container-fluid">
                                @include('reports.initial_balance.filters')
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div1"></div>
                        </div>
                        <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                            <div class="div2 table-scroll-wrapper">
                                <!-- content goes here -->
                                <div style="min-width: 1800px;max-height: 90vh;overflow: auto">
                                    <table id="datatable-buttons"
                                        class="table dataTable  table-hover table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>@lang('lang.date_and_time')</th>
                                                <th>@lang('lang.product')</th>
                                                <th>@lang('lang.supplier')</th>
                                                <th>@lang('lang.created_by')</th>
                                                <th class="notexport">@lang('lang.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($stocks as $index => $stock)
                                                <tr>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.date_and_time')">
                                                            {{ $stock->created_at }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.product')">

                                                            {{ $stock->add_stock_lines->first()->product->name ?? '' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.supplier')">

                                                            {{ $stock->supplier->name ?? '' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="custom-tooltip d-flex justify-content-center align-items-center"
                                                            style="font-size: 12px;font-weight: 600"
                                                            data-tooltip="@lang('lang.created_by')">

                                                            {{ $stock->created_by_relationship->name }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button type="button" style="font-size: 12px;font-weight: 600"
                                                            class="btn btn-default btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            @lang('lang.action')
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu">
                                                            <li>
                                                                <a href="{{ route('initial-balance.show', $stock->id) }}"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                        class="fa fa-eye"></i>
                                                                    @lang('lang.view') </a>
                                                            </li>

                                                            <li>
                                                                <a href="{{ route('initial-balance.edit', $stock->id) }}"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"><i
                                                                        class="fa fa-edit"></i>
                                                                    @lang('lang.edit') </a>
                                                            </li>

                                                            <li>
                                                                <a data-href="{{ route('initial-balance.destroy', $stock->id) }}"
                                                                    data-check_password="{{ route('check_password', Auth::user()->id) }}"
                                                                    class="btn drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif delete_item"
                                                                    data-deletetype="1"><i class="fa fa-trash"></i>
                                                                    @lang('lang.delete')</a>
                                                            </li>
                                                            @if (!empty($stock->payment_status) && $stock->payment_status != 'paid')
                                                                <li>
                                                                    <a data-href="{{ route('stocks.addPayment', $stock->id) }}"
                                                                        data-container=".view_modal"
                                                                        class="btn btn-modal drop_down_item @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                                                                        <i class="fa fa-money"></i>
                                                                        @lang('lang.pay')
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- add Payment Modal -->
            {{--    @include('add-stock.partials.add-payment') --}}

        </section>
    </div>

    <div class="view_modal no-print"></div>
@endsection
@push('javascripts')
    <script src="{{ asset('js/product/product.js') }}"></script>
    <script>
        window.addEventListener('openAddPaymentModal', event => {
            $("#addPayment").modal('show');
        })
        window.addEventListener('closeAddPaymentModal', event => {
            $("#addPayment").modal('hide');
        })
        $(document).ready(function() {
            $('select').on('change', function(e) {
                var name = $(this).data('name');
                var index = $(this).data('index');
                var select2 = $(this); // Save a reference to $(this)
                Livewire.emit('listenerReferenceHere', {
                    var1: name,
                    var2: select2.select2("val"),
                    var3: index
                });
            });
        });
    </script>
@endpush
