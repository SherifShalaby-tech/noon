<div class="card-body">
    <form action="{{ route('products.index') }}" method="get">
        <div class="row align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <div
                class="col-2 px-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="form-group product-filter">
                    {!! Form::select('category_id', $categories, null, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.category'),
                    ]) !!}
                </div>
            </div>

            <div
                class="col-2 px-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="form-group product-filter">
                    {!! Form::select('store_id', $stores, null, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.store'),
                    ]) !!}
                </div>
            </div>

            <div
                class="col-2 px-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="form-group product-filter">
                    {!! Form::select('unit_id', $units, null, ['class' => 'form-control select2', 'placeholder' => __('lang.unit')]) !!}
                </div>
            </div>

            <div
                class="col-2 px-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="form-group product-filter">
                    {!! Form::select('brand_id', $brands, null, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.brand'),
                    ]) !!}
                </div>
            </div>

            <div
                class="col-2 px-2 d-flex align-items-center @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <div class="form-group product-filter">
                    {!! Form::select('created_by', $users, null, [
                        'class' => 'form-control select2',
                        'placeholder' => __('lang.created_by'),
                    ]) !!}
                </div>
            </div>
            {{-- <div class="col-2"></div> --}}
            <div class="col-1">
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary width-100" title="search">
                        <i class="fa fa-eye"></i> {{ __('Search') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
