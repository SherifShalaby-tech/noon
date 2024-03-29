<?php

namespace App\Http\Controllers;

use App\Utils\Util;
use App\Models\User;
use App\Models\System;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\SellLine;
use App\Utils\ProductUtil;
use App\Models\AddStockLine;
use Illuminate\Http\Request;
use App\Utils\TransactionUtil;
use App\Utils\CashRegisterUtil;
use App\Utils\NotificationUtil;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionSellLine;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\Factory;
use App\Models\CashRegisterTransaction;
use App\Models\Customer;
use App\Models\PaymentTransactionSellLine;
use App\Models\ReceiptTransactionSellLinesFiles;
use App\Models\Store;
use Illuminate\Contracts\Foundation\Application;

class SellPosController extends Controller
{


    protected $commonUtil;
    protected $transactionUtil;
    protected $productUtil;
    protected $cashRegisterUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil, ProductUtil $productUtil, TransactionUtil $transactionUtil, CashRegisterUtil $cashRegisterUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
        $this->cashRegisterUtil = $cashRegisterUtil;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */

    public function index()
    {
        return view('invoices.index');
    }

    public function showInvoice(){
        //        dd(TransactionSellLine::all()->last());
        $transaction = TransactionSellLine::all()->last();
//        dd($transaction->transaction_sell_lines);
        $payment_types = $this->getPaymentTypeArrayForPos();
        $invoice_lang = request()->session()->get('language');

        return view('invoices.partials.invoice',compact('transaction','payment_types','invoice_lang'));
    }

    public  function print($id){
        try {
            $transaction = TransactionSellLine::find($id);

            $payment_types = $this->commonUtil->getPaymentTypeArrayForPos();

            $invoice_lang = System::getProperty('invoice_lang');
            if (empty($invoice_lang)) {
                $invoice_lang = request()->session()->get('language');
            }

            if (empty($transaction->received_currency_id)) {
            }

            $html_content = $this->transactionUtil->getInvoicePrint($transaction, $payment_types,null);

            $output = [
                'success' => true,
                'html_content' => $html_content,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return $output;
    }
    public function show_payment($id){
        $transaction = TransactionSellLine::find($id);
        $payment_type_array = $this->commonUtil->getPaymentTypeArrayForPos();
        return view('transaction_payment.show')->with(compact(
            'transaction',
            'payment_type_array'
        ));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        //Check if there is a open register, if no then redirect to Create Register screen.
        if ($this->cashRegisterUtil->countOpenedRegister() == 0) {
            return redirect()->to('/cash-register/create?is_pos=1');
        }

        return view('invoices.create');
    }

    /* ++++++++++++++++++++++++ store() ++++++++++++++++++++++++++ */
    public function store(Request $request)
    {
        if (!empty($request->is_quotation))
        {
            $transaction_data['is_quotation'] = 1;
            // status = draft : عشان مفيش دفع حيث بيكون عملية حجز
            $transaction_data['status'] = 'draft';
            $transaction_data['invoice_no'] = $this->productUtil->getNumberByType('quotation');
            $transaction_data['block_qty'] = !empty($request->block_qty) ? 1 : 0;
            $transaction_data['block_for_days'] = !empty($request->block_for_days) ? $request->block_for_days : 0; //reverse the block qty handle by command using cron job
            $transaction_data['validity_days'] = !empty($request->validity_days) ? $request->validity_days : 0;
        }
        $transaction = TransactionSellLine::create($transaction_data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $sell_line = TransactionSellLine::find($id);
        $payment_type_array = $this->commonUtil->getPaymentTypeArrayForPos();

        return view('invoices.show')->with(compact(
            'sell_line',
            'payment_type_array',
        ));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy($id)
    {
        try {
            $transaction = TransactionSellLine::find($id);
            DB::beginTransaction();
            $sell_lines = $transaction->transaction_sell_lines;
            foreach ($sell_lines as $sell_line) {
                if ($transaction->status == 'final') {
                    $this->productUtil->updateProductQuantityStore($sell_line->product_id, $sell_line->variation_id, $transaction->store_id, $sell_line->quantity + $sell_line->extra_quantity - $sell_line->quantity_returned);
                    if(isset($sell_line->stock_line_id)){
                        $stock = AddStockLine::where('id',$sell_line->stock_line_id)->first();
                        $stock->update([
                            'quantity_sold' =>  $stock->quantity_sold - $sell_line->quantity
                        ]);
                    }
                }
                $sell_line->delete();
            }
            $return_ids =TransactionSellLine::where('return_parent_id', $id)->pluck('id');

            TransactionSellLine::where('return_parent_id', $id)->delete();
            TransactionSellLine::where('parent_sale_id', $id)->delete();
            CashRegisterTransaction::wherein('transaction_id', $return_ids)->delete();
            $transaction->delete();
            CashRegisterTransaction::where('transaction_id', $id)->delete();


            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        return $output;
    }
    // ++++++++++++++++++++++ multiDeleteRow ++++++++++++++++++++++
    public function multiDeleteRow(Request $request)
    {
        // dd($request);
        try
        {
            DB::beginTransaction();
            $delete_all_id_array = explode(',',$request->delete_all_id);
            // dd($delete_all_id_array);
            TransactionSellLine::whereIn('id',$delete_all_id_array)->delete();
            $output = [
                'success' => true,
                'msg' => __('lang.delete_msg')
            ];
            DB::commit();
        }
        catch (\Exception $e)
        {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return redirect()->back()->with('status', $output);
    }

    public function getPaymentTypeArrayForPos()
    {
        return [
            'cash' => __('lang.cash'),
        ];
    }

    public function upload_receipt($id){

        return view('invoices.partials.upload_receipt_modal',compact('id'));
    }
    public function store_upload_receipt(Request $request){
        try {
            DB::beginTransaction();
            if($request->hasFile('receipts')){
                foreach ($request->file('receipts') as $file){
                    $receipt = new ReceiptTransactionSellLinesFiles;
                    $receipt->transaction_sell_line_id = $request->transaction_id;
                    $receipt->path =  store_file($file, 'receipt');
                    $receipt->save();
                }
                DB::commit();
                $output = [
                    'success' => true,
                    'msg' => __('lang.success')
                ];
            }
            else{
                $output = [
                    'success' => false,
                    'msg' => __('lang.no_file_chosen')
                ];
            }

        }
        catch (\Exception $e){
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }
        return redirect()->back()->with('status', $output);
    }
    public function show_receipt($line_id){
        $uploaded_files = ReceiptTransactionSellLinesFiles::where('transaction_sell_line_id',$line_id)->get();
        return view('general.uploaded_files',compact('uploaded_files'));
    }
    public function addPayment($transaction_id)
    {
        $payment_type_array = $this->commonUtil->getPaymentTypeArray();
        $transaction = TransactionSellLine::find($transaction_id);
        $users = User::Notview()->pluck('name', 'id');
        // $balance = $this->transactionUtil->getCustomerBalanceExceptTransaction($transaction->customer_id,$transaction_id)['balance'];
        $balance = Customer::find($transaction->customer_id)->balance??0;
        $dollar_balance = Customer::find($transaction->customer_id)->dollar_balance??0;
        $dollar_finalTotal = $transaction->dollar_final_total;
        $finalTotal = $transaction->final_total;
        $transactionPaymentsSum = $transaction->transaction_payments->sum('amount');
        $dollar_transactionPaymentsSum = $transaction->transaction_payments->sum('dollar_amount');
        if ($balance > 0 && $balance < $finalTotal - $transactionPaymentsSum) {
            if (isset($transaction->return_parent)) {
                $amount = $finalTotal - $transactionPaymentsSum - $transaction->return_parent->final_total - $balance;
            } else {
                $amount = $finalTotal - $transactionPaymentsSum - $balance;
            }
        } else {
            if (isset($transaction->return_parent)) {
                $amount = $finalTotal - $transactionPaymentsSum - $transaction->return_parent->final_total;
            } else {
                $amount = $finalTotal - $transactionPaymentsSum;
            }
        }
        if ($dollar_balance > 0 && $dollar_balance < $dollar_finalTotal - $dollar_transactionPaymentsSum) {
            if (isset($transaction->return_parent)) {
                $dollar_amount = $dollar_finalTotal - $dollar_transactionPaymentsSum - $transaction->return_parent->dollar_final_total - $dollar_balance;
            } else {
                $dollar_amount = $dollar_finalTotal - $dollar_transactionPaymentsSum - $dollar_balance;
            }
        } else {
            if (isset($transaction->return_parent)) {
                $dollar_amount = $dollar_finalTotal - $dollar_transactionPaymentsSum - $transaction->return_parent->dollar_final_total;
            } else {
                $dollar_amount = $dollar_finalTotal - $dollar_transactionPaymentsSum;
            }
        }
        return view('invoices.partials.add_payment')->with(compact(
            'payment_type_array',
            'transaction_id',
            'transaction',
            'users',
            'balance','dollar_balance',
            'amount','dollar_amount'
        ));
    }
    public function editInvoice($id){
        $stores=Store::latest()->pluck('name','id')->toArray();
        return view('invoices.edit',compact('id','stores'));
    }
}
