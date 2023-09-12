<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\System;
use App\Models\User;
use App\Models\Wage;
use App\Models\WageTransaction;
use App\Models\WageTransactionPayment;
use Illuminate\Http\Request;
use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WageController extends Controller
{
    protected $Util;

    /**
     * Constructor
     *
     * @param Utils $product
     * @return void
     */
    public function __construct(Util $Util)
    {
        $this->Util = $Util;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wages=Wage::latest()->get();
        $payment_types = Wage::getPaymentTypes();
        return view('employees.wages.index',compact('wages','payment_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = User::has('employees')->latest()->pluck('name','id');
        $payment_types = Wage::getPaymentTypes();
        $users = User::Notview()->pluck('name', 'id');
        return view('employees.wages.create',compact('employees','payment_types','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request);
        try {
            $data = $request->except('_token', 'submit');
            $data['net_amount'] = (float)($data['net_amount']);
            $data['date_of_creation'] = Carbon::now();
            $data['created_by'] = Auth::user()->id;
            $data['status'] = $request->submit == 'Paid' ? 'paid' : 'pending';
            $data['payment_date'] = !empty($data['payment_date']) ? $this->Util->uf_date($data['payment_date']) : null;
            $data['acount_period_start_date'] = !empty($data['acount_period_start_date']) ? $this->Util->uf_date($data['acount_period_start_date']) : null;
            $data['acount_period_end_date'] = !empty($data['acount_period_end_date']) ? $this->Util->uf_date($data['acount_period_end_date']) : null;
            $data['other_payment'] = !empty($data['other_payment']) ? $data['other_payment'] : 0;
            $data['amount'] = !empty($data['amount']) ? (float)($data['amount']) : 0;

            $wage=Wage::create($data);


            $employee = Employee::find($wage->employee_id);
            $transaction_data = [
                'type' => 'wage',
                'store_id' => !empty($employee->store_id) ? $employee->store_id[0] : null,
                'employee_id' => $wage->employee_id,
                'transaction_date' => Carbon::now(),
                'grand_total' => $this->Util->num_uf($data['net_amount']),
                'final_total' => $this->Util->num_uf($data['net_amount']),
                'status' => 'final',
                'payment_status' => $data['status'],
                'wage_id' => $wage->id,
                'source_type' => $request->source_type,
                'source_id' => $request->source_id,
                'created_by' => Auth::user()->id,

            ];

            $transaction = WageTransaction::create($transaction_data);

            // if ($request->payment_status != 'pending') {
            //     $payment_data = [
            //         'transaction_id' => $transaction->id,
            //         'amount' => $this->Util->num_uf($request->net_amount),
            //         'method' => 'cash',
            //         'paid_on' => $data['payment_date'],
            //         'ref_number' => $request->ref_number,
            //         'source_type' => $request->source_type,
            //         'source_id' => $request->source_id,
            //     ];
            //     if (!empty($payment_data['amount'])) {
            //         $payment_data['created_by'] = Auth::user()->id;
            //         $payment_data['payment_for'] = !empty($payment_data['payment_for']) ? $payment_data['payment_for'] : $transaction->customer_id;
            //         $transaction_payment = WageTransactionPayment::create($payment_data);
            //     }
            // }
            $output = [
                'success' => true,
                'msg' => __('lang.success')
            ];
        } catch (\Exception $e) {
            dd($e);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employees = User::has('employees')->latest()->pluck('name','id');
        $payment_types = Wage::getPaymentTypes();
        $users = User::Notview()->pluck('name', 'id');
        $wage=Wage::find($id);
        return view('employees.wages.edit',compact('employees','payment_types','users','wage'));
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
        try {
            $data = $request->except('_token', 'submit', '_method');
            $data['edited_by'] = Auth::user()->id;
            $data['net_amount'] = $data['net_amount'];
            $data['other_payment'] = !empty($data['other_payment']) ? $data['other_payment'] : 0;
            $data['deductibles'] = !empty($data['deductibles']) ? $this->Util->num_uf($data['deductibles']) : 0;
            $data['payment_date'] = !empty($data['payment_date']) ? $this->Util->uf_date($data['payment_date']) : null;
            $data['source_id'] = !empty($data['source_id']) ? $data['source_id'] : null;
            $data['source_type'] = !empty($data['source_type']) ? $data['source_type'] : null;
            $data['acount_period_start_date'] = !empty($data['acount_period_start_date']) ? $this->Util->uf_date($data['acount_period_start_date']) : null;
            $data['acount_period_end_date'] = !empty($data['acount_period_end_date']) ? $this->Util->uf_date($data['acount_period_end_date']) : null;
            $wage = Wage::find($id);
            $wage->update($data);


            $transaction = WageTransaction::where('wage_id', $id)->first();

            $transaction_data = [
                'grand_total' => $this->Util->num_uf($data['net_amount']),
                'final_total' => $this->Util->num_uf($data['net_amount']),
                'status' => 'final',
                'payment_status' => $wage->status,
                'wage_id' => $wage->id,
                'source_type' => $request->source_type,
                'source_id' => $request->source_id,
                'edited_by' => Auth::user()->id,
            ];

            if (!empty($transaction)) {
                $transaction->update($transaction_data);
            } else {
                $transaction_data['type'] = 'wage';
                $transaction_data['transaction_date'] = $wage->date_of_creation;
                $transaction = WageTransaction::create($transaction_data);
            }
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
        try{
            $wage=Wage::find($id);
            $wage->deleted_by=Auth::user()->id;
            $wage_transaction=WageTransaction::where('wage_id',$wage->id)->first();
            $wage_transaction->deleted_by=Auth::user()->id;
            $wage->save();
            $wage_transaction->save();
            $wage->delete();
            $wage_transaction->delete();
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
    public function calculateSalaryAndCommission($employee_id, $payment_type)
    {
        $employee = Employee::find($employee_id);
        $user_id = $employee->user_id;
        $amount = 0;

        if ($payment_type == 'salary') {
            if ($employee->fixed_wage == 1) {
                $fixed_wage_value = $employee->fixed_wage_value;
                $payment_cycle = $employee->payment_cycle;

                if ($payment_cycle == 'daily') {
                    $amount = $fixed_wage_value * 30;
                }
                if ($payment_cycle == 'weekly') {
                    $amount = $fixed_wage_value * 4;
                }
                if ($payment_cycle == 'bi-weekly') {
                    $amount = $fixed_wage_value * 2;
                }
                if ($payment_cycle == 'monthly') {
                    $amount = $fixed_wage_value * 1;
                }
            }
        }

        if ($payment_type == 'commission') {
            $start_date = request()->acount_period_start_date;
            $end_date = request()->acount_period_end_date;

            $amount = $this->Util->calculateEmployeeCommission($employee_id, $start_date, $end_date);
        }

        return ['amount' => $this->Util->num_f($amount)];
    }
}
