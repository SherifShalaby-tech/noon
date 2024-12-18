<?php

namespace App\Http\Livewire\Invoices;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Brand;
use App\Models\Store;
use App\Models\System;
use App\Models\JobType;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\SellLine;
use App\Models\StorePos;
use App\Models\Supplier;
use App\Models\MoneySafe;
use App\Models\Variation;
use App\Models\GeneralTax;
use App\Models\AddStockLine;
use App\Models\CashRegister;
use App\Models\ProductStore;
use Livewire\WithPagination;
use App\Models\StockTransaction;
use App\Models\CustomerOfferPrice;
use App\Models\CustomerPriceOffer;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionSellLine;
use Illuminate\Contracts\View\View;
use App\Models\MoneySafeTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Models\CashRegisterTransaction;
use App\Models\CustomerType;
use App\Models\StockTransactionPayment;
use App\Models\PaymentTransactionSellLine;
use App\Models\TransactionCustomerOfferPrice;
use Illuminate\Contracts\Foundation\Application;

class Edit1 extends Component
{
    use WithPagination;

    public $transaction_sell_line , $client_id , $store_pos , $store_pos_id , $brands , $brand_id , $divide_costs , $other_expenses = 0, $other_payments = 0 , $block_for_days , $tax_method , $validity_days , $store_id,$block_qty, $customer_id , $customers,$stores, $status, $order_date, $purchase_type,
        $invoice_no, $discount_amount, $source_type, $payment_status, $source_id, $supplier, $exchange_rate, $amount, $method,
        $paid_on, $paying_currency, $transaction_date, $notes, $notify_before_days, $due_date, $showColumn = false,
        $transaction_currency, $current_stock, $clear_all_input_stock_form, $searchProduct, $items = [], $department_id,
        $files, $upload_documents , $discount_type , $discount_value , $total_cost , $dollar_total_cost_var=[] , $total_cost_var=[] ,
        $old_products = [] , $selling_price , $dollar_selling_price , $deleted_ids = [];

    protected $rules =
    [
        'store_id' => 'required',
        'customer_id' => 'required',
        'supplier' => 'required',
        'status' => 'required',
        'paying_currency' => 'required',
        'purchase_type' => 'required',
        'payment_status' => 'required',
        'method' => 'required',
        'amount' => 'required',
        'transaction_currency' => 'required'
    ];
    // Get "customers" and "stores"
    public function mount($id)
    {
        $this->transaction_sell_line = TransactionSellLine::with('transaction_sell_lines')->find($id);
        $this->store_id = $this->transaction_sell_line->store_id;
        $this->client_id    = $this->transaction_sell_line->customer_id;
        $this->store_pos_id = $this->transaction_sell_line->store_pos_id;
        $this->brands = Brand::orderby('created_at', 'desc')->pluck('name', 'id');
        $this->brand_id = $this->transaction_sell_line->brand_id;
        // dd($this->transaction_sell_line);
        foreach ($this->transaction_sell_line->transaction_sell_lines as  $line)
        {
            $this->addLineProduct($line);
        }
        // dd(Auth::user()->id);
        $store_pos = StorePos::find($this->store_pos_id);
        // if (empty($store_pos)) {
        //     $this->dispatchBrowserEvent('NoUserPos');
        // }
        // if (!empty($store_pos))
        // {
        //     $this->stores = !empty($store_pos->user) ? $store_pos->user->employee->stores()->pluck('name', 'id')->toArray() : [];
        //     $branch = $store_pos->user->employee->branch;
        //     $this->store_id = array_key_first($this->stores);
        //     // $this->changeAllProducts();
        // }
        // +++++++++++++++++++++++++ Put "Old value" on "selectboxes" and "inputFields" +++++++++++++++++++++++++
        $transaction_sell_line = $this->transaction_sell_line;
        // dd($transaction_sell_line);
        $this->selling_price = $transaction_sell_line->sell_price;
        $this->dollar_selling_price = $transaction_sell_line->dollar_sell_price;
        // dd($transaction_sell_line->dollar_sell_price);
        $this->block_qty = $transaction_sell_line->block_qty;
        $this->block_for_days = $transaction_sell_line->block_for_days;
        $this->validity_days = $transaction_sell_line->validity_days;
        $this->tax_method = $transaction_sell_line->tax_method;
        $this->discount_type = $transaction_sell_line->discount_type;
        $this->discount_value = $transaction_sell_line->discount_value;
        $this->store_id = $transaction_sell_line->store_id;
        $this->customer_id = $transaction_sell_line->customer_id;
    }
    // +++++++++ Get "customers" +++++++++
    public function loadCustomers()
    {
        $this->customers = Customer::all();
    }
    // +++++++++ Get "stores" +++++++++
    public function loadStores()
    {
        $this->stores = Store::all();
    }
    // ++++++++++++++++++++++++++++++++++ render() == index() method ++++++++++++++++++++++++++++++++++
    public function render(): Factory|View|Application
    {
        $transaction_sell_line = $this->transaction_sell_line;
        $departments = Category::where('parent_id' ,'!=',null)->get();

        $this->customers = Customer::orderBy('created_by', 'asc')->get();
        // dd($customer_offer_price);
        $status_array = $this->getPurchaseOrderStatusArray();
        $payment_status_array = $this->getPaymentStatusArray();
        $payment_type_array = $this->getPaymentTypeArray();
        $payment_types = $payment_type_array;
        $product_id = request()->get('product_id');
        $suppliers  = Supplier::orderBy('name', 'asc')->pluck('name', 'id', 'exchange_rate')->toArray();
        // ++++++++++++++ stores filter ++++++++++++++
        $this->stores   = Store::latest()->pluck('name','id')->toArray();
        // ++++++++++++++ customers filter ++++++++++++++
        $customers   = Customer::get();
        $stock_lines = AddStockLine::get();
        $taxes      = GeneralTax::get();
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        $preparers = JobType::with('employess')->where('title','preparer')->get();
        // $stores = Store::getDropdown();
        $departments = Category::get();
        $search_result = '';
        if(!empty($this->searchProduct))
        {
            $search_result = Product::when($this->searchProduct,function ($query)
            {
                return $query->where('name','like','%'.$this->searchProduct.'%');
            });
            $search_result = $search_result->paginate();
            if(count($search_result) === 1){
                $this->add_product($search_result->first()->id);
                $search_result = '';
                $this->searchProduct = '';
            }
        }

        if ($this->source_type == 'pos') {
            $users = StorePos::pluck('name', 'id');
        } elseif ($this->source_type == 'store') {
            $users = Store::pluck('name', 'id');
        } elseif ($this->source_type == 'safe') {
            $users = MoneySafe::pluck('name', 'id');
        } else {
            $users = User::Notview()->pluck('name', 'id');
        }
        if(!empty($this->department_id)){
            $products = Product::where('category_id' , $this->department_id)->get();
        }
        else{
            $products = Product::paginate();
        }

        // dd($old_products);

        $this->changeExchangeRate();
        $this->dispatchBrowserEvent('initialize-select2');

        $this->store_pos=StorePos::latest()->pluck('name','id')->toArray();
        $allproducts = Product::with(['stock_lines.transaction.transaction_payments'])->get();
        $customer_types = CustomerType::latest()->pluck('name', 'id');
        return view('livewire.invoices.edit',
            compact(
            'customer_types',
            'allproducts',
            'departments',
            'selected_currencies',
            'search_result',
            'users'));
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function quantityAvailable($product)
    {
        $quantity_available = ProductStore::where('product_id', $product->id)->where('store_id', $this->store_id)
            ->first()->quantity_available ?? 0;

        return $quantity_available;
    }
    // +++++++++++++++++++++++++ addLineProduct($line) : Add line product information +++++++++++++++++++++++++
    public function addLineProduct($line)
    {
        $product = Product::find($line->product_id);
        // dd($line);
        $this->items[] =
        [
            'product' => $product,
            'quantity' => number_format($line->quantity,num_of_digital_numbers()),
            'price' => !empty($line->sell_price) ? $this->num_uf(number_format($line->sell_price,num_of_digital_numbers())) : 0,
            'category_id' => $product->category?->id,
            'extra_quantity' => 0,
            'customer_id' => $product->customer?->id,
            'discount' => null,
            'quantity_available' => $this->quantityAvailable($product),
            'discount_price' => $line->discount_amount,
            'discount_type' =>  $line->discount_type,
            'dollar_price' => !empty($line->dollar_sell_price) ? number_format($line->dollar_sell_price,num_of_digital_numbers()) : 0  ,
            'customer_offer_id' => $line->id,
            'selling_price' => $line->sell_price ,
            'dollar_selling_price' => $line->dollar_sell_price,
        ];
    }
    // ++++++++++++++++++++++++++++++++++ store() method : new ++++++++++++++++++++++++++++++++++
    public function store(): Redirector|Application|RedirectResponse
    {
        $this->validate([
            'store_id' => 'required',
            'customer_id' => 'required',
            'block_for_days' => 'required',
            'validity_days' => 'required',
        ]);
        try
        {
            DB::beginTransaction();

            // ++++++++++++++++++++++ update "Transaction Customer Offer Price" table ++++++++++++++++++++++
            $transaction_data =
            [
                // store_id
                'store_id' => $this->store_id,
                // customer_id
                'customer_id' => $this->customer_id,
                 // is_quotation
                'is_quotation' => 1 ,
                // transaction_date
                'transaction_date' => !empty($this->transaction_date) ? $this->transaction_date : Carbon::now() ,
                'status' => $this->status,
                // dinar_sell_price
                'sell_price' => $this->num_uf($this->sum_total_cost()) ,
                'total_sell_price' => isset( $this->discount_value) ? ( $this->num_uf($this->sum_total_cost()) - $this->discount_value) :  $this->num_uf($this->sum_total_cost() ) ,
                // dollar_sell_price
                'dollar_sell_price' => $this->num_uf($this->sum_dollar_total_cost()) ,
                'total_dollar_sell_price' => isset($this->discount_value) ? ($this->num_uf($this->sum_dollar_total_cost()) - $this->discount_value) : $this->num_uf($this->sum_dollar_total_cost()) ,
                // status
                'status' => "draft" ,
                // block_qty , block_for_days , validity_days , tax_method
                'block_qty' => !empty($this->block_qty) ? 1 : 0 ,
                'block_for_days' => !empty($this->block_for_days) ? $this->block_for_days : 0 , //reverse the block qty handle by command using cron job
                'validity_days' => !empty($this->validity_days) ? $this->validity_days : 0 ,
                'tax_method' => !empty($this->tax_method) ? $this->tax_method : null ,
                // discount_type , discount_value
                'discount_type' => !empty($this->discount_type) ? $this->discount_type : null ,
                'discount_value' => !empty($this->discount_value) ? $this->discount_value : null ,
                // created_by
                'created_by' => $this->transaction_sell_line->created_by ,
                'updated_by' => Auth::user()->id ,
                'deleted_by' => null ,
                'created_at' => $this->transaction_sell_line->created_at  ,
                'updated_at' => now() ,
                'deleted_at' => null ,
            ];
            $transaction_sell_line = $this->transaction_sell_line;
            // dd($customer_offer_price);
            $transaction_sell_line->update($transaction_data);
            // ++++++++++++++++++++++ "Customer Offer Price" table : "Update" And "Insert" ++++++++++++++++++++++
            $keep_line_ids = [];
            // dd($this->deleted_ids);
            foreach ( $this->items as $index => $item)
            {
                // +++++++++++++++++ update Exsiting Products +++++++++++++++++++++
                if( !empty( $item['customer_offer_id'] ) )
                {
                    $prdouct_customer_offer = CustomerOfferPrice::find($item['customer_offer_id']);
                    // Set values for the new array
                    $prdouct_customer_offer['product_id'] = $item['product']['id'];
                    $prdouct_customer_offer['quantity'] = $item['quantity'];
                    $prdouct_customer_offer['sell_price'] = $item['selling_price'];
                    $prdouct_customer_offer['dollar_sell_price'] = $item['dollar_selling_price'];
                    // created_by
                    $prdouct_customer_offer['created_by'] = null;
                    // updated_by
                    $prdouct_customer_offer['updated_by'] = Auth::user()->id;
                    // deleted_by
                    $prdouct_customer_offer['deleted_by'] = null;
                    // created_at
                    $prdouct_customer_offer['created_at'] = null;
                    // updated_at
                    $prdouct_customer_offer['updated_at'] = now();
                    // deleted_at
                    $prdouct_customer_offer['deleted_at'] = null;
                    // +++ save "customer_offer_price id" +++++++++++++++
                    // $keep_line_ids[] = $prdouct_customer_offer->id;
                    // update the customer offer price for this item to the array
                    $prdouct_customer_offer->save();
                }
                // +++++++++++++++++ Insert New Products +++++++++++++++++++++
                else
                {
                    if (!empty($item['product']['id']) && !empty($item['quantity']))
                    {
                        // Create a new array for each item
                        $customer_offer_price_array = [];
                        // Set values for the new array
                        $customer_offer_price_array['transaction_customer_offer_id'] = $transaction_sell_line->id;
                        $customer_offer_price_array['product_id'] = $item['product']['id'];
                        $customer_offer_price_array['quantity'] = $item['quantity'];
                        $customer_offer_price_array['sell_price'] = $item['selling_price'];
                        $customer_offer_price_array['dollar_sell_price'] = $item['dollar_selling_price'];
                        $customer_offer_price_array['created_at'] = now();
                        // created_by
                        $customer_offer_price_array['created_by'] = Auth::user()->id;
                        // updated_by
                        $customer_offer_price_array['updated_by'] = null;
                        // deleted_by
                        $customer_offer_price_array['deleted_by'] = null;
                        // created_at
                        $customer_offer_price_array['created_at'] = now();
                        // updated_at
                        $customer_offer_price_array['updated_at'] = null;
                        // deleted_at
                        $customer_offer_price_array['deleted_at'] = null;
                        // Add the customer offer price for this item to the array
                        $customer_offer_prices[] = $customer_offer_price_array;
                    }
                    // Create multiple CustomerOfferPrice records in the database
                    $customer_offer_price_ids_var = CustomerOfferPrice::insert($customer_offer_prices);
                    // dd($customer_offer_price_ids_var);
                    // +++++++++++++++ save "all customer_offer_price_ids" +++++++++++++++
                    // $keep_line_ids[] = $customer_offer_prices->id ;
                    // dd($keep_line_ids);
                }
            }
            // Delete "all customer_offer_lines" which are deleted in "Edit" Page
            if( !empty($this->deleted_ids) )
            {
                for ($i=0; $i < count($this->deleted_ids) ; $i++)
                {
                    $prdouct_customer_offer = CustomerOfferPrice::find($this->deleted_ids[$i]);
                    $prdouct_customer_offer->delete();
                }
            }
            DB::commit();
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success', 'message' => 'lang.success']);
        }
        catch (\Exception $e)
        {
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error', 'message' => 'lang.something_went_wrongs']);
            dd($e);
        }
        return redirect()->route('customer_price_offer.create');
    }
    public function add_product($id, $add_via = null)
    {
        if(!empty($this->searchProduct)){
            $this->searchProduct = '';

        }

        $product = Product::find($id);
        $variations = $product->variations;

        if($add_via == 'unit'){
            $show_product_data = false;
            $this->addNewProduct($variations,$product,$show_product_data);
        }
        else{
            if(!empty($this->items)){
                $newArr = array_filter($this->items, function ($item) use ($product) {
                    return $item['product']['id'] == $product->id;
                });
                if (count($newArr) > 0) {
                    $key = array_keys($newArr)[0];
                    ++$this->items[$key]['quantity'];
        //                $this->items[$key]['sub_total'] = ( $this->items[$key]['price'] * $this->items[$key]['quantity'] ) -( $this->items[$key]['quantity'] * $this->items[$key]['discount']);
                }
                else{
                    $show_product_data = true;
                    $this->addNewProduct($variations,$product,$show_product_data);
                }
            }
            else{
                $show_product_data = true;
                $this->addNewProduct($variations,$product,$show_product_data);
            }
        }
    }
    // +++++++++++++++++++++++ addNewProduct() +++++++++++++++++++++++
    public function addNewProduct($variations,$product,$show_product_data)
    {
        $new_item = [
            'show_product_data' => $show_product_data,
            'variations' => $variations,
            'product' => $product,
            'quantity' => 1,
            'unit' => null,
            'base_unit_multiplier' => null,
            'sub_total' => 0,
            'dollar_sub_total' => 0,
            'size' => !empty($product->size) ? $product->size : 0,
            'total_size' => !empty($product->size) ? $product->size * 1 : 0,
            'weight' => !empty($product->weight) ? $product->weight : 0,
            'total_weight' => !empty($product->weight) ? $product->weight * 1 : 0,
            'dollar_cost' => 0,
            'cost' => 0,
            'dollar_total_cost' => 0,
            'total_cost' => 0,
            'current_stock' =>0,
            'total_stock' => 0 + 1,
        ];
        array_push($this->items, $new_item);
    }

    public function getVariationData($index){
       $variant = Variation::find($this->items[$index]['variation_id']);
       $this->items[$index]['unit'] = $variant->unit->name;
       $this->items[$index]['base_unit_multiplier'] = $variant->equal;
    }

    public function get_product($index){
        return Variation::where('id' ,$this->selectedProductData[$index]->id)->first();
    }

    public function total_size($index){
        $this->items[$index]['total_size'] =  (int)$this->items[$index]['quantity'] * (float)$this->items[$index]['size'];
        return  $this->items[$index]['total_size'];
    }

    public function total_weight($index){
        $this->items[$index]['total_weight'] = (int)$this->items[$index]['quantity'] * (float)$this->items[$index]['weight'] ;
       return $this->items[$index]['total_weight'];
    }

    public function sum_size(){
        $totalSize = 0;

        foreach ($this->items as $item) {
            $totalSize += $item['total_size'];
        }
        return $totalSize;
    }

    public function sum_weight()
    {
        $totalWeight = 0;

        foreach ($this->items as $item) {
            $totalWeight += $item['total_weight'];
        }
        return $totalWeight;
    }
    // ++++++++++++++++++++++++++ Task :  $ اجمالي التكاليف ++++++++++++++++++++++++++
    public function dollar_total_cost($index)
    {
        $this->items[$index]['dollar_total_cost'] = $this->items[$index]['dollar_selling_price'] * $this->items[$index]['quantity'];
        $this->items[$index]['dollar_total_cost_var'] = $this->items[$index]['dollar_total_cost'];
        return number_format($this->items[$index]['dollar_total_cost'], 2);
    }
    // ++++++++++++++++++++++++++ Task : اجمالي التكاليف بالدينار ++++++++++++++++++++++++++
    public function total_cost($index)
    {
        $this->items[$index]['total_cost'] = $this->items[$index]['selling_price'] * $this->items[$index]['quantity'];
        $this->items[$index]['total_cost_var'] = $this->items[$index]['total_cost'] ;
        return number_format($this->items[$index]['total_cost'],2) ;
    }
    // ++++++++++++++++++++++++++ Task : convert_dinar_price() : سعر البيع بالدينار ++++++++++++++++++++++++++
    public function convert_dinar_price($index)
    {
        // dd($this->exchange_rate);
        if (!empty($this->items[$index]['dollar_selling_price']) )
        {
            $this->items[$index]['selling_price'] = $this->items[$index]['dollar_selling_price'] * $this->exchange_rate;
        }
        else
        {
            $this->items[$index]['selling_price'] = $this->items[$index]['dollar_selling_price'];
        }
        // return $selling_price;
    }
    // ++++++++++++++++++++++++++ Task : convert_dollar_price() : سعر البيع بالدولار ++++++++++++++++++++++++++
    public function convert_dollar_price($index)
    {
        // dd($this->exchange_rate);
        if (!empty($this->items[$index]['selling_price']) )
        {
            $this->items[$index]['dollar_selling_price'] = $this->items[$index]['selling_price'] / $this->exchange_rate;
        }
        else
        {
            $this->items[$index]['dollar_selling_price'] = $this->items[$index]['selling_price'];
        }
        // return $selling_price;
    }

    // +++++++++++++++ sum_total_cost() : sum all "dinar_sell_price" values ++++++++++++++++
    public function sum_total_cost()
    {
        $totalCost = 0;
        if(!empty($this->items))
        {
            foreach ($this->items as $item)
            {
                $totalCost += (float)$item['total_cost'];
            }
        }
        return number_format($this->num_uf($totalCost),2);
    }
    // +++++++++++++++ sum_dollar_total_cost() : sum all "dollar_sell_price" values ++++++++++++++++
    public function sum_dollar_total_cost()
    {
        $totalDollarCost = 0;
        if(!empty($this->items))
        {
            foreach ($this->items as $item)
            {
                $totalDollarCost += $item['dollar_total_cost'];
            }
        }
        return number_format($totalDollarCost,2);
    }
    // ++++++++++++++++++++ sum_sub_total() : sum all "sell_price" values ++++++++++++++++
    public function sum_sub_total()
    {
        $totalSubTotal = 0;
        foreach ($this->items as $item)
        {
            $totalSubTotal += $item['sub_total'];
        }
        return number_format($totalSubTotal,2);
    }
    // +++++++++ Task : "مجموع اجمالي التكاليف " بالدولار +++++++++
    public function sum_dollar_sub_total()
    {
        $totalDollarSubTotal = 0;

        foreach ($this->items as $item)
        {
            $totalDollarSubTotal += $item['dollar_total_cost'];
        }
        return number_format($totalDollarSubTotal,2);
    }
    // +++++++++ Task : "مجموع اجمالي التكاليف " بالدينار +++++++++
    public function sum_dinar_sub_total()
    {
        $totalDinarSubTotal = 0;

        foreach ($this->items as $item)
        {
            $totalDinarSubTotal += $item['total_cost'];
        }
        return number_format($totalDinarSubTotal,2);
    }

    // public function changeCurrentStock($index)
    // {
    //     $this->items[$index]['total_stock'] = $this->items[$index]['quantity'] + $this->items[$index]['current_stock'];
    // }

    public function total_quantity(){
        $totalQuantity = 0;
        if(!empty($this->items)){
            foreach ($this->items as $item){
                $totalQuantity += (int)$item['quantity'];
            }
        }
       return $totalQuantity;
    }
    // +++++++++++ final_total() : get the final total cost in dollars +++++++++++++++++
    public function final_total()
    {
        if(isset($this->discount_amount)){
            return $this->sum_total_cost() - $this->discount_amount;
        }
        else
            return $this->sum_total_cost();
    }
    // +++++++++++ dollar_final_total() : get the final total cost in dollars +++++++++++++++++
    public function dollar_final_total()
    {
        if(isset($this->discount_value))
        {
            return $this->sum_dollar_total_cost() - $this->discount_value;
        }
        else
            return $this->sum_dollar_total_cost();
    }
    // +++++++++++++++++ When Click on "delete button" in products table : delete "product row" ++++++++++++++++
    public function delete_product($index)
    {
        $customer_offer_price = CustomerOfferPrice::find($this->items[$index]['customer_offer_id']);
        // Store "ids" of "All deleted customer_offer_price" items
        $this->deleted_ids[] = $customer_offer_price->id;
        // Delete From DB "customer_offer_prices table"
        // $customer_offer_price->delete();
        // Delete From View "Edit Page"
        unset($this->items[$index]);
    }

    public function getPurchaseOrderStatusArray()
    {
        return [
            'draft' => __('lang.draft'),
            'sent_admin' => __('lang.sent_to_admin'),
            'sent_supplier' => __('lang.sent_to_supplier'),
            'received' => __('lang.received'),
            'pending' => __('lang.pending'),
            'partially_received' => __('lang.partially_received'),
        ];
    }

    public function getPaymentStatusArray()
    {
        return [
            'partial' => __('lang.partially_paid'),
            'paid' => __('lang.paid'),
            'pending' => __('lang.pay_later'),
        ];
    }

    public function getPaymentTypeArray()
    {
        return [
            'cash' => __('lang.cash'),
        ];
    }

    public function getCurrentCashRegisterOrCreate($user_id)
    {
        $register =  CashRegister::where('user_id', $user_id)
            ->where('status', 'open')
            ->first();

        if (empty($register)) {
            $store_pos = StorePos::where('user_id', $user_id)->first();
            $register = CashRegister::create([
                'user_id' => $user_id,
                'status' => 'open',
                'store_id' => $this->store_id,
                'customer_id' => $this->customer_id,
                'store_pos_id' => !empty($store_pos) ? $store_pos->id : null
            ]);
        }

        return $register;
    }

    public function changeExchangeRate()
    {
        if (isset($this->supplier)){
            $supplier = Supplier::find($this->supplier);
            if(isset($supplier->exchange_rate)){
                $this->exchange_rate =  str_replace(',' ,'',$supplier->exchange_rate);
            }
            else
                $this->exchange_rate =System::getProperty('dollar_exchange');
        }
        else{
            $this->exchange_rate =System::getProperty('dollar_exchange');
        }
    }

    public function ShowDollarCol()
    {
        $this->showColumn= !$this->showColumn;
    }

    public function updateProductQuantityStore($product_id, $store_id, $new_quantity, $old_quantity = 0)
    {
        $qty_difference = $new_quantity - $old_quantity;

        if ($qty_difference != 0) {
            $product_store = ProductStore::where('product_id', $product_id)
                ->where('store_id', $store_id)
                ->first();

            if (empty($product_store)) {
                $product_store = new ProductStore();
                $product_store->product_id = $product_id;
                $product_store->store_id = $store_id;
                $product_store->quantity_available = 0;
            }

            $product_store->quantity_available += $qty_difference;
            $product_store->save();
        }

        return true;
    }
    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator  = ',';
        $decimal_separator  = '.';
        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);
        return (float)$num;
    }

}
