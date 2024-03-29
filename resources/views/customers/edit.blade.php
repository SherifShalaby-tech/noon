@extends('layouts.app')
@section('title', __('lang.edit_customers'))
@section('breadcrumbbar')
    <div class="breadcrumbbar">
       <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.edit_customers')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('customers.index')}}">@lang('lang.customers')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.edit_customers')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- Start row -->
    <div class="row d-flex justify-content-center">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30 p-2">
                {!! Form::open(['route' => ['customers.update',$customer->id],'method'=>'put','id'=>'brand-update-form' ]) !!}
                @csrf
                @method('PUT')
                <div class="container-fluid">
                    <div class="row pt-4">
                        {{-- ++++++++++++++++++ customer_type ++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('customer_type_id', __('lang.customer_type') . ':*') !!}
                                {!! Form::select('customer_type_id', $customer_types, $customer->customer_type_id, [
                                'class' => 'form-control select2',
                                'required',
                                'placeholder' => __('lang.please_select')]) !!}
                                 @error('customer_type_id')
                                 <label class="text-danger error-msg">{{ $message }}</label>
                                 @enderror
                            </div>
                        </div>
                        {{-- ++++++++++++++++++ name ++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                            {!! Form::label('name', __('lang.name')) !!}
                            {!! Form::text('name',  $customer->name, [
                                'class' => 'form-control required',
                            ]) !!}
                             @error('name')
                                <label class="text-danger error-msg">{{ $message }}</label>
                             @enderror
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++++++++++ email array ++++++++++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group ">
                                <table class="bordered">
                                    <thead class="email_thead">
                                        <tr>
                                            <th class="text-left" style="font-weight: normal;">
                                                <label class="mb-2">
                                                    <span class="text-danger">*</span>@lang('lang.email')
                                                </label>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="email_tbody">
                                        <tr>
                                            <td class="col-md-12 p-0">
                                                <div class="select_body d-flex justify-content-between align-items-center" >
                                                    @php
                                                        $emailArray = explode(',', $customer->email);
                                                        // Remove square brackets from each element in the emailArray
                                                        foreach ($emailArray as $key => $email)
                                                        {
                                                            $emailArray[$key] = str_replace(['[', ']','"'], '', $email);
                                                        }
                                                    @endphp
                                                    {{-- Iterate over the email array elements --}}
                                                    @foreach ($emailArray as $key => $email)
                                                        @if($key == 0)
                                                            <input type="text"
                                                                   class="form-control"
                                                                   placeholder="@lang('lang.email')"
                                                                   name="email[]"
                                                                   value="{{ $email }}" required >
                                                            <td  class="col-md-6">
                                                                {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                                <a href="javascript:void(0)" class="btn btn-xs btn-primary addRow_email" type="button">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </td>
                                                            @error('email')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        @else
                                                            <tr>
                                                                <td>
                                                                    <input  type="text" class="form-control" placeholder="@lang('lang.email')" name="email[]"
                                                                            value="{{ $email }}" required >
                                                                    @error('email')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-danger deleteRow_email">-</a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++ min_amount_in_dollar +++++++++++++++++++++++ --}}
                        <div class="col-md-4 mb-3 ">
                            <div class="form-group">
                                <label for="min_amount_in_dollar">@lang('lang.min_amount_in_dollar')</label>
                                <input type="number" class="form-control" value="{{$customer->min_amount_in_dollar}}" name="min_amount_in_dollar" id="min_amount_in_dollar" />
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++ max_amount_in_dollar +++++++++++++++++++++++ --}}
                        <div class="col-md-4 mb-3 ">
                            <div class="form-group">
                                <label for="max_amount_in_dollar">@lang('lang.max_amount_in_dollar')</label>
                                <input type="number" class="form-control" value="{{$customer->max_amount_in_dollar}}" name="max_amount_in_dollar" id="max_amount_in_dollar" />
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++ min_amount_in_dinar +++++++++++++++++++++++ --}}
                        <div class="col-md-4 mb-3 ">
                            <div class="form-group">
                                <label for="min_amount_in_dinar">@lang('lang.min_amount_in_dinar')</label>
                                <input type="number" class="form-control" value="{{ $customer->min_amount_in_dinar }}" name="min_amount_in_dinar" id="min_amount_in_dinar" />
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++ max_amount_in_dinar +++++++++++++++++++++++ --}}
                        <div class="col-md-4 mb-3 ">
                            <div class="form-group">
                                <label for="max_amount_in_dinar">@lang('lang.max_amount_in_dinar')</label>
                                <input type="number" class="form-control" value="{{$customer->max_amount_in_dinar}}" name="max_amount_in_dinar" id="max_amount_in_dinar" />
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++ balance_in_dollar +++++++++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="balance_in_dollar">@lang('lang.balance_in_dollar')</label>
                                <input type="text" class="form-control" value="{{ $customer->balance_in_dollar }}" name="balance_in_dollar" id="balance_in_dollar" />
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++ balance_in_dinar +++++++++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="balance_in_dinar">@lang('lang.balance_in_dinar')</label>
                                <input type="text" class="form-control" value="{{ $customer->balance_in_dinar }}" name="balance_in_dinar" id="balance_in_dinar" />
                            </div>
                        </div>
                        {{-- ++++++++++++++++ countries selectbox +++++++++++++++++ --}}
                        <div class="col-md-4">
                            <label for="country-dd">@lang('lang.country')</label>
                            <select id="country-dd" name="country" class="form-control" disabled>
                                <option value="{{ $countryId }}">
                                    {{ $countryName }}
                                </option>
                            </select>
                        </div>
                        {{-- ++++++++++++++++ state selectbox +++++++++++++++++ --}}
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="state-dd">@lang('lang.state')</label>
                                <select id="state-dd" name="state_id" class="form-control select2">
                                    @php
                                        $states = \App\Models\State::where('country_id', $countryId)->get(['id','name']);
                                    @endphp
                                    @foreach ( $states as $state)
                                        <option value="{{ $state->id }}">
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- ++++++++++++++++ city selectbox +++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="city-dd">@lang('lang.regions')</label>
                                <div class="d-flex justify-content-center">
                                    <select id="city-dd" name="city_id" class="form-control select2"></select>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" id="cities_id" data-target="#createRegionModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- ++++++++++++++++ quarter selectbox : الاحياء +++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="quarters_id">@lang('lang.quarters')</label>
                                <div class="d-flex justify-content-center">
                                    <select id="quarter-dd" class="form-control select2" name="quarter_id"></select>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" id="add_quarters_btn_id" data-target="#createQuarterModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++++++++++ phone array ++++++++++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group ">
                                <table class="bordered">
                                    <thead class="phone_thead">
                                        <tr>
                                            <th class="text-left" style="font-weight: normal;">
                                                <label class="mb-2">
                                                    <span class="text-danger">*</span>@lang('lang.phone')
                                                </label>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="phone_tbody">
                                        <tr>
                                            <td class="col-md-12 p-0">
                                                <div class="select_body d-flex justify-content-between align-items-center" >
                                                    @php
                                                        $phoneArray = explode(',', $customer->phone);
                                                        // Remove square brackets from each element in the emailArray
                                                        foreach ($phoneArray as $key => $phone)
                                                        {
                                                            $phoneArray[$key] = str_replace(['[', ']','"'], '', $phone);
                                                        }
                                                    @endphp
                                                    {{-- Iterate over the email array elements --}}
                                                    @foreach ($phoneArray as $index => $phone)
                                                        @if($index == 0)
                                                            <input type="text"
                                                                   class="form-control"
                                                                   placeholder="@lang('lang.phone')"
                                                                   name="phone[]"
                                                                   value="{{ $phone }}" required >
                                                            <td class="col-md-6">
                                                                {{-- +++++++++++++ Add New Phone Number +++++++++ --}}
                                                                <a href="javascript:void(0)" class="btn btn-xs btn-primary addRow_phone" type="button">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </td>
                                                            @error('phone')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        @else
                                                            <tr>
                                                                <td>
                                                                    <input  type="text" class="form-control" placeholder="@lang('lang.phone')" name="phone[]"
                                                                            value="{{ $phone }}" required >
                                                                    @error('phone')
                                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-danger deleteRow_phone">-</a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- ++++++++++++ images ++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('lang.upload_image')</label>
                                <input class="form-control img" name="image" type="file" accept="image/*" id="image">
                                {{-- Crop Image : cropper.js --}}
                                {{-- <div class="dropzone" id="my-dropzone2" required>
                                    <div class="dz-message" data-dz-message><span>@lang('categories.drop_file_here_to_upload')</span></div>
                                </div> --}}
                                @error('cover')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        {{-- ++++++++++++++++++ address ++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('address', __('lang.address')) !!}
                                {!! Form::textarea('address', $customer->address, [
                                    'class' => 'form-control',
                                ]) !!}
                                 @error('address')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                 @enderror
                            </div>
                        </div>
                        {{-- +++++++++++++++++++++++ Notes +++++++++++++++++++++++ --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('notes', __('lang.notes')) !!}
                                {!! Form::textarea('notes', $customer->notes, [
                                    'class' => 'form-control',
                                ]) !!}
                                @error('address')
                                <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- ++++++++++++++++++ important_dates ++++++++++++++++ --}}
                    <div class="row pt-4 pb-5">
                        <div class="col-md-12">
                            <h3>@lang('lang.important_dates')</h3>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <table class="table table-bordered" id="important_date_table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%;">@lang('lang.important_date')</th>
                                            <th style="width: 20%;">@lang('lang.date')</th>
                                            <th style="width: 20%;">@lang('lang.notify_before_days')</th>
                                            <th style="width: 10%;"><button type="button"
                                                    class="add_date btn btn-success btn-xs"><i class="fa fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer->customer_important_dates as $important_date)
                                        @include('customers.important_date_row', ['index' => $loop->index,
                                        'important_date' => $important_date])
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <input type="hidden" name="important_date_index" id="important_date_index" value="{{count($customer->customer_important_dates)}}">
                    </div>
                    {{-- ++++++++++++++++++ submit ++++++++++++++++ --}}
                    <div class="row pb-5">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            {{-- ++++++++++++ customer_types Model ++++++++++++ --}}
            @include('customer_types.create')
        </div>
    </div>
@endsection
@push('js')
    <script src="{{asset('js/product/customer.js')}}" ></script>
    <script>
        $(document).ready(function(){
            $('.phone_tbody').on('click','.addRow', function(){
                console.log('new phone inputField was added');
                var tr = `<tr>
                        <td>
                            <input type="text" name="phone[]" class="form-control" placeholder="Enter phone number" />
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-xs btn-danger deleteRow">-</a>
                        </td>

                    </td>
                </tr>`;
                $('.phone_tbody').append(tr);
            } );
            $('.phone_tbody').on('click','.deleteRow',function(){
                $(this).parent().parent().remove();
            });
            // +++++++++++++++++++++++++++++++ Add New Row in email ++++++++++++++++++++++++
            $('.email_tbody').on('click','.addRow_email', function(){
                console.log('new Email inputField was added');
                var tr = `<tr>
                        <td>
                            <input  type="text" class="form-control" placeholder="@lang('lang.email')" name="email[]"
                                    value="" required >
                                    @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                </td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-xs btn-danger deleteRow_email">-</a>
                </td>

            </td>
        </tr>`;
                $('.email_tbody').append(tr);
            } );
            $('.email_tbody').on('click','.deleteRow_email',function(){
                $(this).parent().parent().remove();
            });
            // ++++++++++++++++++++++ Countries , State , Cities Selectbox ++++++++++++++++
            // ================ state selectbox ================
            $('#state-dd').change(function(event) {
                // Capture the selected state value
                var idState = this.value;
                $('#city-dd').html('');
                $.ajax({
                    url: "/api/customers/fetch-cities",
                    type: 'POST',
                    dataType: 'json',
                    data: {state_id: idState,_token:"{{ csrf_token() }}"},
                    success:function(response)
                    {
                        $('#city-dd').html('<option value="">Select State</option>');
                        $.each(response.cities,function(index, val)
                        {
                            $('#city-dd').append('<option value="'+val.id+'">'+val.name+'</option>')
                        });
                    }
                })
            });
            // ================ city selectbox ================
            // ++++++++++++ store "state_id" in hidden inputField in "cities modal" ++++++++++
            $("#cities_id").on('click', function(){
                var state_id = $("#state-dd").val();
                $("#stateId").val(state_id);
                console.log("+++++++++++++++++++++++++++ "+state_id+" +++++++++++++++++++++++++++");
            });
            // ================ quarter selectbox ================
            $('#city-dd').change(function(event) {
                // Capture the selected city value
                var idCity = this.value;
                $('#quarter-dd').html('');
                $.ajax({
                    url: "/api/customers/fetch-quarters",
                    type: 'POST',
                    dataType: 'json',
                    data: {city_id: idCity,_token:"{{ csrf_token() }}"},
                    success:function(response)
                    {
                        console.log("Quarter = "+response.quarters);
                        $('#quarter-dd').html('<option value="">Select Quarter</option>');
                        $.each(response.quarters,function(index, val)
                        {
                            $('#quarter-dd').append('<option value="'+val.id+'">'+val.name+'</option>')
                        });
                    }
                })
            });
            // ++++++++++++ store "cities_id" in hidden inputField in "quarter modal" ++++++++++
            $("#add_quarters_btn_id").on('click', function(){
                var city_id = $("#city-dd").val();
                $("#cityId").val(city_id);
                console.log("+++++++++++++++++++++++++++ "+city_id+" +++++++++++++++++++++++++++");
            });
        });
    </script>
@endpush
