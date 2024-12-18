@extends('layouts.app')
@section('title', __('lang.suppliers'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.suppliers')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                         <li class="breadcrumb-item"><a href="{{ route('suppliers.create') }}">@lang('lang.add_supplier')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.suppliers')</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        @lang('lang.add_supplier')
                    </a>
                </div>
            </div>
        </div>
    </div>
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
                        <h5 class="card-title">@lang('lang.suppliers')</h5>
                    </div>
                    <div class="card-body">
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            {{-- ++++++++++++++++++ Show/Hide Table Columns : selectbox of checkboxes ++++++++++++++++++ --}}
                            <div class="col-md-3 col-lg-3">
                                <div class="multiselect col-md-12">
                                    <div class="selectBox" onclick="showCheckboxes()">
                                        <select class="form-select form-control form-control-lg">
                                            <option>@lang('lang.show_hide_columns')</option>
                                        </select>
                                        <div class="overSelect"></div>
                                    </div>
                                    <div id="checkboxes">
                                        {{-- +++++++++++++++++ checkbox1 : name +++++++++++++++++ --}}
                                        <label for="col1_id">
                                            <input type="checkbox" id="col1_id" name="col1" checked="checked" />
                                            <span>@lang('lang.name')</span> &nbsp;
                                        </label>
                                        {{-- +++++++++++++++++ checkbox2 : company_name +++++++++++++++++ --}}
                                        <label for="col2_id">
                                            <input type="checkbox" id="col2_id" name="col2" checked="checked" />
                                            <span>@lang('lang.company_name')</span>
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
                                        {{-- +++++++++++++++++ checkbox7 : exchange_rate +++++++++++++++++ --}}
                                        <label for="col7_id">
                                            <input type="checkbox" id="col7_id" name="col7" checked="checked" />
                                            <span>@lang('lang.exchange_rate')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox8 : owner_debt_in_dinar +++++++++++++++++ --}}
                                        <label for="col8_id">
                                            <input type="checkbox" id="col8_id" name="col8" checked="checked" />
                                            <span>@lang('lang.owner_debt_in_dinar')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox9 : owner_debt_in_dollar +++++++++++++++++ --}}
                                        <label for="col9_id">
                                            <input type="checkbox" id="col9_id" name="col9" checked="checked" />
                                            <span>@lang('lang.owner_debt_in_dollar')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox10 : created_by +++++++++++++++++ --}}
                                        <label for="col10_id">
                                            <input type="checkbox" id="col10_id" name="col10" checked="checked" />
                                            <span>@lang('lang.created_by')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox11 : updated_by +++++++++++++++++ --}}
                                        <label for="col11_id">
                                            <input type="checkbox" id="col11_id" name="col11" checked="checked" />
                                            <span>@lang('lang.updated_by')</span>
                                        </label>
                                        {{-- +++++++++++++++++ checkbox12 : action +++++++++++++++++ --}}
                                        <label for="col12_id">
                                            <input type="checkbox" id="col12_id" name="col12" checked="checked" />
                                            <span>@lang('lang.action')</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br/><br/>
                            {{-- +++++++++++++++++++++++++++ Table +++++++++++++++++++++++++++ --}}
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th class="col1">@lang('lang.name')</th>
                                    <th class="col2">@lang('lang.company_name')</th>
                                    <th class="col3">@lang('lang.email')</th>
                                    <th class="col4">@lang('lang.mobile_number')</th>
                                    <th class="col5">@lang('lang.state')</th>
                                    <th class="col6">@lang('lang.city')</th>
                                    <th class="col7">@lang('lang.exchange_rate')</th>
                                    <th class="col8">@lang('lang.owner_debt_in_dinar')</th>
                                    <th class="col9">@lang('lang.owner_debt_in_dollar')</th>
                                    <th class="col10">@lang('lang.created_by')</th>
                                    <th class="col11">@lang('lang.updated_by')</th>
                                    <th class="col12">@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($suppliers as $supplier)
                                <tr>
                                    <td class="col1">{{$supplier->name}}</td>
                                    <td class="col2">{{$supplier->company_name}}</td>
                                    {{-- Convert the email and phone strings to arrays --}}
                                    @php
                                        $emailArray = explode(',', $supplier->email);
                                        $phoneArray = explode(',', $supplier->mobile_number);
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
                                            {{ $email == 'null' ? '' : $email }}<br>
                                        @endforeach
                                    </td>
                                    <td class="col4">
                                        {{-- Iterate over the phone array elements --}}
                                        @foreach ($phoneArray as $phone)
                                            {{ $phone == 'null' ? '' : $phone }}<br>
                                        @endforeach
                                    </td>
                                    @php
                                        $state = \App\Models\State::find($supplier->state_id);
                                        $city = \App\Models\City::find($supplier->city_id);
                                    @endphp
                                    <td class="col5">{{ $state ? $state->name : '' }}</td>
                                    <td class="col6">{{ $city  ? $city->name : '' }}</td>
                                    <td class="col7">{{$supplier->exchange_rate}}</td>
                                    <td class="col8">{{$supplier->owner_debt_in_dinar}}</td>
                                    <td class="col9">{{$supplier->owner_debt_in_dollar}}</td>
                                    <td class="col10">{{$supplier->created_by_user->name}}</td>
                                    <td class="col11">{{$supplier->updated_by_user->name ?? ''}}</td>
                                    <td class="col12">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">خيارات                                            <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu" x-placement="bottom-end" style="position: absolute; transform: translate3d(73px, 31px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                {{-- ++++++++++++++++++ Show Supplier ++++++++++++++++++ --}}
                                                <li>
                                                    <a href="{{ route('suppliers.show', $supplier->id) }}"
                                                        class="btn"><i class="fa fa-eye"></i>
                                                        @lang('lang.view')</a>
                                                </li>
                                                <li class="divider"></li>
                                                {{-- ++++++++++++++++++ Show statement_of_account of Supplier ++++++++++++++++++ --}}
                                                <li>
                                                    <a href="{{ route('suppliers.show', $supplier->id) }}?show=statement_of_account"
                                                        class="btn"><i class="dripicons-document"></i>
                                                        @lang('lang.statement_of_account')</a>
                                                </li>
                                                <li class="divider"></li>
                                                {{-- ++++++++++++++++++ Edit Supplier ++++++++++++++++++ --}}
                                                <li>
                                                    <a href="{{route('suppliers.edit', $supplier->id)}}" target="_blank" class="btn edit_supplier">
                                                        <i class="fa fa-pencil-square-o"></i>@lang('lang.edit')</a>
                                                </li>
                                                <li class="divider"></li>
                                                {{-- ++++++++++++++++++ Destroy Supplier ++++++++++++++++++ --}}
                                                <li>
                                                    <a data-href="{{route('suppliers.destroy', $supplier->id)}}"
                                                        {{-- data-check_password="{{action('UserController@checkPassword', Auth::user()->id)}}" --}}
                                                        class="btn text-red delete_item"><i class="fa fa-trash"></i>
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
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
        <!-- End Contentbar -->
    </div>
    <!-- End Rightbar -->
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
