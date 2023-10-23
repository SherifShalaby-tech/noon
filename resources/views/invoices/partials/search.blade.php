<div class="row mb-2">
    <div class="col-xl-2 ">
    </div>
    <div class="col-xl-7 ">
        <div class="row">
            <div class="col-md-3 m-t-15">
                <div class="search-box input-group">
                    @if(!empty($search_result) && !empty($search_by_product_symbol))
                        <ul id="ui-id-1" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2" style="top: 37.423px; left: 39.645px; width: 90.2%;">
                            @foreach($search_result as $product)
                                <li class="ui-menu-item" wire:click="add_product({{$product->id}})">
                                    <div id="ui-id-73" tabindex="-1" class="ui-menu-item-wrapper">
                                        <img src="https://mahmoud.s.sherifshalaby.tech/uploads/995_image.png" width="50px" height="50px">
                                        {{$product->sku ?? ''}} - {{$product->name}}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <div class="col-md-7 m-t-15">
                <div class="search-box input-group">
                    <button type="button" class="btn btn-secondary" id="search_button"><i
                            class="fa fa-search"></i>
                    </button>
                    <input type="search" name="search_product" id="search_product" wire:model.debounce.500ms="searchProduct"
                        placeholder="@lang('lang.enter_product_name_to_print_labels')"
                        class="form-control" autocomplete="off">

                    @if(!empty($search_result) && !empty($searchProduct))
                        <ul id="ui-id-1" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front rounded-2" style="top: 37.423px; left: 39.645px; width: 90.2%;">
                            @foreach($search_result as $product)
                                <li class="ui-menu-item" wire:click="add_product({{$product->id}})">
                                    <div id="ui-id-73" tabindex="-1" class="ui-menu-item-wrapper">
                                        <img src="https://mahmoud.s.sherifshalaby.tech/uploads/995_image.png" width="50px" height="50px">
                                        {{$product->sku ?? ''}} - {{$product->name}}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 ">
    </div>
   
</div>