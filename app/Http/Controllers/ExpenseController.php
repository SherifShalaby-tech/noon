<?php

namespace App\Http\Controllers;

use App\Models\CashRegisterTransaction;
use App\Models\ExpenseBeneficiary;
use App\Models\ExpenseCategory;
use App\Models\ExpenseTransaction;
use App\Models\ExpenseTransactionPayment;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expense_query = ExpenseTransaction::leftjoin('users', 'expense_transactions.created_by', 'users.id')
            ->leftjoin('employees', 'expense_transactions.source_id', 'employees.user_id')
            ->leftjoin('expense_transaction_payments', 'expense_transactions.id', 'expense_transaction_payments.transaction_id');

        return $expenses = $expense_query->select(
            'expense_transactions.*',
            'users.name as user_created_by',
        )
            ->orderBy('transaction_date', 'desc');
        $expense_categories = ExpenseCategory::pluck('name', 'id');
        $expense_beneficiaries = ExpenseBeneficiary::pluck('name', 'id');
        $stores = Store::pluck('name', 'id');
        return view('expense.index')->with(compact(
            'expenses',
            'expense_categories',
            'stores',
            'expense_beneficiaries'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expense_categories = ExpenseCategory::pluck('name', 'id');
        $payment_type_array = $this->getPaymentTypeArray();
        $stores = Store::getDropdown();
        $users = User::Notview()->pluck('name', 'id');

        return view('expense.create')->with(compact(
            'expense_categories',
            'payment_type_array',
            'stores',
            'users'
        ));
    }
    public function getPaymentTypeArray()
    {
        return [
            'cash' => __('lang.cash'),
            'card' => __('lang.credit_card'),
            'bank_transfer' => __('lang.bank_transfer'),
            'cheque' => __('lang.cheque'),
            'money_transfer' => 'Money Transfer',
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $i = 1;
        $day = Carbon::now()->day;
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $inv_count = ExpenseTransaction::count() + $i;
        $number = 'Exp' . $year . $month . $inv_count;
        try {
            $data = $request->except('_token');


            $expense_data = [
                'grand_total' => num_uf($data['amount']),
                'final_total' => num_uf($data['amount']),
                'store_id' => $data['store_id'],
                'type' => 'expense',
                'status' => 'final',
                'invoice_no' => $number,
                'transaction_date' => !empty($data['transaction_date']) ? ($data['transaction_date']) : Carbon::now(),
                'expense_category_id' => $data['expense_category_id'],
                'expense_beneficiary_id' => $data['expense_beneficiary_id'],
                'next_payment_date' => !empty($data['next_payment_date']) ? $data['next_payment_date'] : null,
                'details' => !empty($data['details']) ? $data['details'] : null,
                'notify_me' => !empty($data['notify_me']) ? 1 : 0,
                'notify_before_days' => !empty($data['notify_before_days']) ? $data['notify_before_days'] : 0,
                'source_id' => !empty($data['source_id']) ? $data['source_id'] : null,
                'source_type' => !empty($data['source_type']) ? $data['source_type'] : null,
                'payment_status' =>'paid',
            ];
            $expense_data['created_by'] = Auth::user()->id;

            DB::beginTransaction();
            $expense = ExpenseTransaction::create($expense_data);

            if ($request->has('upload_documents')) {
                foreach ($request->file('upload_documents', []) as $key => $file) {
                    $expense->addMedia($file)->toMediaCollection('expense');
                }
            }

            $payment_data = [
                'transaction_payment_id' =>  !empty($request->transaction_payment_id) ? $request->transaction_payment_id : null,
                'transaction_id' =>  $expense->id,
                'amount' => num_uf($request->amount),
                'method' => $request->method,
                'paid_on' => !empty($data['paid_on']) ? Carbon::createFromTimestamp(strtotime($data['paid_on']))->format('Y-m-d H:i:s') : Carbon::now(),
                'ref_number' => $request->ref_number,
                'card_number' => $request->card_number,
                'card_month' => $request->card_month,
                'card_year' => $request->card_year,
                'source_type' => $request->source_type,
                'source_id' => $request->source_id,
                'bank_deposit_date' => !empty($data['bank_deposit_date']) ? $data['bank_deposit_date'] : null,
                'bank_name' => $request->bank_name,
            ];

            $expense = ExpenseTransactionPayment::create($payment_data);

            // if ($payment_data['method'] == 'cash') {
            //     $user_id = null;
            //     if (!empty($request->source_id)) {
            //         if ($request->source_type == 'user' || $request->source_type == 'pos') {
            //             if ($request->source_type == 'pos') {
            //                 $user_id = StorePos::where('id', $request->source_id)->first()->user_id;
            //             }
            //             if ($request->source_type == 'user') {
            //                 $user_id = $request->source_id;
            //             }
            //             $this->cashRegisterUtil->addPayments($expense, $payment_data, 'debit', $user_id);
            //         }
            //         if ($request->source_type == 'safe') {
            //             $money_safe = MoneySafe::find($request->source_id);
            //             $payment_data['currency_id'] = System::getProperty('currency');
            //             $this->moneysafeUtil->addPayment($expense, $payment_data, 'debit', $transaction_payment->id, $money_safe);
            //         }
            //     }
            // }

            DB::commit();

            $output = [
                'success' => true,
                'msg' => __('lang.expense_added')
            ];
        } catch (\Exception $e) {
            Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('lang.something_went_wrong')
            ];
        }

        return redirect()->back()->with('status', $output);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = ExpenseTransaction::find($id);

        return view('expense.show')->with(compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = ExpenseTransaction::find($id);
        $payment_type_array = $this->getPaymentTypeArray();
        $expense_categories = ExpenseCategory::pluck('name', 'id');
        $expense_beneficiaries = ExpenseBeneficiary::where('expense_category_id', $expense->expense_category_id)->pluck('name', 'id');
        $stores = Store::getDropdown();
        $users = User::Notview()->pluck('name', 'id');

        return view('expense.edit')->with(compact(
            'expense',
            'stores',
            'users',
            'payment_type_array',
            'expense_beneficiaries',
            'expense_categories'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token', '_method', 'submit');

        $expense = ExpenseTransaction::where('id', $id)->first();

        $expense_data = [
            'grand_total' => $this->num_uf($data['amount']),
            'final_total' => $this->num_uf($data['amount']),
            'transaction_date' => !empty($data['transaction_date']) ? ($data['transaction_date']) : $expense->transaction_date,
            'expense_category_id' => $data['expense_category_id'],
            'expense_beneficiary_id' => $data['expense_beneficiary_id'],
            'next_payment_date' => !empty($data['next_payment_date']) ? $data['next_payment_date'] : null,
            'details' => !empty($data['details']) ? $data['details'] : null,
            'notify_me' => !empty($data['notify_me']) ? 1 : 0,
            'notify_before_days' => !empty($data['notify_before_days']) ? $data['notify_before_days'] : 0,
            'source_id' => !empty($data['source_id']) ? $data['source_id'] : null,
            'source_type' => !empty($data['source_type']) ? $data['source_type'] : null,
        ];
        $expense_data['created_by'] = Auth::user()->id;
        DB::beginTransaction();
        $expense->update($expense_data);

        if ($request->has('upload_documents')) {
            foreach ($request->file('upload_documents', []) as $key => $file) {
                $expense->addMedia($file)->toMediaCollection('expense');
            }
        }

        $payment_data = [
            // 'transaction_payment_id' =>  !empty($request->transaction_payment_id) ? $request->transaction_payment_id : null,
            'transaction_id' =>  $expense->id,
            'amount' => $this->num_uf($request->amount),
            'method' => $request->method,
            'paid_on' => !empty($data['paid_on']) ? Carbon::createFromTimestamp(strtotime($data['paid_on']))->format('Y-m-d H:i:s') : Carbon::now(),
            'ref_number' => $request->ref_number,
            'card_number' => $request->card_number,
            'card_month' => $request->card_month,
            'card_year' => $request->card_year,
            'source_type' => $request->source_type,
            'source_id' => $request->source_id,
            'bank_deposit_date' => !empty($data['bank_deposit_date']) ? $data['bank_deposit_date'] : null,
            'bank_name' => $request->bank_name,
        ];
        $expense_payment = ExpenseTransactionPayment::where('id', $request->transaction_payment_id)->first();
        if( $expense_payment){
            $expense_payment->update($payment_data);
        }else{
            $expense_payment->create($payment_data);
        }
        

        // if ($payment_data['method'] == 'cash') {
        //     $user_id = null;
        //     if (!empty($request->source_id)) {
        //         if ($request->source_type == 'pos') {
        //             $user_id = StorePos::where('id', $request->source_id)->first()->user_id;
        //         }
        //         if ($request->source_type == 'user') {
        //             $user_id = $request->source_id;
        //         }

        //         if ($request->source_type == 'safe') {
        //             $money_safe = MoneySafe::find($request->source_id);
        //             $payment_data['currency_id'] = System::getProperty('currency');
        //             $this->moneysafeUtil->updatePayment($expense, $payment_data, 'debit', $transaction_payment->id, null, $money_safe);
        //         }
        //     }
        //     if ($request->source_type == 'user' || $request->source_type == 'pos') {
        //         $cr_transaction = CashRegisterTransaction::where('transaction_id', $expense->id)->first();
        //         if (!empty($request->cash_register_id)) {
        //             $register = CashRegister::where('id', $request->cash_register_id)->first();
        //             if (!empty($register->closed_at)) {
        //                 $register->closing_amount = $register->closing_amount - $this->commonUtil->num_uf($request->amount);
        //                 $register->save();
        //             }
        //             $pre_register = CashRegister::where('id', $cr_transaction->cash_register_id)->first();
        //             if (!empty($pre_register->closed_at)) {
        //                 $pre_register->closing_amount = $pre_register->closing_amount + $this->commonUtil->num_uf($request->amount);
        //                 $pre_register->save();
        //             }
        //         } else {
        //             $register = CashRegister::where('id', $cr_transaction->cash_register_id)->first();
        //         }

        //         $this->cashRegisterUtil->updateCashRegisterTransaction($cr_transaction->id, $register, $payment_data['amount'], $expense->type, 'debit', $user_id, '', null);
        //     }
        // }

        DB::commit();

        $output = [
            'success' => true,
            'msg' => __('lang.expense_updated')
        ];
        // } catch (\Exception $e) {
        //     Log::emergency('File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Message: ' . $e->getMessage());
        //     $output = [
        //         'success' => false,
        //         'msg' => __('lang.something_went_wrong')
        //     ];
        // }

        return redirect()->back()->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            ExpenseTransaction::where('id', $id)->delete();
            ExpenseTransactionPayment::where('transaction_id', $id)->delete();
            CashRegisterTransaction::where('transaction_id', $id)->delete();

            $output = [
                'success' => true,
                'msg' => __('lang.expense_deleted')
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
}
