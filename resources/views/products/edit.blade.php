@extends('layouts.app')
@section('title', __('lang.edit_products'))
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@section('breadcrumbbar')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">@lang('lang.edit_products')</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('lang.dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">@lang('lang.products')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.edit_products')</li>
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
                {!! Form::open([
                    'route' => ['products.update', $product->id],
                    'method' => 'put',
                    'enctype' => 'multipart/form-data',
                    'id' => 'edit_product_form'
                ]) !!}
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::label('brand', __('lang.brand'), ['class' => 'h5 pt-3']) !!}
                        <div class="d-flex justify-content-center">
                            {!! Form::select('brand_id', $brands, $product->brand_id, [
                                'class' => 'form-control select2',
                                'placeholder' => __('lang.please_select'),
                                'id' => 'brand_id',
                            ]) !!}
                            <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal"
                                data-target="#createBrandModal"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="col-md-3">
                        {!! Form::label('store', __('lang.store'), ['class' => 'h5 pt-3']) !!}
                        <div class="d-flex justify-content-center">
                            @php $selected_stores=$product->stores->pluck('id'); @endphp
                            {!! Form::select('store_id[]', $stores, $selected_stores, [
                                'class' => 'form-control selectpicker ',
                                'multiple' => 'multiple',
                                'id' => 'store_id',
                            ]) !!}
                            <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal"
                                data-target=".add-store" href="{{ route('store.create') }}"><i
                                    class="fas fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="col-md-3">
                        {!! Form::label('name', __('lang.product_name'), ['class' => 'h5 pt-3']) !!}
                        <div class="d-flex justify-content-center">
                            {!! Form::text('name', $product->name, [
                                'class' => 'form-control required',
                            ]) !!}
                            <button class="btn btn-primary btn-sm ml-2" type="button" data-toggle="collapse"
                                data-target="#translation_table_product" aria-expanded="false"
                                aria-controls="collapseExample">
                                <i class="fas fa-globe"></i>
                            </button>
                        </div>
                        @error('name')
                            <label class="text-danger error-msg">{{ $message }}</label>
                        @enderror
                        @include('layouts.translation_inputs', [
                            'attribute' => 'name',
                            'translations' => $product->translations,
                            'type' => 'product',
                            'open_input' => true,
                        ])
                    </div>
                    <div class="col-md-1">
                        {!! Form::label('product_symbol', __('lang.product_symbol'), ['class' => 'h5 pt-3']) !!}
                        {!! Form::text('product_symbol',  isset($product->product_symbol)?$product->product_symbol:null, [
                            'class' => 'form-control'
                        ]) !!}
                        <br>
                        @error('product_symbol')
                            <label class="text-danger error-msg">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        {!! Form::label('sku', __('lang.product_code'), ['class' => 'h5 pt-3']) !!}
                        {!! Form::text('product_sku', $product->sku, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>

                    {{-- ++++++++++++++++ product categories ++++++++++++++++ --}}
                    <div class="col-md-12">
                        <div class="row">
                            {{-- +++++++++++++++++ category +++++++++++++++++ --}}
                            <div class="col-md-3" >
                                {!! Form::label('category', __('lang.category'). ' 1', ['class' => 'h5 pt-3']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('products[0][category_id]', $categories1, $product->category_id ?? null, [
                                        'class' => 'form-control select2 category',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'categoryId',

                                    ]) !!}

                                    <a  data-href="{{ route('categories.sub_category_modal') }}" data-container=".view_modal"
                                        class="btn btn-primary text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                                        data-select_category="0"><i class="fas fa-plus"></i>
                                    </a>
                                </div>
                                @error('products.0.category_id')
                                <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            {{-- +++++++++++++++++ sub_category1 +++++++++++++++++ --}}
                            <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.category') . ' 2', ['class' => 'h5 pt-3']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('products[0][subcategory_id1]', $categories2, $product->subcategory_id1  ?? null, [
                                        'class' => 'form-control select2 subcategory',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subcategory_id1'
                                    ]) !!}
                                    <a data-href="{{route('categories.sub_category_modal')}}"  data-container=".view_modal" class="btn btn-primary  text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                                       data-select_category="1"><i class="fas fa-plus"></i></a>
                                </div>
                                @error('products.0.category_id')
                                <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            {{-- +++++++++++++++++ sub_category2 +++++++++++++++++ --}}
                            <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.category') . ' 3', ['class' => 'h5 pt-3']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('products[0][subcategory_id2]', $categories3,$product->subcategory_id2 ?? null, [
                                        'class' => 'form-control select2 subcategory2',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subCategoryId2'
                                    ]) !!}
                                    <a data-href="{{route('categories.sub_category_modal')}}"  data-container=".view_modal" class="btn btn-primary  text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                                       data-select_category="2"><i class="fas fa-plus"></i></a>
                                </div>
                                @error('products.0.subcategory_id2')
                                <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            {{-- +++++++++++++++++ sub_category3 +++++++++++++++++ --}}
                            <div class="col-md-3">
                                {!! Form::label('subcategory', __('lang.category') . ' 4', ['class' => 'h5 pt-3']) !!}
                                <div class="d-flex justify-content-center">
                                    {!! Form::select('products[0][subcategory_id3]', $categories4, $product->subcategory_id1 ?? null, [
                                        'class' => 'form-control select2 subcategory3',
                                        'placeholder' => __('lang.please_select'),
                                        'id' => 'subCategoryId3',
                                    ]) !!}
                                    <a data-href="{{route('categories.sub_category_modal')}}"  data-container=".view_modal" class="btn btn-primary  text-white btn-sm ml-2 openCategoryModal" data-toggle="modal"
                                       data-select_category="3"><i class="fas fa-plus"></i></a>
                                </div>
                                @error('products.0.subcategory_id3')
                                <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- +++++++++++++++++++++++ "tax_method" selectbox +++++++++++++++++++++++ --}}
                    <div class="col-md-3">
                        <label for="method" class="h5 pt-3">{{ __('lang.tax_method') . ':*' }}</label>
                        <select name="method" id="method" class='form-control select2' data-live-search='true'
                            placeholder="{{ __('lang.please_select') }}">
                            <option value="">{{ __('lang.please_select') }}</option>
                            <option {{ old('method', $product['method']) == 'inclusive' ? 'selected' : '' }}
                                value="inclusive">{{ __('lang.inclusive') }}</option>
                            <option {{ old('method', $product['method']) == 'exclusive' ? 'selected' : '' }}
                                value="exclusive">{{ __('lang.exclusive') }}</option>
                        </select>
                    </div>
                    {{-- +++++++++++++++++++++++ "product_tax" selectbox +++++++++++++++++++++++ --}}
                    <div class="col-md-3">
                        <label for="product_tax_id" class="h5 pt-3">{{ __('lang.product_tax') . ':*' }}</label>
                        <div class="d-flex justify-content-center">
                            <select name="product_tax_id" id="product_tax" class="form-control select2"
                                placeholder="{{ __('lang.please_select') }}">
                                <option value="">{{ __('lang.please_select') }}</option>
                                @foreach ($product_tax as $tax)
                                    <option
                                     @if ($product_tax_id == $tax->id) selected @endif

                                value="{{ $tax->id }}"> {{ $tax->name }}
                                </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal"
                                data-target="#add_product_tax_modal" data-select_category="2"><i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    {{-- +++++++++++++++++++++++ "balance return request"  +++++++++++++++++++++++ --}}
                    <div class="col-md-3">
                        {!! Form::label('balance_return_request', __('lang.balance_return_request'), ['class' => 'h5 pt-3']) !!}
                        {!! Form::text('balance_return_request',  isset($product->balance_return_request)?$product->balance_return_request:null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="col-md-12 product_unit_raws[0]">
                        @php
                            $index = 0;
                        @endphp

                        @if (count($product->variations) > 0)

                            @foreach ($product->variations as $index => $variation)
                                <div class="row">

                                    @if($index == 0 )
                                        <div class="col-md-2 pl-5">
                                            {!! Form::label('sku', __('lang.product_code'),['class'=>'h5 pt-3']) !!}
                                            {!! Form::text('products[0][variations][0][sku]',$variation->sku ?? null, [
                                                'class' => 'form-control'
                                            ]) !!}
                                            <br>
                                            @error('sku.0')
                                            <label class="text-danger error-msg">{{ $message }}</label>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::label('unit', __('lang.large_filling'), ['class'=>'h5 pt-3']) !!}
                                            <div class="d-flex justify-content-center">
                                                <select name="products[0][variations][0][new_unit_id]"  data-name='unit_id' data-index="0"  class="form-control unit_select select2 unit_id0" style="width: 100px;" data-key="0">
                                                    <option value="">{{__('lang.please_select')}}</option>
                                                    @foreach($units as $unit)
                                                        <option @if( isset($variation->unit_id) &&($variation->unit_id == $unit->id)) selected @endif  value="{{$unit->id}}">{{$unit->name}}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-primary btn-sm ml-2 add_unit_raw" data-toggle="modal" data-index="0" data-target=".add-unit" href="{{route('units.create')}}"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 pt-4">
                                            <button class="btn btn btn-warning add_small_unit" type="button" data-key="0">
                                                <i class="fa fa-equals"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="products[{{ $key ?? 0 }}][variations][{{$index ?? 0 }}][variation_id]" value="{{$variation->id ?? null}}">
                                    @else
                                            @include('products.product_unit_raw', [
                                                'index' => $index,
                                                'variation' => $variation,
                                                'key'=> 0,
                                            ])
                                    @endif
                                 </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-md-2 pl-5">
                                    {!! Form::label('sku', __('lang.product_code'),['class'=>'h5 pt-3']) !!}
                                    {!! Form::text('products[0][variations][0][sku]',$variation->sku ?? null, [
                                        'class' => 'form-control'
                                    ]) !!}
                                    <br>
                                    @error('sku.0')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    {!! Form::label('unit', __('lang.large_filling'), ['class'=>'h5 pt-3']) !!}
                                    <div class="d-flex justify-content-center">
                                        <select name="products[0][variations][0][new_unit_id]"  data-name='unit_id' data-index="0"  class="form-control unit_select select2 unit_id0" style="width: 100px;" data-key="0">
                                            <option value="">{{__('lang.please_select')}}</option>
                                            @foreach($units as $unit)
                                                <option @if( isset($variation->unit_id) &&($variation->unit_id == $unit->id)) selected @endif  value="{{$unit->id}}">{{$unit->name}}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-primary btn-sm ml-2 add_unit_raw" data-toggle="modal" data-index="0" data-target=".add-unit" href="{{route('units.create')}}"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-2 pt-4">
                                    <button class="btn btn btn-warning add_small_unit" type="button" data-key="0">
                                        <i class="fa fa-equals"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="products[{{ $key ?? 0 }}][variations][{{$index ?? 0 }}][variation_id]" value="{{$variation->id ?? null}}">

                            </div>

                            {{--                            @include('products.product_unit_raw', ['index' => 0])--}}
                        @endif
                        @php
                            if (count($product->variations) > 0) {
                                $index = count($product->variations) - 1;
                            } else {
                                $index = 0;
                            }
                        @endphp
                        <input type="hidden" id="raw_unit_index[0]" value="{{ $index }}" data-key="0" />
                    </div>
                    {{-- sizes --}}
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 pt-5 ">
                                <h5 class="text-primary">{{ __('lang.product_dimensions') }}</h5>
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('height', __('lang.height'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('height', isset($product->product_dimensions->height) ? $product->product_dimensions->height : 0, [
                                    'class' => 'form-control height','id' => 'height0', 'data-key' => '0'
                                ]) !!}
                                <br>
                                @error('height')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('length', __('lang.length'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('length', isset($product->product_dimensions->length) ? $product->product_dimensions->length : 0, [
                                    'class' => 'form-control length','id' => 'length0', 'data-key' => '0'
                                ]) !!}
                                <br>
                                @error('length')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                {!! Form::label('width', __('lang.width'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('width', isset($product->product_dimensions->width) ? $product->product_dimensions->width : 0, [
                                    'class' => 'form-control width','id' => 'width0', 'data-key' => '0'
                                ]) !!}
                                <br>
                                @error('width')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('size', __('lang.size'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('size', isset($product->product_dimensions->size) ? $product->product_dimensions->size : 0, [
                                    'class' => 'form-control size','id' => 'size0', 'data-key' => '0'
                                ]) !!}
                                <br>
                                @error('size')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('weight', __('lang.weight'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::text('weight', isset($product->product_dimensions->weight) ? $product->product_dimensions->weight : 0, [
                                    'class' => 'form-control',
                                ]) !!}
                                <br>
                                @error('weight')
                                    <label class="text-danger error-msg">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('variation', __('lang.basic_unit_for_import_product'), ['class' => 'h5 pt-3']) !!}
                                {!! Form::select('variation_id',$basic_units, isset($product->product_dimensions->variations->unit->id) ? $product->product_dimensions->variations->unit->id : 0, [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('lang.please_select'),
                                    'id' => 'products[0][variation_id]',
                                ]) !!}
                            </div>
                        </div>

                    </div>
                    {{-- crop image --}}
                    <div class="col-md-12 pt-5">
                        <div class="row">
                            <div class="col-md-12 pt-5">
                                <div class="form-group">
                                    <div class="container-fluid mt-3">
                                        <div class="row mx-0" style="border: 1px solid #ddd;padding: 30px 0px;">
                                            <div class="col-12 p3 text-center">
                                                <label for="projectinput2" class='h5'>
                                                    {{ __('lang.product_image') }}</label>
                                            </div>
                                            <div class="col-5">
                                                <div class="mt-3">
                                                    <div class="row">
                                                        <div class="col-10 offset-1">
                                                            <div class="variants">
                                                                <div class='file file--upload w-100'>
                                                                    <div class="file-input">
                                                                        <input type="file" name="file-input"
                                                                            id="file-input-image"
                                                                            class="file-input__input" />
                                                                        <label class="file-input__label"
                                                                            for="file-input-image">
                                                                            <i class="fas fa-cloud-upload-alt"></i>&nbsp;
                                                                            <span>{{ __('lang.upload_image') }}</span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 offset-1">
                                                <div class="preview-image-container">
                                                    @if (!empty($product->image))
                                                        <div class="preview">
                                                            <img src="{{ asset('uploads/products/' . $product->image) }}"
                                                                id="image_footer" alt="">
                                                            <button type="button"
                                                                class="btn btn-xs btn-danger delete-btn remove_image "
                                                                data-type="image"><i style="font-size: 25px;"
                                                                    class="fa fa-trash"></i></button>
                                                            <span class="btn btn-xs btn-primary  crop-btn"
                                                                id="crop-image-btn" data-toggle="modal"
                                                                data-target="#imageModal"><i style="font-size: 25px;"
                                                                    class="fas fa-crop"></i></span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="cropped_images"></div>
                    {{-- crop image --}}

                    {{-- product description --}}
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="container-fluid">
                                    <div class="form-group">
                                        <label for="details" class="h5 pt-5">{{ __('lang.product_details') }}&nbsp;
                                            <button class="btn btn-primary btn-sm ml-2" type="button"
                                                data-toggle="collapse" data-target="#translation_details_product"
                                                aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fas fa-globe"></i>
                                            </button></label>
                                        {!! Form::textarea('details', $product->details, ['class' => 'form-control', 'id' => 'product_details']) !!}
                                        @include('layouts.translation_textarea', [
                                            'attribute' => 'details',
                                            'translations' => $product->details_translations,
                                            'type' => 'product',
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">@lang('lang.save')</button>
                </div>
                <div class="col-md-6">
                    <input type="hidden" value="0" class="add_stock_val" name="add_stock_val"/>
                    <button type="submit" class="btn btn-primary add_stock">@lang('lang.add-stock')</button>
                </div>
                {!! Form::close() !!}
            </div>
            @include('products.crop-image-modal')
        </div>
    </div>
    </div>
    @include('store.create', ['quick_add' => $quick_add])
    @include('units.create', ['quick_add' => $quick_add])
    @include('brands.create', ['quick_add' => $quick_add])
    @include('categories.create_modal', ['quick_add' => $quick_add])
    @include('product-tax.create', ['quick_add' => 1])

@endsection
@push('javascripts')
    <link rel="stylesheet" href="//fastly.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    <script src="{{ asset('js/product/product.js') }}"></script>
    <script src="{{ asset('css/crop/crop-image.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\UpdateProductRequest','#edit_product_form'); !!}


    <script>
        // edit Case
        @if (!empty($product->image) && isset($product->image))
            document.getElementById("crop-image-btn").addEventListener('click', () => {
                console.log(("#imageModal"))
                setTimeout(() => {
                    launchImageCropTool(document.getElementById("image_footer"));
                }, 500);
            });
            let deleteImageBtn = document.getElementById("deleteBtn");
            if (deleteImageBtn) {
                deleteImageBtn.getElementById("deleteBtn").addEventListener('click', () => {
                    if (window.confirm('Are you sure you want to delete this image?')) {
                        $("#preview").remove();
                    }
                });
            }
        @endif
        $(document).on('click','.add_stock',function(e){
            e.preventDefault();
            var add_stock_val=parseInt($('.add_stock_val').val());
            $('.add_stock_val').val(1);
            $(document).off('click', '.add_stock');
            $('.add_stock').submit();
        });
    </script>
@endpush

