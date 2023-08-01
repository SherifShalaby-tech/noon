
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header d-flex align-items-center">

                        @if (!empty($is_raw_material))
                            <h4>@lang('lang.add_stock_for_raw_material')</h4>
                        @else
                            <h4>@lang('lang.add-stock')</h4>
                        @endif
                    </div>
                    <div class="row ">
                        <div class="col-md-9">
                            <p class="italic pt-3 pl-3"><small>@lang('lang.required_fields_info')</small></p>
                        </div>
                        <div class="col-md-3">
{{--                            <div class="i-checks">--}}
{{--                                <input id="clear_all_input_form" name="clear_all_input_form"--}}
{{--                                       type="checkbox" @if (isset($clear_all_input_stock_form ) || $clear_all_input_stock_form == '1') checked @endif--}}
{{--                                       class="form-control-custom">--}}
{{--                                <label for="clear_all_input_form">--}}
{{--                                    <strong>--}}
{{--                                        @lang('lang.clear_all_input_form')--}}
{{--                                    </strong>--}}
{{--                                </label>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    {!! Form::open([ 'id' => 'add_stock_form', 'enctype' => 'multipart/form-data']) !!}
                    <input type="hidden" name="batch_count" id="batch_count" value="0">
                    <input type="hidden" name="row_count" id="row_count" value="0">
                    <input type="hidden" name="is_raw_material" id="is_raw_material" value="{{ $is_raw_material }}">
                    <input type="hidden" name="is_add_stock" id="is_add_stock" value="1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('store_id', __('lang.store') . ':*', []) !!}
                                {!! Form::select('store_id', $stores, !empty($recent_stock)&&!empty($recent_stock->store_id)?$recent_stock->store_id:session('user.store_id'), ['class' => 'select form-control', 'data-live-search' => 'true', 'required', 'placeholder' => __('lang.please_select'), 'wire:model' => 'store_id']) !!}
                            </div>
{{--                            <div class="col-md-3">--}}
{{--                                {!! Form::label('supplier_id', __('lang.supplier') . ':*', []) !!}--}}
{{--                                {!! Form::select('supplier_id', $suppliers, !empty($recent_stock)&&!empty($recent_stock->supplier_id)?$recent_stock->supplier_id:array_key_first($suppliers), ['class' => 'select form-control', 'data-live-search' => 'true',  'placeholder' => __('lang.please_select')]) !!}--}}
{{--                            </div>--}}
                            <div class="col-md-3">
                                {!! Form::label('status', __('lang.status') . ':*', []) !!}
                                {!! Form::select('status', ['received' =>  __('lang.received'), 'partially_received' => __('lang.partially_received')], !empty($recent_stock)&&!empty($recent_stock->status)?$recent_stock->status: 'Please Select', ['class' => 'select form-control', 'data-live-search' => 'true', 'required',  'placeholder' => __('lang.please_select'),'wire:model' => 'status']) !!}
                            </div>
                            <div class="col-md-3">
                                <label for="currency_id">@lang('lang.currency') .*</label>
                                {!! Form::select(
                                    'currency_id',
                                    !empty($settings['currency']) ? $selected_currencies:[],null,
                                    ['class' => 'form-control select ','placeholder'=>__('lang.please_select'),'required']
                                ) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('transaction_date', __('lang.date_and_time'), []) !!}
                                <input type="datetime-local" wire:model="transaction_date"
                                       value="{{ date('Y-m-d\TH:i') }}" class="form-control">
                            </div>
                            <div class="col-md-3">
                                {{$purchase_type ?? 0}}
                                {!! Form::label('purchase_type', __('lang.purchase_type') . ':*', []) !!}
                                {!! Form::select('purchase_type', ['import' =>  __('lang.import'), 'local' => __('lang.local')], !empty($recent_stock)&&!empty($recent_stock->status)?$recent_stock->status: 'Please Select', ['class' => 'select form-control', 'data-live-search' => 'true', 'required',  'placeholder' => __('lang.please_select'), 'wire:model' => 'purchase_type']) !!}
                            </div>
                            <div class="col-md-3">
                                {{$divide_costs ?? 0}}
                                {!! Form::label('divide_costs', __('lang.divide_costs') . ':*', []) !!}
                                {!! Form::select('divide_costs', ['size' =>  __('lang.size'), 'weight' => __('lang.weight'), 'price' => __('lang.price')], 'Please Select', ['class' => 'select form-control', 'data-live-search' => 'true', 'required',  'placeholder' => __('lang.please_select'), 'wire:model' => 'divide_costs']) !!}
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-8 offset-md-1">
{{--                                <div class="search-box input-group">--}}
{{--                                    <button type="button" class="btn btn-secondary btn-lg" id="search_button"><i--}}
{{--                                            class="fa fa-search"></i></button>--}}
{{--                                    <input type="text" name="search_product" id="search_product"--}}
{{--                                           placeholder="@lang('lang.enter_product_name_to_print_labels')"--}}
{{--                                           class="form-control ui-autocomplete-input" autocomplete="off">--}}
{{--                                    <button type="button" class="btn btn-success btn-lg btn-modal"--}}
{{--                                            data-href="{{ route('products.create') }}?quick_add=1"--}}
{{--                                            data-container=".view_modal"><i class="fa fa-plus"></i></button>--}}
{{--                                </div>--}}
                            </div>
                            <div class="col-md-2">
                                @include('quotation.partials.product_selection')
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered m-0">
                                    <thead>
                                    <tr>
                                        <th>#</th>
{{--                                        <th style="width: 7%" class="col-sm-8">@lang( 'lang.image' )</th>--}}
                                        <th style="width: 10%" class="col-sm-8">@lang( 'lang.products' )</th>
                                        <th style="width: 10%" class="col-sm-4">@lang( 'lang.sku' )</th>
                                        <th style="width: 10%" class="col-sm-4">@lang( 'lang.quantity' )</th>
                                        <th style="width: 10%" class="col-sm-4">@lang( 'lang.unit' )</th>
                                        <th style="width: 10%" class="col-sm-4">@lang( 'lang.fill' )</th>
                                        <th style="width: 10%" class="col-sm-4">@lang( 'lang.total_quantity' )</th>
                                        <th style="width: 10%" class="col-sm-4">@lang( 'lang.purchase_price' ) (@lang('lang.per_piece'))</th>
                                        <th style="width: 10%" class="col-sm-4">@lang( 'lang.selling_price' )</th>
                                        <th style="width: 10%" class="col-sm-4">@lang( 'lang.sub_total' )</th>
                                        <th style="width: 10%" class="col-sm-4"> @lang('lang.size') </th>
                                        <th style="width: 10%" class="col-sm-4"> @lang('lang.total_size') </th>
                                        <th style="width: 10%" class="col-sm-4"> @lang('lang.weight') </th>
                                        <th style="width: 10%" class="col-sm-4"> @lang('lang.total_weight') </th>
                                        <th style="width: 10%" class="col-sm-4"> @lang('lang.cost') (@lang('lang.per_piece')) </th>
                                        <th style="width: 10%" class="col-sm-4"> @lang('lang.total_cost') </th>
                                        <th style="width: 10%" class="col-sm-4">@lang( 'lang.new_stock' )</th>
                                        <th style="width: 10%" class="col-sm-4">@lang( 'lang.change_current_stock' )</th>
                                        <th style="width: 10%" class="col-sm-4">@lang( 'lang.action' )</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($selectedProductData) && !empty($selectedProducts) )
                                        @foreach($selectedProductData  as $index => $product)
                                            @include('add-stock.partials.product_row')
                                        @endforeach
                                        <tr >
                                            <td colspan="9" style="text-align: right"> @lang('lang.total')</td>
                                            <td> {{array_sum($sub_total)}} </td>
                                            <td></td>
                                            <td style="width: 10%">
                                                {{$this->sum_size() ?? 0}}
                                            </td>
                                            <td></td>
                                            <td  style="width: 10%;">
                                                {{$this->sum_weight() ?? 0}}
                                            </td>
                                            <td></td>
                                            <td  style="width: 10%;">
                                                {{array_sum($total_cost) ?? 0}}
                                            </td>

                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 text-center mt-1 ">
                            <h4>@lang('lang.items_count'):
                                <span class="items_count_span" style="margin-right: 15px;">{{count($selectedProductData)}}</span>
                                <br> @lang('lang.items_quantity'): <span
                                    class="items_quantity_span" style="margin-right: 15px;">{{array_sum($quantity)}}</span>
                            </h4>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <div class="col-md-3 offset-md-8 text-right">
                                <h3> @lang('lang.total') : {{array_sum($total_cost)}} <span class="final_total_span"></span> </h3>
                                <input type="hidden" name="grand_total" id="grand_total" value="0">
                                <input type="hidden" name="final_total" id="final_total" value="0">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('files', __('lang.files'), []) !!} <br>
                                    <input type="file" name="files[]" id="files" multiple>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('invoice_no', __('lang.invoice_no'), []) !!} <br>
                                    {!! Form::text('invoice_no', !empty($recent_stock)&&!empty($recent_stock->invoice_no)?$recent_stock->invoice_no:null, ['class' => 'form-control', 'placeholder' => __('lang.invoice_no'),'wire:model' => 'invoice_no']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{$other_expenses}}
                                    {!! Form::label('other_expenses', __('lang.other_expenses'), []) !!} <br>
                                    {!! Form::text('other_expenses', !empty($recent_stock)&&!empty($recent_stock->other_expenses)?@num_format($recent_stock->other_expenses):null, ['class' => 'form-control', 'placeholder' => __('lang.other_expenses'), 'id' => 'other_expenses', 'wire:model' => 'other_expenses']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('discount_amount', __('lang.discount'), []) !!} <br>
                                    {!! Form::text('discount_amount', !empty($recent_stock)&&!empty($recent_stock->discount_amount)?@num_format($recent_stock->discount_amount):null, ['class' => 'form-control', 'placeholder' => __('lang.discount'), 'id' => 'discount_amount','wire:model' => 'discount_amount']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {{$other_payments}}
                                    {!! Form::label('other_payments', __('lang.other_payments'), []) !!} <br>
                                    {!! Form::text('other_payments', !empty($recent_stock)&&!empty($recent_stock->other_payments)?@num_format($recent_stock->other_payments):null, ['class' => 'form-control', 'placeholder' => __('lang.other_payments'), 'id' => 'other_payments', 'wire:model' => 'other_payments']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('source_type', __('lang.source_type'), []) !!} <br>
                                    {!! Form::select('source_type', ['user' => __('lang.user'), 'pos' => __('lang.pos'), 'store' => __('lang.store'), 'safe' => __('lang.safe')], !empty($recent_stock)&&!empty($recent_stock->source_type)?$recent_stock->source_type: 'Please Select', ['class' => 'select  form-control', 'data-live-search' => 'true',  'placeholder' => __('lang.please_select'),'wire:model' => 'source_type']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('source_of_payment', __('lang.source_of_payment'), []) !!} <br>
                                    {!! Form::select('source_id', $users, null, ['class' => 'select form-control', 'data-live-search' => 'true',  'placeholder' => __('lang.please_select'), 'id' => 'source_id', 'required']) !!}
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('payment_status', __('lang.payment_status') . ':*', []) !!}
                                    {!! Form::select('payment_status', $payment_status_array, !empty($recent_stock)&&!empty($recent_stock->payment_status)?$recent_stock->payment_status:'paid', ['class' => 'select form-control', 'data-live-search' => 'true', 'required',  'placeholder' => __('lang.please_select'),'wire:model' => 'payment_status']) !!}
                                </div>
                            </div>

                            @include('add-stock.partials.payment_form')

                            <div class="col-md-3 due_amount_div d-none">
                                <div class="form-group">
                                    <label for="due_amount">@lang('lang.due'): </label>
                                    <input class="form-control" placeholder="@lang('lang.due')" name="due_date" type="text" id="due_date" autocomplete="off" fdprocessedid="pipnea">
                                </div>
                            </div>

                            <div class="col-md-3 due_fields d-none">
                                <div class="form-group">
                                    {!! Form::label('due_date', __('lang.due_date') . ':', []) !!} <br>
                                    {!! Form::text('due_date', !empty($transaction_payment)&&!empty($transaction_payment->due_date)?@format_date($transaction_payment->due_date):(!empty($payment) ? @format_date($payment->due_date) : null), ['class' => 'form-control', 'placeholder' => __('lang.due_date')]) !!}
                                </div>
                            </div>

                            <div class="col-md-3 due_fields d-none">
                                <div class="form-group">
                                    {!! Form::label('notify_before_days', __('lang.notify_before_days') . ':', []) !!}
                                    <br>
                                    {!! Form::text('notify_before_days', !empty($transaction_payment)&&!empty($transaction_payment->notify_before_days)?$transaction_payment->notify_before_days:(!empty($payment) ? $payment->notify_before_days : null), ['class' => 'form-control', 'placeholder' => __('lang.notify_before_days')]) !!}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('notes', __('lang.notes') . ':', []) !!} <br>
                                    {!! Form::textarea('notes', !empty($recent_stock)&&!empty($recent_stock->notes)?$recent_stock->notes:null, ['class' => 'form-control', 'rows' => 3]) !!}
                                </div>
                            </div>

                        </div>


                    </div>
                    {!! Form::close() !!}
                    <div class="col-sm-12">
                        <button type="submit" name="submit" id="submit-save" style="margin: 10px" value="save"
                                class="btn btn-primary pull-right btn-flat submit" wire:click.prevent = "store()">@lang( 'lang.save' )</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('javascripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', (message, component) => {
            if (message.updateQueue && message.updateQueue.some(item => item.payload.event === 'updated:selectedProducts')) {
                $('.product_selected').on('click', function (event) {
                    event.stopPropagation();
                    var value = $(this).prop('checked');
                    var productId = $(this).val();
                    Livewire.find(component.fingerprint).set('selectedProducts.' + productId, value);
                });
            }
        });
    });
    document.addEventListener('livewire:load', function () {
        Livewire.on('closeModal', function () {
            // Close the modal using Bootstrap's modal API
            $('#select_products_modal').modal('hide');
        });
    });
    // $(document).ready(function () {
    //     $('#dtHorizontalExample').DataTable({
    //         "scrollX": true,
    //         "searching": false,
    //         "paging":   false,
    //         "ordering": false,
    //     });
    //     $('.dataTables_length').addClass('bs-select');
    //     document.getElementById("dtHorizontalExample_wrapper").style.width = "100%";
    // });

</script>
@endpush
