<div class="modal fade add-store" wire:ignore tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open([
                'url' => route('store.store'),
                'method' => 'post',
                'id' => isset($quick_add) && $quick_add ? 'quick_add_store_form' : 'add_store',
            ]) !!}
            <div
                class="modal-header d-flex justify-content-between py-2 @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h5 class="modal-title" id="exampleLargeModalLabel">@lang('lang.add_store')</h5>
                <button type="button" class="close mx-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse
                        @else
                        flex-row @endif">
                    {!! Form::label('branch_id', __('lang.branch'), [
                        'class' => 'modal-label-width',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                    <div class="input-wrapper" style="width: 60%;margin: auto;">
                        {!! Form::select('branch_id', $branches, null, [
                            'class' => 'form-select',
                            'placeholder' => __('lang.branch'),
                        ]) !!}
                    </div>
                </div>
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    <input type="hidden" name="quick_add"
                        value="{{ isset($quick_add) && $quick_add ? $quick_add : '' }}">
                    {!! Form::label('name', __('lang.name'), [
                        'class' => 'modal-label-width',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) . '*' !!}
                    <div class="input-wrapper" style="width: 60%;margin: auto;">
                        {!! Form::text('name', null, [
                            'class' => 'form-control initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                            'placeholder' => __('lang.name'),
                            'required',
                        ]) !!}
                    </div>
                </div>
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('phone_number', __('lang.phone_number'), [
                        'class' => 'modal-label-width',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                    <div class="input-wrapper" style="width: 60%;margin: auto;">
                        {!! Form::text('phone_number', null, [
                            'class' => 'form-control initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                            'placeholder' => __('lang.phone_number'),
                        ]) !!}
                    </div>
                </div>
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('email', __('lang.name'), [
                        'class' => 'modal-label-width',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                    <div class="input-wrapper" style="width: 60%;margin: auto;">
                        {!! Form::text('email', null, [
                            'class' => 'form-control initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                            'placeholder' => __('lang.email'),
                        ]) !!}
                    </div>
                </div>
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('manager_name', __('lang.manager_name'), [
                        'class' => 'modal-label-width',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                    <div class="input-wrapper" style="width: 60%;margin: auto;">
                        {!! Form::text('manager_name', null, [
                            'class' => 'form-control initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                            'placeholder' => __('lang.manager_name'),
                        ]) !!}
                    </div>
                </div>
                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('manager_mobile_number', __('lang.manager_mobile_number'), [
                        'class' => 'modal-label-width',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                    <div class="input-wrapper" style="width: 60%;margin: auto;">
                        {!! Form::text('manager_mobile_number', null, [
                            'class' => 'form-control initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                            'placeholder' => __('lang.manager_mobile_number'),
                        ]) !!}
                    </div>
                </div>

                <div
                    class=" d-flex mb-2 align-items-center form-group @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                    {!! Form::label('details', __('lang.details'), [
                        'class' => 'modal-label-width',
                        'style' => 'font-size: 12px;font-weight: 500;',
                    ]) !!}
                    {!! Form::textarea('email', null, [
                        'class' => 'form-control initial-balance-input my-0 app()->isLocale("ar")? text-end : text-start',
                        'style' => 'width:60%',
                        'placeholder' => __('lang.details'),
                        'rows' => '2',
                    ]) !!}
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('lang.close')</button>
                <button id="create-store-btn" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
