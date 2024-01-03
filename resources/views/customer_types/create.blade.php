<!-- ================== Modal 1 : createCustomerTypesModal ================== -->
<div class="modal modal-add-customer-type animate__animated" data-animate-in="animate__rollIn"
    data-animate-out="animate__rollOut" id="createCustomerTypesModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleStandardModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div
                class="modal-header mb-4 d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{ __('lang.add_customer_type') }}</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open([
                'route' => 'customertypes.store',
                'method' => 'post',
                'files' => true,
                'id' => 'customer-type-form',
            ]) !!}
            <div class="modal-body  p-0">
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <label class="modal-label-width mx-2 mb-0" for="name">@lang('lang.name')</label>
                    <div
                        class="select_body input-wrapper d-flex justify-content-between align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <input type="text" required
                            class="initial-balance-input my-0 @if (app()->isLocale('ar')) text-end  @else text-start @endif"
                            style="width: 100%" placeholder="@lang('lang.name')" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <button class="add-button d-flex justify-content-center align-items-center" type="button"
                            data-toggle="collapse" data-target="#translation_table_customertype" aria-expanded="false"
                            aria-controls="collapseExample">
                            <i class="fas fa-globe"></i>
                        </button>
                    </div>

                    @include('layouts.translation_inputs', [
                        'attribute' => 'name',
                        'translations' => [],
                        'type' => 'customertype',
                    ])
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- ================== Modal 1 : createCustomerTypesModal ================== -->
<div class="modal fade" id="createCustomerTypesModal2" tabindex="-1" role="dialog"
    aria-labelledby="exampleStandardModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  rollIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{ __('lang.add_customer_type') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open([
                'route' => 'customertypes.store',
                'method' => 'post',
                'files' => true,
                'id' => 'customer-type-form2',
            ]) !!}
            <div class="modal-body">
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <label class="modal-label-width mx-2 mb-0" for="name">@lang('lang.name')</label>
                    <div
                        class="select_body input-wrapper d-flex justify-content-between align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <input type="text" required
                            class="initial-balance-input my-0 @if (app()->isLocale('ar')) text-end  @else text-start @endif"
                            style="width: 100%" placeholder="@lang('lang.name')" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <button class="add-button d-flex justify-content-center align-items-center" type="button"
                            data-toggle="collapse" data-target="#translation_table_customertype" aria-expanded="false"
                            aria-controls="collapseExample">
                            <i class="fas fa-globe"></i>
                        </button>
                    </div>

                    @include('layouts.translation_inputs', [
                        'attribute' => 'name',
                        'translations' => [],
                        'type' => 'customertype',
                    ])
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- ================== Modal 2 : createRegionModal ================== -->
<div class="modal  modal-add-region animate__animated" data-animate-in="animate__rollIn"
    data-animate-out="animate__rollOut" id="createRegionModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleStandardModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div
                class="modal-header mb-4 d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{ __('lang.add_region') }}</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open([
                'route' => 'customers.storeRegion',
                'method' => 'post',
                'files' => true,
                'id' => 'customer-region-form',
            ]) !!}
            <div class="modal-body p-0">
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                    {{-- store "state_id" in "hidden inputField" to send it to "storeRegion() method" in CustomerController --}}
                    <input type="hidden" name="state_id" id="stateId" />
                    <label class="modal-label-width mx-2 mb-0" for="name">@lang('lang.name')</label>
                    <div
                        class="select_body input-wrapper d-flex justify-content-between align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <input type="text" required id="cityNameId"
                            class="initial-balance-input my-0 @if (app()->isLocale('ar')) text-end  @else text-start @endif"
                            style="width: 100%" placeholder="@lang('lang.name')" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button type="submit" id="addNewRegion" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- ================== Modal 3 : createQuarterModal ================== -->
<div class="modal  modal-add-quarter animate__animated" data-animate-in="animate__rollIn"
    data-animate-out="animate__rollOut" id="createQuarterModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleStandardModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div
                class="modal-header mb-4 d-flex justify-content-between py-0 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="exampleStandardModalLabel">{{ __('lang.add_quarter') }}</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open([
                'route' => 'customers.storeQuarter',
                'method' => 'post',
                'files' => true,
                'id' => 'customer-quarter-form',
            ]) !!}
            <div class="modal-body  p-0">
                <div
                    class=" d-flex mb-2 align-items-center form-group  @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif ">
                    {{-- store "city_id" in "hidden inputField" to send it to "storeQuarter() method" in CustomerController --}}
                    <input type="hidden" name="city_id" id="cityId" />
                    <label class="modal-label-width mx-2 mb-0" for="name">@lang('lang.name')</label>
                    <div
                        class="select_body input-wrapper d-flex justify-content-between align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                        <input type="text" required
                            class="initial-balance-input my-0 @if (app()->isLocale('ar')) text-end  @else text-start @endif"
                            style="width: 100%" placeholder="@lang('lang.name')" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button type="submit" id="addNewQuarter" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var modelEl = $('.modal-add-customer-type');

        modelEl.addClass(modelEl.attr('data-animate-in'));

        modelEl.on('hide.bs.modal', function(event) {
                if (!$(this).attr('is-from-animation-end')) {
                    event.preventDefault();
                    $(this).addClass($(this).attr('data-animate-out'))
                    $(this).removeClass($(this).attr('data-animate-in'))
                }
                $(this).removeAttr('is-from-animation-end')
            })
            .on('animationend', function() {
                if ($(this).hasClass($(this).attr('data-animate-out'))) {
                    $(this).attr('is-from-animation-end', true);
                    $(this).modal('hide')
                    $(this).removeClass($(this).attr('data-animate-out'))
                    $(this).addClass($(this).attr('data-animate-in'))
                }
            })
    })
    $(document).ready(function() {
        var modelEl = $('.modal-add-region');

        modelEl.addClass(modelEl.attr('data-animate-in'));

        modelEl.on('hide.bs.modal', function(event) {
                if (!$(this).attr('is-from-animation-end')) {
                    event.preventDefault();
                    $(this).addClass($(this).attr('data-animate-out'))
                    $(this).removeClass($(this).attr('data-animate-in'))
                }
                $(this).removeAttr('is-from-animation-end')
            })
            .on('animationend', function() {
                if ($(this).hasClass($(this).attr('data-animate-out'))) {
                    $(this).attr('is-from-animation-end', true);
                    $(this).modal('hide')
                    $(this).removeClass($(this).attr('data-animate-out'))
                    $(this).addClass($(this).attr('data-animate-in'))
                }
            })
    })
    $(document).ready(function() {
        var modelEl = $('.modal-add-quarter');

        modelEl.addClass(modelEl.attr('data-animate-in'));

        modelEl.on('hide.bs.modal', function(event) {
                if (!$(this).attr('is-from-animation-end')) {
                    event.preventDefault();
                    $(this).addClass($(this).attr('data-animate-out'))
                    $(this).removeClass($(this).attr('data-animate-in'))
                }
                $(this).removeAttr('is-from-animation-end')
            })
            .on('animationend', function() {
                if ($(this).hasClass($(this).attr('data-animate-out'))) {
                    $(this).attr('is-from-animation-end', true);
                    $(this).modal('hide')
                    $(this).removeClass($(this).attr('data-animate-out'))
                    $(this).addClass($(this).attr('data-animate-in'))
                }
            })
    })
</script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CustomerTypeRequest', '#customer-type-form') !!}

<script>
    // $(document).ready(function(){
    //     // $("#addNewRegion").on('click',function(e){
    //     //     e.preventDefault();
    //     //     console.log("0000000000000000000000000000");
    //     //     if( $("#cityNameId").val() )
    //     //     {
    //     //         $.ajax({
    //     //             method:"POST",
    //     //             url:"{{ route('customers.storeRegion') }}",
    //     //             data:{
    //     //                 'name'      : $("#cityNameId").val(),
    //     //                 'state_id'  : $("#stateId").val(),
    //     //                 _token :'{{ csrf_token() }}'
    //     //             },
    //     //             success:function(results)
    //     //             {
    //     //                 console.log(results);
    //     //                 $('#city-dd').html('');
    //     //                 $('#city-dd'+'option').each(function(){
    //     //                     $(this).remove();
    //     //                 });
    //     //                 $.each(results, function(index,value){
    //     //                     $('#city-dd').append('<option value="'+value.id+'">'+value.name+'</option>');
    //     //                 });
    //     //                 // $('#city-dd').addClass('selectpicker').selectpicker("render");
    //     //                 $("#createRegionModal").style("display","none");
    //     //             }
    //     //         });
    //     //     }
    //     // });
    //     // $(document).on("submit", "#customer-region-form", function (e) {
    //     //     console.log("++++++++++++++++++++++ Cities +++++++++++++++++++++");
    //     //     e.preventDefault();
    //     //         var data = $(this).serialize();
    //     //         $.ajax({
    //     //             method: "post",
    //     //             url: $(this).attr("action"),
    //     //             dataType: "json",
    //     //             data: data,
    //     //             success: function (result) {
    //     //                 console.log("First Ajax Request : ",result);
    //     //                 if (result.success) {
    //     //                     Swal.fire("Success", result.msg, "success");
    //     //                     $("#createRegionModal").modal("hide");
    //     //                     var city_id = result.id;
    //     //                     console.log("Outer Second Ajax Request : ",result);
    //     //                     $.ajax({
    //     //                             method: "get",
    //     //                             url: "/customers/get-dropdown-city",
    //     //                             // data: {},
    //     //                             contactType: "html",
    //     //                             success: function (data_html) {
    //     //                                 console.log("Inner Second Ajax Request : ",data_html);
    //     //                                 $("#city-dd").empty().append(data_html[0]);
    //     //                                 $("#city-dd").val(data_html[1]).change();;
    //     //                             },
    //     //                             error: function (e)
    //     //                             {
    //     //                                 console.log("Error", e);
    //     //                             }
    //     //                         });
    //     //                 } else {
    //     //                     Swal.fire("Error", result.msg, "error");
    //     //                 }
    //     //             },
    //     //         });
    //     // });
    // });
</script>
