{{--@livewire('add-stock.add-payment')--}}
<section class="">
    <div class="col-md-22">
        <div class="card mt-3">
            <div class="card-header d-flex align-items-center">
                <h3 class="print-title">@lang('lang.stock')</h3>
            </div>
            {{-- ++++++++++++++++++++++++++++++ Filters +++++++++++++++++++++++ --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="container-fluid">
                        @include('add-stock.partials.filters')
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table dataTable">
                        <thead>
                        <tr>
                            <th>@lang('lang.po_ref_no')</th>
                            <th>@lang('lang.invoice_no')</th>
                            <th>@lang('lang.date_and_time')</th>
                            <th>@lang('lang.invoice_date')</th>
                            <th>@lang('lang.supplier')</th>
                            <th>@lang('lang.products')</th>
                            <th>@lang('lang.created_by')</th>
                            <th class="sum">@lang('lang.value')</th>
                            <th class="sum">@lang('lang.paid_amount')</th>
                            <th class="sum">@lang('lang.pending_amount')</th>
                            <th>@lang('lang.due_date')</th>
                            <th>@lang('lang.notes')</th>
                            <th class="notexport">@lang('lang.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stocks as $index => $stock)
                            <tr>
                                <td>{{$stock->po_no ?? ''}}</td>
                                <td>{{$stock->invoice_no ?? ''}}</td>
                                <td>{{$stock->created_at }}</td>
                                <td>{{$stock->transaction_date }}</td>
                                <td>{{$stock->supplier->name??''}}</td>
                                <td>
                                    @if(!empty($stock->add_stock_lines))
                                        @foreach($stock->add_stock_lines as $stock_line)
                                            {{ $stock_line->product->name ?? '' }}<br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{$stock->created_by_relationship->first()->name}}</td>
                                @if($stock->transaction_currency == 2)
                                    <td>{{number_format($stock->dollar_final_total,num_of_digital_numbers())}}</td>
                                @else
                                    <td>{{number_format($stock->final_total,num_of_digital_numbers())}}</td>
                                @endif
                                <td>
                                    {{$this->calculatePaidAmount($stock->id)}}
                                </td>
                                <td>{{$this->calculatePendingAmount($stock->id)}}</td>
                                <td>{{$stock->due_date ?? ''}}</td>
                                <td>{{$stock->notes ?? ''}}</td>
                                <td>
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        @lang('lang.action')
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                        <li>
                                            <a href="{{route('stocks.show', $stock->id)}}"
                                               class="btn"><i
                                                    class="fa fa-eye"></i>
                                                @lang('lang.view') </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="{{route('stocks.edit', $stock->id)}}"
                                               class="btn"><i
                                                    class="fa fa-edit"></i>
                                                @lang('lang.edit') </a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a data-href="{{route('stocks.delete', $stock->id)}}"
                                               {{-- data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}" --}}
                                               class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                @lang('lang.delete')</a>
                                        </li>
                                        @if ($stock->payment_status != 'paid')
                                        <li class="divider"></li>
                                       <li>
                                           <a data-href="{{route('stocks.addPayment', $stock->id)}}" data-container=".view_modal"
                                              class="btn btn-modal">
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

    <!-- add Payment Modal -->
{{--    @include('add-stock.partials.add-payment')--}}

</section>
<div class="view_modal no-print" ></div>
@push('javascripts')
    <script>
        window.addEventListener('openAddPaymentModal', event => {
            $("#addPayment").modal('show');
        })

        window.addEventListener('closeAddPaymentModal', event => {
            $("#addPayment").modal('hide');
        })
    </script>
@endpush
