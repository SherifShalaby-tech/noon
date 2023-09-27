<?php

namespace App\Http\Livewire\AddStock;

use App\Models\AddStockLine;
use App\Models\CashRegister;
use App\Models\CashRegisterTransaction;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\JobType;
use App\Models\MoneySafe;
use App\Models\MoneySafeTransaction;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\StockTransaction;
use App\Models\StockTransactionPayment;
use App\Models\Store;
use App\Models\StorePos;
use App\Models\Supplier;
use App\Models\System;
use App\Models\User;
use App\Models\Variation;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;

    public $divide_costs , $other_expenses = 0, $other_payments = 0, $store_id, $status, $order_date, $purchase_type,
        $invoice_no, $discount_amount, $source_type, $payment_status, $source_id, $supplier, $exchange_rate, $amount, $method,
        $paid_on, $paying_currency, $transaction_date, $notes, $notify_before_days, $due_date, $showColumn = false,
        $transaction_currency, $current_stock, $clear_all_input_stock_form, $searchProduct, $items, $department_id;

    protected $rules = [
    'store_id' => 'required',
    'supplier' => 'required',
    'status' => 'required',
    'paying_currency' => 'required',
    'purchase_type' => 'required',
    'payment_status' => 'required',
    'method' => 'required',
    'amount' => 'required',
    'transaction_currency' => 'required'
];

    public function mount(){
        $this->clear_all_input_stock_form = System::getProperty('clear_all_input_stock_form');
        if($this->clear_all_input_stock_form ==0){
            $transaction_payment=[];
            $recent_stock=[];
        }else{
            $recent_stock = StockTransaction::where('type','add_stock')->orderBy('created_at', 'desc')->first();
//dd($recent_stock);
            if(!empty($recent_stock)){
                $transaction_payment = $recent_stock->transaction_payments->first();
                $this->store_id =$recent_stock->store_id ??'' ;
                $this->supplier = $recent_stock->supplier_id??'';
                $this->status = $recent_stock->status ??'';
                $this->transaction_date = $recent_stock->transaction_date ??'';
                $this->transaction_currency = $recent_stock->transaction_currency ??'';
                $this->purchase_type = $recent_stock->purchase_type ??'';
                $this->divide_costs = $recent_stock->divide_costs ??'';
                $this->payment_status = $recent_stock->payment_status ??'';
                $this->invoice_no = $recent_stock->invoice_no ??'';
                $this->other_expenses = !empty((int)$recent_stock->other_expenses) ? $recent_stock->other_expenses : null;
                $this->discount_amount = !empty((int)$recent_stock->discount_amount) ? $recent_stock->discount_amount: null;
                $this->other_payments = !empty((int)$recent_stock->other_payments) ? $recent_stock->other_payments: null;
                $this->amount = $transaction_payment->amount ??'';
                $this->method = $transaction_payment->method ??'';
                $this->paying_currency = $transaction_payment->paying_currency ??'';
                $this->source_type =$transaction_payment->source_type ??'' ;
                $this->source_id = $transaction_payment->source_id ??'';
                $this->paid_on = $transaction_payment->paid_on ??'';



            }
        }
    }
    protected $listeners = ['listenerReferenceHere'];

    public function listenerReferenceHere($data)
    {
        if(isset($data['var1'])) {
            $this->{$data['var1']} = $data['var2'];
        }
//        dd(11);
    }

    public function render(): Factory|View|Application
    {
        $status_array = $this->getPurchaseOrderStatusArray();
        $payment_status_array = $this->getPaymentStatusArray();
        $payment_type_array = $this->getPaymentTypeArray();
        $payment_types = $payment_type_array;
        $product_id = request()->get('product_id');
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id', 'exchange_rate')->toArray();
        $currenciesId = [System::getProperty('currency'), 2];
        $selected_currencies = Currency::whereIn('id', $currenciesId)->orderBy('id', 'desc')->pluck('currency', 'id');
        $preparers = JobType::with('employess')->where('title','preparer')->get();
        $variations=Variation::orderBy('created_at','desc')->get();
        $stores = Store::getDropdown();
        $departments = Category::get();
        $search_result = '';
        if(!empty($this->searchProduct)){
            $search_result = Product::when($this->searchProduct,function ($query){
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

        $this->changeExchangeRate();
        $this->dispatchBrowserEvent('initialize-select2');


        return view('livewire.add-stock.create',
            compact('status_array',
            'payment_status_array',
            'payment_type_array',
            'stores',
            'product_id',
            'payment_types',
            'payment_status_array',
            'suppliers',
            'selected_currencies',
            'preparers' ,
            'products','variations',
            'departments',
            'search_result',
            'users'));
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store(): Redirector|Application|RedirectResponse
    {
        if (!empty($this->other_expenses) || !empty($this->other_payments)){
            $this->rules = [
                'store_id' => 'required',
                'supplier' => 'required',
                'status' => 'required',
                'paying_currency' => 'required',
                'purchase_type' => 'required',
                'divide_costs' => 'required',
                'payment_status' => 'required',
                'method' => 'required',
                'amount' => 'required',
            ];
        }

        $this->validate();

        try {

            // Add stock transaction
            $transaction = new StockTransaction();
            $transaction->store_id = $this->store_id;
            $transaction->status = $this->status;
            $transaction->order_date = !empty($this->order_date) ? $this->order_date : Carbon::now();
            $transaction->transaction_date = !empty($this->transaction_date) ? $this->transaction_date : Carbon::now();
            $transaction->purchase_type = $this->purchase_type;
            $transaction->type = 'add_stock';
            $transaction->invoice_no = !empty($this->invoice_no) ? $this->invoice_no : null;
            $transaction->discount_amount = !empty($this->discount_amount) ? $this->discount_amount : 0;
            $transaction->supplier_id = $this->supplier;
            $transaction->transaction_currency = $this->transaction_currency;
            $transaction->payment_status = $this->payment_status;
            $transaction->other_payments = !empty($this->other_payments) ? $this->other_payments : 0;
            $transaction->other_expenses = !empty($this->other_expenses) ? $this->other_expenses : 0;
            $transaction->grand_total = $this->sum_total_cost();
            $transaction->final_total = isset($this->discount_amount) ? ($this->sum_total_cost() - $this->discount_amount) : $this->sum_total_cost();
            $transaction->dollar_grand_total = $this->sum_dollar_total_cost();
            $transaction->dollar_final_total = $this->dollar_final_total();
            $transaction->notes = !empty($this->notes) ? $this->notes : null;
            $transaction->notify_before_days = !empty($this->notify_before_days) ? $this->notify_before_days : 0;
            $transaction->notify_me = !empty($this->notify_before_days) ? 1 : 0;
            $transaction->created_by = Auth::user()->id;
            $transaction->source_id = !empty($this->source_id) ? $this->source_id : null;
            $transaction->source_type = !empty($this->source_type) ? $this->source_type : null;
            $transaction->due_date = !empty($this->due_date) ? $this->due_date : null;
            $transaction->divide_costs = !empty($this->divide_costs) ? $this->divide_costs : null;


            DB::beginTransaction();
            // preparer_id
            // $transaction->preparer_id = !empty($this->preparer_id) ? $this->preparer_id : null;

            $transaction->save();


            // Add payment transaction
            if(!empty($this->amount)){
                $payment  = new StockTransactionPayment();
                $payment->stock_transaction_id  = $transaction->id;
                $payment->amount  = $this->amount;
                $payment->method = $this->method;
                $payment->paid_on = !empty($this->paid_on) ? $this->paid_on :  Carbon::now() ;
                $payment->source_type = !empty($this->source_type) ? $this->source_type : null;
                $payment->source_id = !empty($this->source_id) ? $this->source_id : null;
                $payment->payment_note =!empty($this->notes) ? $this->notes : null;
                $payment->created_by = Auth::user()->id;
                $payment->exchange_rate = $this->exchange_rate;
                $payment->paying_currency = $this->paying_currency;

                // check user and add money to user
                if  ($payment->method == 'cash'){
                    $user_id = null;
                    if (!empty($this->source_id)) {
                        if ($this->source_type == 'pos') {
                            $user_id = StorePos::where('id', $this->source_id)->first()->user_id;
                        }
                        if ($this->source_type == 'user') {
                            $user_id = $this->source_id;
                        }
                        if ($this->source_type == 'safe') {
                            $money_safe = MoneySafe::find($this->source_id);
                            $money_safe_Date = [
                                'created_by' => Auth::user()->id,
                                'type' => 'debit',
                                'source_type' => 'safe',
                                'source_id' => $this->source_id,
                                'store_id' =>  $this->store_id,
                                'transaction_date' => !empty($this->transaction_date) ? $this->transaction_date : Carbon::now(),
                                'currency_id' => $this->paying_currency,
                                'amount' => $this->amount,
                                'money_safe_id' => $money_safe->id,
                            ];
                            $transaction= $money_safe->transactions()->latest()->first();
                            if(!empty($transaction->balance)){
                                $money_safe_Date['balance'] = $money_safe_Date['amount'] + $transaction->balance;
                            }else{
                                $money_safe_Date['balance'] = $money_safe_Date['amount'];
                            }
                            MoneySafeTransaction::create($money_safe_Date);
                        }
                    }
                    if(!empty($user_id)){
                        $register =  $this->getCurrentCashRegisterOrCreate($user_id);
                        if (!empty($user_id)) {
                            $payments_formatted[] = new CashRegisterTransaction([
                                'amount' => $this->amount,
                                'pay_method' => $this->method,
                                'type' => 'debit',
                                'transaction_type' => 'add_stock',
                                'transaction_id' => $transaction->id,
                                'transaction_payment_id' => null
                            ]);
                        }
                        if (!empty($payments_formatted) && !empty($register)) {
                            $register->cash_register_transactions()->saveMany($payments_formatted);
                        }
                    }
                }
                $payment->save();
            }


            // add  products to stock lines
            foreach ($this->items as $index => $item){
                if (isset($this->product['change_price_stock']) && $this->product['change_price_stock']) {
                    if (isset($product->stock_lines)) {
                        foreach ($product->stock_lines as $line) {
                            $line->sell_price = !empty($item['selling_price']) ? $item['selling_price'] : null;
                            $line->dollar_sell_price = !empty($item['dollar_selling_price']) ? $item['dollar_selling_price'] : null;
                            $line->save();
                        }
                    }
                }
                $supplier = Supplier::find($this->supplier);
//                dd($item['variation']['id']);
                $add_stock_data = [
                    'variation_id' => $item['variation']['id'],
                    'product_id' => $item['product']['id'],
                    'stock_transaction_id' =>$transaction->id ,
                    'quantity' => $item['quantity'],
                    'purchase_price' => !empty($item['purchase_price']) ? $item['purchase_price'] : null ,
                    'final_cost' => !empty($item['total_cost']) ? $item['total_cost'] : null,
                    'sub_total' => !empty($item['sub_total']) ? $item['sub_total'] : null,
                    'sell_price' => !empty($item['selling_price']) ? $item['selling_price'] : null,
                    'dollar_purchase_price' => !empty($item['dollar_purchase_price']) ? $item['dollar_purchase_price'] : null,
                    'dollar_final_cost' => !empty($item['dollar_total_cost']) ? $item['dollar_total_cost'] : 0,
                    'dollar_sub_total' => !empty($item['dollar_sub_total']) ? $item['dollar_sub_total']: null,
                    'dollar_sell_price' => !empty($item['dollar_selling_price']) ? $item['dollar_selling_price'] : null,
                    'cost' => !empty($item['cost']) ?  $item['cost'] : null,
                    'dollar_cost' => !empty($item['dollar_cost']) ? $item['dollar_cost'] : null,
                    'expiry_date' => !empty($item['expiry_date']) ? $item['expiry_date'] : null,
                    'expiry_warning' => !empty($item['expiry_warning']) ? $item['expiry_warning'] : null,
                    'convert_status_expire' => !empty($item['convert_status_expire']) ? $item['convert_status_expire'] : null,
                    'exchange_rate' => !empty($supplier->exchange_rate) ? str_replace(',' ,'',$supplier->exchange_rate) : null,
                ];
                AddStockLine::create($add_stock_data);
                $this->updateProductQuantityStore($item['product']['id'], $transaction->store_id, $item['quantity'], 0);

            }

            DB::commit();

            $this->dispatchBrowserEvent('swal:modal', ['type' => 'success','message' => 'lang.success',]);
        }
        catch (\Exception $e){
            $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.something_went_wrongs',]);
            dd($e);
        }
        return redirect('/add-stock/create');
    }

    public function add_product($id){

        $variation = Variation::where('product_id',$id)->first();
//        dd($variation->unit->toArray('name','id'));
        $product = Product::find($id);
//        dd($product->stock_lines->sum('quantity' ,'-','quantity_sold', '+', 'quantity_returned'));
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
                $this->addNewProduct($variation,$product);
            }
        }
        else{
            $this->addNewProduct($variation,$product);
        }
//            dd($this->items);
    }
    public function addNewProduct($variation,$product){
        $current_stock = $product->stock_lines->sum('quantity' ,'-','quantity_sold', '+', 'quantity_returned');
        $this->items[] = [
            'variation' => $variation,
            'product' => $product,
            'quantity' => 1,
            'unit_name' => $product->unit->name ?? '',
            'base_unit_multiplier' => $product->unit->base_unit_multiplier ?? 1,
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
            'current_stock' =>$current_stock,
            'total_stock' => $current_stock + 1,
        ];
    }
    public function fetchSelectedProducts()
    {
        $this->emit('closeModal');
        $this->selectedProductData = Variation::whereIn('id', $this->selectedProducts)->get();

    }

    public function get_product($index){
        return Variation::where('id' ,$this->selectedProductData[$index]->id)->first();
    }

    public function sub_total($index)
    {
        if(isset($this->items[$index]['quantity']) && (isset($this->items[$index]['purchase_price']) ||isset($this->items[$index]['dollar_purchase_price']) )){
            // convert purchase price from Dollar To Dinar
            $purchase_price = $this->convertDollarPrice($index);

            $this->items[$index]['sub_total'] = (int)$this->items[$index]['quantity'] * (float)$purchase_price ;

            return number_format($this->items[$index]['sub_total'], 2);
        }
        else{
            $this->items[$index]['purchase_price'] = null;
        }
    }

    public function dollar_sub_total($index)
    {
        if(isset($this->items[$index]['quantity']) && ($this->items[$index]['dollar_purchase_price']) || isset($this->items[$index]['purchase_price'])){
            // convert purchase price from Dinar To Dollar
            $purchase_price = $this->convertDinarPrice($index);

            $this->items[$index]['dollar_sub_total'] = (int)$this->items[$index]['quantity'] * (float)$purchase_price;

            return number_format($this->items[$index]['dollar_sub_total'], 2);
        }
        else{
            $this->items[$index]['dollar_purchase_price'] = null;
        }
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

    public function sum_weight(){
        $totalWeight = 0;

        foreach ($this->items as $item) {
            $totalWeight += $item['total_weight'];
        }
        return $totalWeight;
    }

    public function cost($index){

        if($this->paying_currency == 2){
            $cost = ( (float)$this->other_expenses + (float)$this->other_payments ) * $this->exchange_rate;
        }
        else{
            $cost = (float)$this->other_expenses + (float)$this->other_payments ;
        }
        // convert purchase price from Dollar To Dinar
        $purchase_price = $this->convertDollarPrice($index);
//        dd($purchase_price);


        if (isset($this->divide_costs)){

            if ($this->divide_costs == 'size'){
                if($this->sum_size() >= 0){
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.sum_sizes_less_equal_zero']);
                    unset($this->divide_costs);
                }
                else{
                    (float)$this->items[$index]['cost'] = ( ( $cost / $this->sum_size() ) * $this->items[$index]['size'] ) + (float)$purchase_price;
                }
            }
            elseif ($this->divide_costs == 'weight'){
                if($this->sum_weight() >= 0){
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.sum_weights_less_equal_zero']);
                    unset($this->divide_costs);

                }
                else {
                    (float)$this->items[$index]['cost'] = (($cost / $this->sum_weight()) * $this->items[$index]['weight']) + (float)$purchase_price;
                }
            }
            else{
                (float)$this->items[$index]['cost'] = ( ( $cost / $this->sum_sub_total() ) * (float)$purchase_price ) + (float)$purchase_price;
            }
        }
        else{
            $this->items[$index]['cost'] = (float)$purchase_price;
        }

        return number_format($this->items[$index]['cost'],2);
    }

    public function total_cost($index){
        $this->items[$index]['total_cost'] = (float)$this->items[$index]['cost'] * $this->items[$index]['quantity'];
        return number_format($this->items[$index]['total_cost'],2) ;
}

    public function dollar_cost($index){


        if($this->paying_currency == 2){
            $dollar_cost = ( (float)$this->other_expenses + (float)$this->other_payments ) * $this->exchange_rate;
        }
        else{
            $dollar_cost = (float)$this->other_expenses + (float)$this->other_payments ;
        }
        // convert purchase price from Dinar to Dollar
       $purchase_price = $this->convertDinarPrice($index);

        if (isset($this->divide_costs)){

            if ($this->divide_costs == 'size'){
                if($this->sum_size() == 0){
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.sum_sizes_less_equal_zero']);
                    unset($this->divide_costs);
                }
                else{
                    (float)$this->items[$index]['dollar_cost'] = ( ( $dollar_cost / $this->sum_size() ) * $this->items[$index]['size'] ) + (float)$purchase_price;
                }
            }
            elseif ($this->divide_costs == 'weight'){
                if($this->sum_weight() == 0){
                    $this->dispatchBrowserEvent('swal:modal', ['type' => 'error','message' => 'lang.sum_weights_less_equal_zero']);
                    unset($this->divide_costs);

                }
                else {
                    (float)$this->items[$index]['dollar_cost'] = (($dollar_cost / $this->sum_weight()) * $this->items[$index]['weight']) + (float)$purchase_price;
                }
            }
            else{
                (float)$this->items[$index]['dollar_cost'] = ( ( $dollar_cost / $this->sum_dollar_sub_total() ) * (float)$purchase_price ) + (float)$purchase_price;
            }
        }
        else{
            $this->items[$index]['dollar_cost'] = (float)$purchase_price;
        }
        return number_format($this->items[$index]['dollar_cost'],2);
    }

    public function dollar_total_cost($index){
        $this->items[$index]['dollar_total_cost'] = $this->items[$index]['dollar_cost'] * $this->items[$index]['quantity'];
        return number_format($this->items[$index]['dollar_total_cost'], 2);

    }

    public function sum_total_cost(){
        $totalCost = 0;
        if(!empty($this->items)) {
            foreach ($this->items as $item) {
                $totalCost += $item['total_cost'];
            }
        }
        return number_format($totalCost,2);
    }

    public function sum_dollar_total_cost(){
        $totalDollarCost = 0;
        if(!empty($this->items)){
            foreach ($this->items as $item) {
//                dd($item['dollar_total_cost']);
                $totalDollarCost += $item['dollar_total_cost'];
            }
        }
//        dd($totalDollarCost);
        return number_format($totalDollarCost,2);
    }

    public function sum_sub_total(){
        $totalSubTotal = 0;

        foreach ($this->items as $item) {
            $totalSubTotal += $item['sub_total'];
        }
        return number_format($totalSubTotal,2);
    }

    public function sum_dollar_sub_total(){
        $totalDollarSubTotal = 0;

        foreach ($this->items as $item) {
            $totalDollarSubTotal += $item['dollar_sub_total'];
        }
        return number_format($totalDollarSubTotal,2);
    }

    public function changeCurrentStock($index){
        $this->items[$index]['total_stock'] = $this->items[$index]['quantity'] + $this->items[$index]['current_stock'];
    }

    public function total_quantity(){
        $totalQuantity = 0;
        if(!empty($this->items)){
            foreach ($this->items as $item){
                $totalQuantity += (int)$item['quantity'];
            }
        }
       return $totalQuantity;
    }
    public function final_total(){
        if(isset($this->discount_amount)){
            return $this->sum_total_cost() - $this->discount_amount;
        }
        else
            return $this->sum_total_cost();
    }

    public function dollar_final_total(){
        if(isset($this->discount_amount)){
            return $this->sum_dollar_total_cost() - $this->discount_amount;
        }
        else
            return $this->sum_dollar_total_cost();
    }

    public function delete_product($index){
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
                'store_pos_id' => !empty($store_pos) ? $store_pos->id : null
            ]);
        }

        return $register;
    }

    public function convertDollarPrice($index){
        if(empty($this->items[$index]['purchase_price']) && !empty($this->items[$index]['dollar_purchase_price'])){
            $purchase_price = (float)$this->items[$index]['dollar_purchase_price'] * $this->exchange_rate;
        }
        else{
            $purchase_price = $this->items[$index]['purchase_price'];
        }
        return $purchase_price;
    }

    public function convertDinarPrice($index)
    {
//        dd($this->purchase_price[$index]);
        if (!empty($this->items[$index]['purchase_price']) && empty($this->items[$index]['dollar_purchase_price'])) {
            $purchase_price = $this->items[$index]['purchase_price'] / $this->exchange_rate;
        }
        else {
            $purchase_price = $this->items[$index]['dollar_purchase_price'];
        }
        return $purchase_price;

    }

    public function changeExchangeRate(){
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

    public function ShowDollarCol(){
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


}
