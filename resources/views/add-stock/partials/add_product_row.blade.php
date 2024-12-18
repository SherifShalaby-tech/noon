<tr>
    <td>
        {{-- <input type="hidden" name="selectedProductData" value="{{ json_encode($selectedProductData) }}"> --}}
        {{$index+1}} 
    </td>

    <td>
        <input type="text" class="form-control name"  wire:model="rows.{{ $index }}.name"  style="width: 61px;" required >
    </td>
    <td>
        <input type="text" class="form-control sku" wire:change="checkSku({{$index}})" wire:model="rows.{{ $index }}.sku" style="width: 61px;" required >
    </td>
    <td>
        <input type="text" class="form-control quantity" wire:change="calculateTotalQuantity()"  wire:model="rows.{{ $index }}.quantity" style="width: 61px;" required >
        @error('quantity')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td>
        <select wire:model="rows.{{ $index }}.unit_id" wire:change="changeUnit({{$index}})" class="form-control select2">
            <option value="">{{__('lang.please_select')}}</option>
            @foreach($units as $unit)
                <option value="{{$unit->id}}">{{$unit->name}}</option>
            @endforeach
        </select>

    </td>
    <td>
        <span>
            {{$rows[$index]['base_unit_multiplier']}}
        </span>
    </td>
    <td>
        @if(isset($rows[$index]['quantity']))
            <span class="total_quantity">
                {{$this->total_quantity($index) ?? 0}}
            </span>
        @endif
    </td>
    {{-- @if ($showColumn) --}}
        <td>
            <input type="text" class="form-control" wire:model="rows.{{ $index }}.dollar_purchase_price" style="width: 61px;" required>
            @error('purchase_price')
            <span class="error text-danger">{{ $message }}</span>
            @enderror
        </td>
        <td>
            <input type="text" class="form-control " wire:model="rows.{{ $index }}.dollar_selling_price" style="width: 61px;" required>
            @error('selling_price')
            <span class="error text-danger">{{ $message }}</span>
            @enderror
        </td>
        <td>
            @if(isset($rows[$index]['quantity']) &&  (isset($rows[$index]['dollar_purchase_price']) || isset($rows[$index]['purchase_price'])))
                <span class="sub_total_span" >
                    {{$this->dollar_sub_total($index)}}
                </span>
            @endif
        </td>
    {{-- @endif --}}
    <td>
        <input type="text" class="form-control" wire:model="rows.{{ $index }}.purchase_price" style="width: 61px;"  required>
        @error('purchase_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td>
        <input type="text" class="form-control " wire:model="rows.{{ $index }}.selling_price" style="width: 61px;" required>
        @error('selling_price')
        <span class="error text-danger">{{ $message }}</span>
        @enderror
    </td>
    <td>
        @if(isset($rows[$index]['quantity']) && (isset($rows[$index]['purchase_price']) || isset($dollar_purchase_price)))
            <span class="sub_total_span" >
                {{$this->sub_total($index)}}
            </span>
        @endif
    </td>
    <td>
        <input type="number" class="form-control size"  wire:model="rows.{{ $index }}.size" style="width: 61px;" required >
    </td>
    <td>
       @if(isset($rows[$index]['quantity']))
            <span class="total_size">
                {{$this->total_size($index) }}
            </span>
        @else
           {{0.00}}
        @endif
    </td>
    <td>
        <input type="number" class="form-control weight"  wire:model="rows.{{ $index }}.weight" style="width: 61px;" required >
    </td>
    <td>
       @if(isset($rows[$index]['quantity']))
            <span class="total_weight">
                {{$this->total_weight($index) }}
            </span>
        @else
           {{0.00}}
        @endif
    </td>
    {{-- @if ($showColumn) --}}
        <td>
        <input type="text" class="form-control dollar_cost"  wire:model="rows.{{ $index }}.dollar_cost" style="width: 61px;" required >
        </td>
        <td>
            @if(isset($rows[$index]['quantity']) && (isset($rows[$index]['dollar_purchase_price']) || isset($rows[$index]['purchase_price'])))
                <span class="dollar_total_cost">
                    {{$this->dollar_total_cost($index) }}
                </span>
            @else
                {{0.00}}
            @endif
        </td>
    {{-- @endif --}}
    <td>
        <input type="number" class="form-control cost"  wire:model="rows.{{ $index }}.cost" style="width: 61px;" required >
    </td>
    <td>
        @if(isset($rows[$index]['quantity']) && (isset($rows[$index]['purchase_price']) || isset($rows[$index]['dollar_purchase_price'])))
            <span class="total_cost">
                {{$this->total_cost($index) }}
            </span>
        @else
            {{0.00}}
        @endif
    </td>
    <td>
        <span class="current_stock_text">
            {{$rows[$index]['quantity'] ?? 0}}
        </span>
    </td>
    <td>
       <input type="checkbox"  wire:model="rows.{{ $index }}.change_price_stock">
    </td>
    <td  class="text-center">
        <div class="btn btn-sm btn-danger py-0 px-1 " wire:click="delete_product({{$index}})">
            <i class="fa fa-trash"></i>
        </div>
    </td>
</tr>
<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>
