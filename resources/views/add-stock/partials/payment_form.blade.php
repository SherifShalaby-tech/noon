<div class="col-md-3 mb-2 d-flex align-items-center  animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif payment_fields hide"
    style="animation-delay: 2.2s">
    {!! Form::label('amount', __('lang.amount'), [
        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
        'style' => 'font-size: 12px;font-weight: 500;',
    ]) !!}
    <div class="input-wrapper">
        <input style="width: 100%" type="number" placeholder="{{ __('lang.amount') }}"
            class="form-control initial-balance-input m-0" wire:model="total_amount">
    </div>
    @error('amount')
        <span style="font-size: 10px;font-weight: 700;" class="error text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="col-md-3 mb-2 d-flex align-items-center  animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif payment_fields hide"
    style="animation-delay: 2.25s">
    {!! Form::label('method', __('lang.payment_type'), [
        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
        'style' => 'font-size: 12px;font-weight: 500;',
    ]) !!}
    <div class="input-wrapper">

        {!! Form::select('method', $payment_type_array, $method, [
            'class' => 'form-control select2',
            'data-live-search' => 'true',
            'required',
            'placeholder' => __('lang.please_select'),
            'data-name' => 'method',
            'wire:model' => 'method',
            'wire:change' => 'show',
        ]) !!}
    </div>
    @error('method')
        <span style="font-size: 10px;font-weight: 700;" class="error text-danger">{{ $message }}</span>
    @enderror

</div>

<div class="col-md-3 mb-2 d-flex align-items-center  animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif"
    style="animation-delay: 2.3s">
    <label class= "@if (app()->isLocale('ar')) d-block text-end  mx-2 mb-0 width-quarter @endif  "
        style='font-size: 12px;font-weight: 500;' for="paying_currency">@lang('lang.paying_currency') </label>
    <div class="input-wrapper">

        {!! Form::select('paying_currency', $selected_currencies, $paying_currency, [
            'class' => 'form-control select2',
            'placeholder' => __('lang.please_select'),
            'data-live-search' => 'true',
            'required',
            'data-name' => 'paying_currency',
            'wire:model' => 'paying_currency',
            'wire:change' => 'changeTotalAmount()',
        ]) !!}
    </div>
    @error('paying_currency')
        <span style="font-size: 10px;font-weight: 700;" class="error text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="col-md-3 mb-2 d-flex align-items-center  animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif payment_fields hide"
    style="animation-delay: 2.35">
    {!! Form::label('paid_on', __('lang.payment_date'), [
        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
        'style' => 'font-size: 12px;font-weight: 500;',
    ]) !!}
    <div class="input-wrapper">
        {!! Form::date('paid_on', $paid_on, [
            'class' => 'form-control m-0 initial-balance-input width-full',
            'placeholder' => __('lang.payment_date'),
            'wire:model' => 'paid_on',
        ]) !!}
    </div>

</div>

<div class="col-md-3 mb-2 d-flex align-items-center  animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif payment_fields hide"
    style="animation-delay: 2.4s">
    {!! Form::label('upload_documents', __('lang.upload_documents'), [
        'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
        'style' => 'font-size: 12px;font-weight: 500;',
    ]) !!}

    <div class="initial-balance-input my-0 mr-0">
        <label for="upload_documents" style="width: 100%;height: 100%;"
            class="d-flex justify-content-evenly align-items-center">
            <i class="fas fa-cloud-upload-alt"></i>
            {{ __('lang.upload_image') }}
        </label>
        <input style="opacity: 0;" type="file" name="upload_documents[]" id="upload_documents"
            wire:model="upload_documents">
    </div>

</div>

@if ($method != 'cash')
    <div
        class="col-md-3 mb-2 d-flex align-items-center  animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif not_cash_fields ">
        {!! Form::label('ref_number', __('lang.ref_number') . '*', [
            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
            'style' => 'font-size: 12px;font-weight: 500;',
        ]) !!}
        <div class="input-wrapper">
            {!! Form::text(
                'ref_number',
                !empty($transaction_payment) && !empty($transaction_payment->ref_number)
                    ? $transaction_payment->ref_number
                    : (!empty($payment)
                        ? $payment->ref_number
                        : null),
                [
                    'class' => 'form-control not_cash width-full m-0 initial-balance-input',
                    'placeholder' => __('lang.ref_number'),
                    'wire:model' => 'ref_number',
                ],
            ) !!}
        </div>
        @error('ref_number')
            <span style="font-size: 10px;font-weight: 700;" class="error text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div
        class="col-md-3 mb-2 d-flex align-items-center  animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif not_cash_fields ">
        {!! Form::label('bank_deposit_date', __('lang.bank_deposit_date') . '*', [
            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
            'style' => 'font-size: 12px;font-weight: 500;',
        ]) !!}
        <div class="input-wrapper">

            {!! Form::date('bank_deposit_date', $bank_deposit_date, [
                'class' => 'form-control not_cash datepicker m-0 initial-balance-input width-full',
                'placeholder' => __('lang.bank_deposit_date'),
                'wire:model' => 'bank_deposit_date',
            ]) !!}
        </div>
        @error('bank_deposit_date')
            <span style="font-size: 10px;font-weight: 700;" class="error text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div
        class="col-md-3 mb-2 d-flex align-items-center  animate__animated animate__flipInX @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif not_cash_fields ">
        {!! Form::label('bank_name', __('lang.bank_name') . '*', [
            'class' => app()->isLocale('ar') ? 'd-block text-end  mx-2 mb-0 width-quarter' : 'mx-2 mb-0 width-quarter',
            'style' => 'font-size: 12px;font-weight: 500;',
        ]) !!}
        <div class="input-wrapper">

            {!! Form::text(
                'bank_name',
                !empty($transaction_payment) && !empty($transaction_payment->bank_name)
                    ? $transaction_payment->bank_name
                    : (!empty($payment)
                        ? $payment->bank_name
                        : null),
                [
                    'class' => 'form-control not_cash m-0 initial-balance-input width-full',
                    'placeholder' => __('lang.bank_name'),
                    'wire:model' => 'bank_name',
                ],
            ) !!}
        </div>
        @error('bank_name')
            <span style="font-size: 10px;font-weight: 700;" class="error text-danger">{{ $message }}</span>
        @enderror
    </div>
@endif
