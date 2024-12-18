<section class="app my-3 no-print" style="margin-top: 35px!important;">
    <div class="" >
        {!! Form::open(['route' => 'pos.store','method'=>'post' ]) !!}
        <div class="row">
            <div class="col-sm-3">
                <div class="row">
                    {{-- +++++++++++ brand filter +++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('brand_id', __('lang.brand') . ':*', []) !!}
                            {!! Form::select('brand_id', $brands, $brand_id,
                            ['class' => 'select2 form-control', 'data-live-search' => 'true','id'=>'brand_id', 'required', 'placeholder' => __('lang.please_select'),
                             'data-name' => 'brand_id','wire:model' => 'brand_id']) !!}
                            @error('brand_id')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- +++++++++++ from_a_to_z , from_z_to_a filter +++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('alphabetical_order_id', __('lang.alphabetical_order') . ':*', []) !!}
                            {!! Form::select(
                                'alphabetical_order_id',
                                [ __('lang.from_a_to_z'), __('lang.from_z_to_a')],
                                    $alphabetical_order_id,
                                    [
                                        'class' => 'select2 form-control',
                                        'data-live-search' => 'true',
                                        'id' => 'alphabetical_order_id',
                                        'required',
                                        'placeholder' => __('lang.please_select'),
                                        'data-name' => 'alphabetical_order_id',
                                        'wire:model' => 'alphabetical_order_id',
                                    ]
                            ) !!}
                            @error('alphabetical_order_id')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- +++++++++++ lowest_price , highest_price filter +++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('price_order_id', __('lang.price') . ':*', []) !!}
                            {!! Form::select(
                                'price_order_id',
                                [ __('lang.lowest_price'), __('lang.highest_price')],
                                $price_order_id,
                                [
                                    'class' => 'select2 form-control',
                                    'data-live-search' => 'true',
                                    'id' => 'price_order_id',
                                    'required',
                                    'placeholder' => __('lang.please_select'),
                                    'data-name' => 'price_order_id',
                                    'wire:model' => 'price_order_id',
                                ]
                            ) !!}
                            @error('price_order_id')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- +++++++++++ dollar_lowest_price , dollar_highest_price filter +++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('dollar_price_order_id', __('lang.dollar_price') . ':*', []) !!}
                            {!! Form::select(
                                'dollar_price_order_id',
                                [ __('lang.dollar_lowest_price'), __('lang.dollar_highest_price')],
                                $dollar_price_order_id,
                                [
                                    'class' => 'select2 form-control',
                                    'data-live-search' => 'true',
                                    'id' => 'dollar_price_order_id',
                                    'required',
                                    'placeholder' => __('lang.please_select'),
                                    'data-name' => 'dollar_price_order_id',
                                    'wire:model' => 'dollar_price_order_id',
                                ]
                            ) !!}
                            @error('dollar_price_order_id')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- +++++++++++ nearest_expiry , longest_expiry filter +++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('expiry_order_id', __('lang.expiry_order') . ':*', []) !!}
                            {!! Form::select(
                                'expiry_order_id',
                                [ __('lang.nearest_expiry_filter') , __('lang.longest_expiry_filter')],
                                $expiry_order_id,
                                [
                                    'class' => 'select2 form-control',
                                    'data-live-search' => 'true',
                                    'id' => 'expiry_order_id',
                                    'required',
                                    'placeholder' => __('lang.please_select'),
                                    'data-name' => 'expiry_order_id',
                                    'wire:model' => 'expiry_order_id',
                                ]
                            ) !!}
                            @error('expiry_order_id')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="row">
                    {{-- ++++++++++++++++++++++ مخزن ++++++++++++++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('store_id', __('lang.store') . ':*', []) !!}
                            {!! Form::select('store_id', $stores ?? [], $store_id,
                            ['class' => 'select2 form-control', 'data-live-search' => 'true','id'=>'store_id', 'required', 'placeholder' => __('lang.please_select'),
                             'data-name' => 'store_id','wire:model' => 'store_id', 'wire:change' => 'changeAllProducts']) !!}
                            @error('store_id')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- ++++++++++++++++++++++ نقاط البيع +++++++++++++++++++++ --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('store_pos_id', __('lang.pos') . ':*', []) !!}
                            {!! Form::select('store_pos_id', $store_pos, $store_pos_id, ['class' => 'select2 form-control','data-name'=>'store_pos_id', 'data-live-search' => 'true', 'required', 'placeholder' => __('lang.please_select'), 'wire:model' => 'store_pos_id']) !!}
                            @error('store_pos_id')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- +++++++++++++++++ Customers Dropdown +++++++++++++++++ --}}
                    @if(empty($toggle_suppliers))
                    <div class="col-md-4">
                        <label for="" class="text-primary">العملاء</label>
                        <div class="d-flex justify-content-center">

                            <select class="form-control client select2" wire:model="client_id" id="client_id" data-name="client_id" required>
                                <option  value="0 " readonly >اختر </option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{$client_id==$customer->id?'selected':''}}> {{ $customer->name }} - {{($customer->phone != '[null]' ) ? $customer->phone : ''}}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-sm ml-2 text-white" style="background-color: #6e81dc;" data-toggle="modal" data-target="#add_customer"><i class="fas fa-plus"></i></button>
                        </div>
                        @error('client_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @endif
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('invoice_status', __('lang.invoice') . ':*', []) !!}
                            {!! Form::select('invoice_status', ['monetary' => __('lang.monetary') , 'deferred_time' => __('lang.deferred_time')], $invoice_status,
                            ['class' => 'select2 form-control','data-name'=>'invoice_status', 'data-live-search' => 'true', 'required',
                            'placeholder' => __('lang.please_select'), 'wire:model' => 'invoice_status']) !!}
                            @error('store_pos_id')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- ++++++++++++++++ Toggle Supplier Dropdown ++++++++++++++ --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>
                                {!! Form::checkbox('toggle_suppliers_dropdown', 1, false,['wire:model'=>'toggle_suppliers','wire:change' => 'toggle_suppliers_dropdown']) !!}
                                @lang('lang.toggle_suppliers_dropdown')
                            </label>
                        </div>
                    </div>
                    {{-- +++++++++++++++++ suppliers Dropdown +++++++++++++++++ --}}
                    @if(!empty($toggle_suppliers))
                        <div class="col-md-3">
                            {!! Form::label('supplier_id', __('lang.supplier') . ':*', []) !!}
                            <div class="d-flex justify-content-center">
                            {!! Form::select('supplier_id', $suppliers, $supplier_id,
                                ['class' => 'form-control select2', 'data-live-search' => 'true', 'id' => 'supplier_id', 'placeholder' => __('lang.please_select'),
                                'data-name' => 'supplier', 'wire:model' => 'supplier_id','required'=>'required'
                                ]) !!}
                                {{-- <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target=".add-supplier" ><i class="fas fa-plus"></i></button> --}}
                            </div>
                            @error('supplier')
                            <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>

                </div>
                <div class="row">

                    <div class="col-md-5">
                        <div class="card-app">
                            <div class="row">
                                <div class="col-md-2 {{$settings['toggle_dollar']=='1'?'d-none':''}}">
                                    <span> @lang('lang.min_amount_in_dollar') : {{ $customer_data->min_amount_in_dollar ?? 0 }}</span>
                                </div>
                                <div class="col-md-2 {{$settings['toggle_dollar']=='1'?'d-none':''}}">
                                    <span> @lang('lang.max_amount_in_dollar') : {{ $customer_data->max_amount_in_dollar ?? 0 }}</span>
                                </div>
                                <div class="col-md-2">
                                    <span> @lang('lang.min_amount_in_dinar') : {{ $customer_data->min_amount_in_dinar ?? 0 }}</span>
                                </div>
                                <div class="col-md-2">
                                    <span> @lang('lang.max_amount_in_dinar') : {{ $customer_data->max_amount_in_dinar ?? 0 }}</span>
                                </div>
                                <div class="col-md-2">
                                    <span> @lang('lang.balance_in_dinar') : {{ $customer_data->balance ?? 0 }}</span>
                                </div>
                                <div class="col-md-2 {{$settings['toggle_dollar']=='1'?'d-none':''}}">
                                    <span> @lang('lang.balance_in_dollar') : {{ $customer_data->dollar_balance ?? 0 }}</span>
                                </div>
                                <div class="col-md-2">
                                    <span> @lang('lang.customer_type') : {{ $customer_data->customer_type->name ?? '' }}</span>
                                </div>
                                @php
                                    if(!empty($customer_data->state_id)){
                                        $state = \App\Models\State::find($customer_data->state_id);
                                    }
                                @endphp
                                <div class="col-md-2">
                                    <span> @lang('lang.state') : {{ !empty($state) ? $state->name : '' }}</span>
                                </div>
                                @php
                                    if(!empty($customer_data->city_id)){
                                        $city = \App\Models\City::find($customer_data->city_id);
                                    }
                                @endphp
                                <div class="col-md-2">
                                    <span> @lang('lang.city') : {{ !empty($city) ? $city->name : '' }}</span>
                                </div>
                                @php
                                    if(!empty($customer_data->quarter_id )){
                                        $quarter = \App\Models\Quarter::find($customer_data->quarter_id );
                                    }
                                @endphp
                                <div class="col-md-2">
                                    <span> @lang('lang.quarter') : {{ !empty($quarter) ? $quarter->name : '' }}</span>
                                </div>
                                <div class="col-md-2">
                                    <span> @lang('lang.phone_number') : {{ !empty($customer_data->phone) ? $customer_data->phone: '' }}</span>
                                </div>
                                <div class="col-md-2">
                                    <span> @lang('lang.email') : {{ !empty($customer_data->email) ? $customer_data->email :'' }}</span>
                                </div>
                                <div class="col-md-2">
                                    <span> @lang('lang.notes') : {{ !empty($customer_data->notes) ? $customer_data->notes  : '' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <button style="width: 100%; background: #5b808f" wire:click="redirectToCustomerDetails({{ $client_id }})"
                                            class="btn btn-primary payment-btn">
                                        @lang('lang.customer_details')
                                    </button>
                                </div>
                            </div>
                            <button></button>

                        </div>
                    </div>
                </div>
                {{-- +++++++++++++++++ search inputField +++++++++++++++++ --}}

            </div>
        </div>
        <div class="row g-3 cards hide-print ">
            @include('invoices.partials.products')
            <div class="col-xl-7 special-medal-col">
                <div class="card-app ">
                    <div class="body-card-app content py-2 ">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="body-card-app">
                                <div class="table-responsive box-table ">
                                    {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                                    <div class="col-md-3 col-lg-12">
                                        <div class="multiselect col-md-12">
                                            <!-- Checkbox for each column -->
                                            <div id="checkboxes">
                                                @foreach($columnVisibility as $columnName => $visible)
                                                    <label for="{{ $columnName }}_id">
                                                        <input type="checkbox" id="{{ $columnName }}_id" wire:click="toggleColumnVisibility('{{ $columnName }}')" class="checkbox_class" {{ $visible ? 'checked' : '' }}>
                                                       @if($columnName == 'dollar_price')
                                                            <span>@lang('lang.price') $</span> &nbsp;
                                                       @elseif($columnName == 'dollar_sub_total')
                                                            <span>@lang('lang.sub_total') $</span> &nbsp;
                                                       @else
                                                            <span>@lang('lang.' . $columnName)</span> &nbsp;
                                                        @endif
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table">
                                        <tr>
                                            <th @if(!$columnVisibility['sku']) style="display: none;" @endif>@lang('lang.sku')</th>
                                            <th @if(!$columnVisibility['product']) style="display: none;" @endif>@lang('lang.product')</th>
                                            <th @if(!$columnVisibility['notes']) style="display: none;" @endif>@lang('lang.notes')</th>
                                            <th @if(!$columnVisibility['quantity']) style="display: none;" @endif>@lang('lang.quantity')</th>
                                            <th @if(!$columnVisibility['extra']) style="display: none;" @endif>@lang('lang.extra')</th>
                                            <th @if(!$columnVisibility['unit']) style="display: none;" @endif>@lang('lang.unit')</th>
                                            <th @if(!$columnVisibility['c_type']) style="display: none;" @endif>@lang('lang.c_type')</th>
                                            <th @if(!$columnVisibility['price']) style="display: none;" @endif>@lang('lang.price')</th>
                                            <th @if(!$columnVisibility['dollar_price']) style="display: none;" @endif class="{{$settings['toggle_dollar']=='1'?'d-none':''}}">@lang('lang.price') $ </th>
                                            <th @if(!$columnVisibility['exchange_rate']) style="display: none;" @endif> @lang('lang.exchange_rate')</th>
                                            <th @if(!$columnVisibility['discount']) style="display: none;" @endif>@lang('lang.discount')</th>
                                            <th @if(!$columnVisibility['discount_category']) style="display: none;" @endif>@lang('lang.discount_category')</th>
                                            <th @if(!$columnVisibility['sub_total']) style="display: none;" @endif>@lang('lang.sub_total')</th>
                                            <th @if(!$columnVisibility['dollar_sub_total']) style="display: none;" @endif class="{{$settings['toggle_dollar']=='1'?'d-none':''}}">@lang('lang.sub_total') $</th>
                                            <th @if(!$columnVisibility['current_stock']) style="display: none;" @endif>@lang('lang.current_stock')</th>
                                            <th>@lang('lang.action')</th>
                                        </tr>
                                        @php
                                          $total = 0;
                                        @endphp
                                        @foreach ($items as $key => $item)
                                            <tr>
                                                <td @if(!$columnVisibility['sku']) style="display: none;" @endif>{{!empty($item['product']['product_symbol'])?$item['product']['product_symbol']:$item['product']['sku']}}</td>
                                                <td @if(!$columnVisibility['product']) style="display: none;" @endif>
                                                    {{$item['product']['name']}}
                                                </td>
                                                <td @if(!$columnVisibility['notes']) style="display: none;" @endif>
                                                    <input class="form-control p-1 text-center" style="width: 50px" type="text" min="1"
                                                           wire:model="items.{{ $key }}.notes">
                                                </td>
                                                <td @if(!$columnVisibility['quantity']) style="display: none;" @endif >
                                                    <div class="d-flex align-items-center gap-1 " style="width: 80px">
                                                        <div class=" add-num control-num"
                                                            wire:click="increment({{$key}})">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </div>
                                                        <input class="form-control p-1 text-center" style="width: 50px" type="text" min="1"
                                                            wire:model="items.{{ $key }}.quantity" Wire:change="subtotal({{$key}})">
                                                        @error("items.$key.quantity")
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <div class="decrease-num control-num"
                                                            wire:click="decrement({{ $key }})">
                                                            <i class="fa-solid fa-minus"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td @if(!$columnVisibility['extra']) style="display: none;" @endif>{{$item['extra_quantity']}}</td>
                                                <td @if(!$columnVisibility['unit']) style="display: none;" @endif>
                                                    <select class="form-control select2" data-name="unit_id" data-index="{{$key}}" style="height:30% !important;width:100px;" wire:model="items.{{ $key }}.unit_id"  wire:change="changeUnit({{$key}})">
                                                        <option value="0.00">select</option>
                                                         @if(!empty($item['variation']))
                                                           @foreach($item['variation'] as $i=>$var)
                                                               @if(!empty($var['unit_id']))
                                                                    <option value="{{$var['id']}}" {{$i==0?'selected':''}}>
                                                                        {{$var['unit']['name']??''}}
                                                                    </option>
                                                               @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>
                                                <td @if(!$columnVisibility['c_type']) style="display: none;" @endif>
                                                    <select class="form-control select2" style="height:30% !important;width:100px;" data-name="customer_type_id" data-index="{{$key}}"
                                                            wire:model="items.{{ $key }}.customer_type_id"  wire:change="changeCustomerType({{$key}})">
                                                        <option value="0">select</option>
                                                         @if(!empty($item['customer_types']))
                                                         {{-- {{dd($item['customer_types'])}} --}}
                                                           @foreach($item['customer_types'] as $x=>$var)
                                                               @if(!empty($var) && !empty($var['id']))
                                                                    <option value="{{$var['id']}}" {{$x==0?'selected':''}}>
                                                                        {{$var['name']??''}}
                                                                    </option>
                                                               @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>
                                                <td @if(!$columnVisibility['price']) style="display: none;" @endif>
                                                    <input class="form-control dinarPrice" data-key="{{ $key }}" type="text" wire:model="items.{{ $key }}.price" style="width: 65px"/>
                                                    {{-- {{$item['price']??''}} --}}
                                                </td>
                                                <td @if(!$columnVisibility['dollar_price']) style="display: none;" @endif class="{{$settings['toggle_dollar']=='1'?'d-none':''}}">
                                                <input class="form-control dollarPrice" data-key="{{ $key }}" type="text" wire:model="items.{{ $key }}.dollar_price" style="width: 65px"/>

                                                    {{-- {{ number_format($item['dollar_price']??0 , 2)}} --}}
                                                </td>
                                                <td @if(!$columnVisibility['exchange_rate']) style="display: none;" @endif>
                                                    <input class="form-control p-1 text-center" style="width: 65px" type="text" min="1"
                                                           wire:model="items.{{ $key }}.exchange_rate">
                                                </td>
                                                <td @if(!$columnVisibility['discount']) style="display: none;" @endif>
                                                    <input class="form-control p-1 text-center" style="width: 65px" type="text" min="1" readonly
                                                                              wire:model="items.{{ $key }}.discount_price">
                                                </td>
                                                <td @if(!$columnVisibility['discount_category']) style="display: none;" @endif>
                                                    <select class="form-control discount_category select2" style="height:30% !important;width:80px;font-size:14px;" wire:model="items.{{ $key }}.discount" data-name="discount" data-index="{{$key}}" wire:change="subtotal({{$key}},'discount')">
                                                        <option selected value="0">select</option>
                                                        @if(!empty($item['discount_categories']))
                                                            @if(!empty($client_id))
                                                                @foreach($item['discount_categories'] as $discount)
                                                                    <option value="{{$discount['id']}}" >{{$discount['price_category']}}</option>
                                                                @endforeach
                                                            @else
                                                                @foreach($item['discount_categories'] as $discount)
                                                                    @if($discount['price_category']!==null)
                                                                        <option value="{{$discount['id']}}">{{ $discount['price_category'] ?? ''}} </option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    </select>
                                                </td>
                                                <td @if(!$columnVisibility['sub_total']) style="display: none;" @endif>
                                                    {{ $item['sub_total']??0 }}
                                                </td>
                                                <td @if(!$columnVisibility['dollar_sub_total']) style="display: none;" @endif class="{{$settings['toggle_dollar']=='1'?'d-none':''}}">
                                                    {{$item['dollar_sub_total']??0}}
                                                </td>
                                                <td @if(!$columnVisibility['current_stock']) style="display: none;" @endif>
                                                    <span class="current_stock">
                                                       {{$item['quantity_available']}}
                                                    </span>
                                                </td>
                                                <td  class="text-center">
                                                    <div class="btn btn-sm btn-success py-0 px-1 my-1 {{$settings['toggle_dollar']=='1'?'d-none':''}}"
                                                         wire:click="changePrice({{ $key }})">
                                                        <i class="fas fa-undo"></i>
                                                    </div>
                                                    <div class="btn btn-sm btn-danger py-0 px-1"
                                                        wire:click="delete_item({{ $key }})">
                                                        <i class="fas fa-trash-can"></i>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            {{--                                            <div class="col-md-7">--}}
                                            @include('invoices.partials.search')
                                            {{--                                            </div>--}}
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('invoices.partials.rightSidebar')
        </div>
        {!! Form::close() !!}
        <button class="btn btn-danger" wire:click="cancel"> @lang('lang.close')</button>
        <button class="btn btn-danger" wire:click="getPreviousTransaction"> <</button>
        <button class="btn btn-danger" disabled wire:click="getNextTransaction"> ></button>

    </div>
</section>
@include('customers.quick_add',['quick_add'=>1])



{{--<!-- This will be printed -->--}}
<section class="invoice print_section print-only" id="receipt_section_print"> </section>
@push('javascripts')
    @if(empty($store_pos) || empty($stores))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const noUserPosEvent = new Event('NoUserPos');
                window.dispatchEvent(noUserPosEvent);
            });
        </script>
    @endif

    @if(empty($store_pos))
    <script>
    window.addEventListener('NoUserPos', function(event) {
        Swal.fire({
            title: "{{ __('lang.kindly_assign_pos_for_that_user_to_able_to_use_it') }}" + "<br>" ,
            icon: 'error',
        }).then((result) => {
            window.location.href = "{{ route('home') }}";
        });
    });
    </script>
    @endif
    <script>
        document.addEventListener('livewire:load', function () {
            $('.depart1').select().on('change', function (e) {
                @this.set('department_id1', $(this).val());
            });
        });
        document.addEventListener('livewire:load', function () {
            $('#store_id').select();
            // Trigger Livewire updates when the select2 value changes
            $('#store_id').on('change', function (e) {
            @this.set('store_id', $(this).val());
            });
        });
        document.addEventListener('livewire:load', function () {
            Livewire.on('printInvoice', function (htmlContent) {
                // Set the generated HTML content
                $("#receipt_section_print").html(htmlContent);
                // Trigger the print action
                window.print("#receipt_section_print");
            });
        });
        $(document).on("click", ".print-invoice", function () {
            // $(".modal").modal("hide");
            $.ajax({
                method: "get",
                url: $(this).data("href"),
                data: {},
                success: function (result) {
                    if (result.success) {
                        Livewire.emit('printInvoice', result.html_content);
                        window.location.reload(true)

                    }
                },
            });
        });
        window.addEventListener('quantity_not_enough', function(event) {
            var id = event.detail.id;
            Swal.fire({
                title: "{{ __('lang.out_of_stock') }}" + "<br>" ,
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: LANG.cancel,
                cancelButtonText: LANG.po,
            }).then((result) => {
                if (result.isConfirmed) {
                } else {
                    Livewire.emit('create_purchase_order',id);
                }
            });
        });

        $(document).ready(function() {
            $('select').on('change', function(e) {

                var name = $(this).data('name');
                var index = $(this).data('index');
                var select2 = $(this); // Save a reference to $(this)
                Livewire.emit('listenerReferenceHere',{
                    var1 :name,
                    var2 :select2.select2("val") ,
                    var3:index
                });

            });
        });

        $(document).on('change','.dinarPrice', function(e) {
            var key=$(this).data('key');
            Swal.fire({
                'type' : 'info',
                'title' : 'تأكيد',
                'text' : 'هل نريد تغيير السعر بصورة دائمة ؟',
                'showCancelButton' : true,
                'confirmButtonText' : 'نعم',
                'cancelButtonText' : 'إلغاء',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('changeDinarPrice',key);
                } else {
                    Livewire.emit('changePrices',key);
                }
            });

        });




        $(document).on('change','.dollarPrice', function(e) {
            var key=$(this).data('key');
            Swal.fire({
                'type' : 'info',
                'title' : 'تأكيد',
                'text' : 'هل نريد تغيير السعر بصورة دائمة ؟',
                'showCancelButton' : true,
                'confirmButtonText' : 'نعم',
                'cancelButtonText' : 'إلغاء',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('changeDollarPrice',key);
                } else {
                    Livewire.emit('changePrices',key);
                }
            });

        });
        $(document).on('change', 'select', function(e) {
            var name = $(this).data('name');
            console.log(name)
            if (name != undefined) {
                var index = $(this).data('index');
                var key = $(this).data('key');
                var select2 = $(this);
                Livewire.emit('listenerReferenceHere', {
                    var1: name,
                    var2: select2.select2("val"),
                    var3: index,
                    var4: key
                });
            }
        });
    </script>

@endpush
