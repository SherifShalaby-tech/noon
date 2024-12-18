@extends('layouts.app')
@section('title', __('lang.customers'))
@section('breadcrumbbar')
    {{-- +++++++++++++++ Style : checkboxes and labels inside selectbox +++++++++++++++ --}}
    <style>
            .selectBox {
            position: relative;
            }

            /* selectbox style */
            .selectBox select
            {
                width: 100%;
                padding: 0 !important;
                padding-left: 4px;
                padding-right: 4px;
                color: #fff;
                border: 1px solid #596fd7;
                background-color: #596fd7;
                height: 39px !important;
            }

            .overSelect {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            }

            #checkboxes {
            display: none;
            border: 1px #dadada solid;
            height: 125px;
            overflow: auto;
            padding-top: 10px;
            /* text-align: end;  */
            }

            #checkboxes label {
            display: block;
            padding: 5px;

            }

            #checkboxes label:hover {
            background-color: #ddd;
            }
            #checkboxes label span
            {
                font-weight: normal;
            }
    </style>

    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.customers')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.customers')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{route('customers.create')}}" class="btn btn-primary">
                        @lang('lang.add_customers')
                      </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Start Contentbar -->
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">@lang('lang.customers')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="container-fluid">
                                    {{-- @include('customers.filters') --}}
                                </div>
                            </div>
                        </div>
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                            <div class="col-md-3 col-lg-3">
                                {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                                <div class="multiselect col-md-12">
                                    <div class="selectBox" onclick="showCheckboxes()">
                                        <select class="form-select form-control form-control-lg">
                                            <option>@lang('lang.show_hide_columns')</option>
                                        </select>
                                        <div class="overSelect"></div>
                                    </div>

                                    <div id="checkboxes">
                                        {{-- +++++++++++++++++ checkbox1 : customer_name +++++++++++++++++ --}}
                                        <label for="col1_id">
                                            <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                            <span>@lang('lang.customer_name')</span> &nbsp;
                                        </label>
                                        {{-- +++++++++++++++++ checkbox2 : customer_type +++++++++++++++++ --}}
                                        <label for="col2_id">
                                            <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                            <span>@lang('lang.customer_type')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox3 : email +++++++++++++++++ --}}
                                        <label for="col3_id">
                                            <input type="checkbox" id="col3_id" name="col3" checked="checked" />
                                            <span>@lang('lang.email')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox4 : phone +++++++++++++++++ --}}
                                        <label for="col4_id">
                                            <input type="checkbox" id="col4_id" name="col4" checked="checked" />
                                            <span>@lang('lang.phone')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox5 : state +++++++++++++++++ --}}
                                        <label for="col5_id">
                                            <input type="checkbox" id="col5_id" name="col5" checked="checked" />
                                            <span>@lang('lang.state')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox6 : city +++++++++++++++++ --}}
                                        <label for="col6_id">
                                            <input type="checkbox" id="col6_id" name="col6" checked="checked" />
                                            <span>@lang('lang.city')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox7 : min_amount_in_dinar +++++++++++++++++ --}}
                                        <label for="col7_id">
                                            <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                            <span>@lang('lang.min_amount_in_dinar')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox8 : max_amount_in_dinar +++++++++++++++++ --}}
                                        <label for="col8_id">
                                            <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                            <span>@lang('lang.max_amount_in_dinar')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox9 : min_amount_in_dollar +++++++++++++++++ --}}
                                        <label for="col9_id">
                                            <input type="checkbox" id="col9_id" name="col9" checked="checked" />
                                            <span>@lang('lang.min_amount_in_dollar')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox10 : max_amount_in_dollar +++++++++++++++++ --}}
                                        <label for="col10_id">
                                            <input type="checkbox" id="col10_id" name="col10" checked="checked" />
                                            <span>@lang('lang.max_amount_in_dollar')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox11 : balance_in_dinar +++++++++++++++++ --}}
                                        <label for="col11_id">
                                            <input type="checkbox" id="col11_id" name="col11" checked="checked" />
                                            <span>@lang('lang.balance_in_dinar')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox12 : balance_in_dollar +++++++++++++++++ --}}
                                        <label for="col12_id">
                                            <input type="checkbox" id="col12_id" name="col12" checked="checked" />
                                            <span>@lang('lang.balance_in_dollar')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox13 : balance +++++++++++++++++ --}}
                                        <label for="col13_id">
                                            <input type="checkbox" id="col13_id" name="col13" checked="checked" />
                                            <span>@lang('lang.balance')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox14 : purchases +++++++++++++++++ --}}
                                        <label for="col14_id">
                                            <input type="checkbox" id="col14_id" name="col14" checked="checked" />
                                            <span>@lang('lang.purchases')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox15 : discount +++++++++++++++++ --}}
                                        <label for="col15_id">
                                            <input type="checkbox" id="col15_id" name="col15" checked="checked" />
                                            <span>@lang('lang.discount')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox16 : points +++++++++++++++++ --}}
                                        <label for="col16_id">
                                            <input type="checkbox" id="col16_id" name="col16" checked="checked" />
                                            <span>@lang('lang.points')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox17 : updated_by +++++++++++++++++ --}}
                                        <label for="col17_id">
                                            <input type="checkbox" id="col17_id" name="col17" checked="checked" />
                                            <span>@lang('lang.updated_by')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox18 : action +++++++++++++++++ --}}
                                        <label for="col18_id">
                                            <input type="checkbox" id="col18_id" name="col18" checked="checked" />
                                            <span>@lang('lang.action')</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br/><br/>
                            {{-- +++++++++++++++++++++++++++ Table +++++++++++++++++++++++++++ --}}
                            <table id="datatable-buttons" class="table table-striped table-bordered hideShowTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="col1">@lang('lang.customer_name')</th>
                                        <th class="col2">@lang('lang.customer_type')</th>
                                        <th class="col3">@lang('lang.email')</th>
                                        <th class="col4">@lang('lang.phone')</th>
                                        <th class="col5">@lang('lang.state')</th>
                                        <th class="col6">@lang('lang.city')</th>
                                        <th class="col7">@lang('lang.min_amount_in_dinar')</th>
                                        <th class="col8">@lang('lang.max_amount_in_dinar')</th>
                                        <th class="col9">@lang('lang.min_amount_in_dollar')</th>
                                        <th class="col10">@lang('lang.max_amount_in_dollar')</th>
                                        <th class="col11">@lang('lang.balance_in_dinar')</th>
                                        <th class="col12">@lang('lang.balance_in_dollar')</th>
                                        <th class="col13">@lang('lang.balance')</th>
                                        <th class="col14">@lang('lang.purchases')</th>
                                        <th class="col15">@lang('lang.discount')</th>
                                        <th class="col16">@lang('lang.points')</th>
                                        <th class="col17">@lang('updated_by')</th>
                                        <th class="col18">@lang('lang.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $index=>$customer)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td class="col1">{{$customer->name}}</td>
                                            <td class="col2">{{$customer->customer_type->name}}</td>
                                            {{-- Convert the email and phone strings to arrays --}}
                                            @php
                                                $emailArray = explode(',', $customer->email);
                                                $phoneArray = explode(',', $customer->phone);
                                                // Remove square brackets from each element in the emailArray
                                                foreach ($emailArray as $key => $email)
                                                {
                                                    $emailArray[$key] = str_replace(['[', ']','"'], '', $email);
                                                }
                                                // Remove square brackets from each element in the emailArray
                                                foreach ($phoneArray as $key => $phone)
                                                {
                                                    $phoneArray[$key] = str_replace(['[', ']','"'], '', $phone);
                                                }
                                            @endphp
                                            <td class="col3">
                                                {{-- Iterate over the email array elements --}}
                                                @foreach ($emailArray as $email)
                                                    {{ $email }}<br>
                                                @endforeach
                                            </td>
                                            <td class="col4">
                                                {{-- Iterate over the phone array elements --}}
                                                @foreach ($phoneArray as $phone)
                                                    {{ $phone }}<br>
                                                @endforeach
                                            </td>

                                            @php
                                                $state = \App\Models\State::find($customer->state_id);
                                                $city = \App\Models\City::find($customer->city_id);
                                            @endphp
                                            <td class="col5">{{ $state ? $state->name : '' }}</td>
                                            <td class="col6">{{ $city ? $city->name : '' }}</td>
                                            <td class="col7">{{ $customer->min_amount_in_dinar }}</td>
                                            <td class="col8">{{ $customer->max_amount_in_dinar }}</td>
                                            <td class="col9">{{ $customer->min_amount_in_dollar }}</td>
                                            <td class="col10">{{ $customer->max_amount_in_dollar }}</td>
                                            <td class="col11">{{ $customer->balance }}</td>
                                            <td class="col12">{{ $customer->dollar_balance }}</td>
                                            <td class="col13">{{$customer->added_balance}}</td>
                                            <td class="col14">{{$customer->added_balance}}</td>
                                            <td class="col15">{{$customer->added_balance}}</td>
                                            <td class="col16">
                                                @if ($customer->created_by  > 0 and $customer->created_by != null)
                                                    {{ $customer->created_at->diffForHumans() }} <br>
                                                    {{ $customer->created_at->format('Y-m-d') }}
                                                    ({{ $customer->created_at->format('h:i') }})
                                                    {{ ($customer->created_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                    {{ $customer->createBy?->name }}
                                                @else
                                                {{ __('no_update') }}
                                                @endif
                                            </td>
                                            <td class="col17">
                                                @if ($customer->updated_by  > 0 and $customer->updated_by != null)
                                                    {{ $customer->updated_at->diffForHumans() }} <br>
                                                    {{ $customer->updated_at->format('Y-m-d') }}
                                                    ({{ $customer->updated_at->format('h:i') }})
                                                    {{ ($customer->updated_at->format('A')=='AM'?__('am') : __('pm')) }}  <br>
                                                    {{ $customer->updateBy?->name }}
                                                @else
                                                {{ __('no_update') }}
                                                @endif
                                            </td>
                                            <td class="col18">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات                                            <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <li>
                                                            <a href="{{route('customer_dues', $customer->id)}}" class="btn" target="_blank"><i class="dripicons-document-edit"></i> @lang('lang.dues')</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a href="{{route('customers.show', $customer->id)}}" class="btn">
                                                                <i class="fa fa-eye"></i>@lang('lang.view')
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a href="{{route('customers.edit', $customer->id)}}" class="btn" target="_blank"><i class="dripicons-document-edit"></i> @lang('lang.update')</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                            <li>
                                                                <a data-href="{{route('customers.destroy', $customer->id)}}"
                                                                    class="btn text-red delete_item"><i class="fa fa-trash"></i>
                                                                    @lang('lang.delete')</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a href="{{route('customer-balance-adjustment.create', ['customer_id' => $customer->id])}}" class="btn" target="_blank">
                                                                <i class="fa fa-adjust"></i>
                                                                @lang('lang.adjust_customer_balance')</a>
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
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // +++++++++++++++++ Checkboxs and label inside selectbox ++++++++++++++
        $("input:checkbox:not(:checked)").each(function() {
            var column = "table ." + $(this).attr("name");
            $(column).hide();
        });

        $("input:checkbox").click(function(){
            var column = "table ." + $(this).attr("name");
            $(column).toggle();
        });
        // +++++++++++++++++ Checkboxs and label inside selectbox : showCheckboxes() method ++++++++++++++
        var expanded = false;
        function showCheckboxes()
        {
            var checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                expanded = true;
            } else {
                checkboxes.style.display = "none";
                expanded = false;
            }
        }

    </script>
@endsection
