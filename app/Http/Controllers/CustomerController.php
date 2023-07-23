<?php 

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use App\Models\CustomerImportantDate;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Utils\Util;

class CustomerController extends Controller 
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
   * @return Response
   */
  public function index()
  {
      $customers=Customer::latest()->get();
      return view('customers.index',compact('customers'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $customer_types=CustomerType::latest()->pluck('name','id');
    return view('customers.create',compact('customer_types'));

  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(CustomerRequest $request)
  {
    try {
      $data = $request->except('_token');
      $data['created_by']=Auth::user()->id;
      $customer = Customer::create($data);

      if (!empty($request->important_dates)) {
        $this->createOrUpdateCustomerImportantDate($customer->id, $request->important_dates);
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
  public function createOrUpdateCustomerImportantDate($customer_id, $customer_important_dates)
    {
        $customer=CustomerImportantDate::where('customer_id',$customer_id)->delete();
        foreach ($customer_important_dates as $key => $value) {
            $id = !empty($value['id']) ? $value['id'] : null;
            $customer_important_date = CustomerImportantDate::firstOrNew(['customer_id' => $customer_id, 'id' => $id]);
            $customer_important_date->customer_id = $customer_id;
            $customer_important_date->details = $value['details'];
            $customer_important_date->date = !empty($value['date']) ? $this->Util->uf_date($value['date']) : null;
            $customer_important_date->notify_before_days = $value['notify_before_days'] ?? 0;
            $customer_important_date->created_by = Auth::user()->id;

            $customer_important_date->save();
        }
    }
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $customer = Customer::find($id);
    $customer_types = CustomerType::pluck('name', 'id');

    return view('customers.edit')->with(compact(
        'customer',
        'customer_types',
    ));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(CustomerUpdateRequest $request,$id)
  {
    try {
      $data = $request->except('_token');
      $data['name'] = $request->name;
      $data['updated_by'] = Auth::user()->id;
      Customer::find($id)->update($data);
      if (!empty($request->important_dates)) {
        $this->createOrUpdateCustomerImportantDate($id, $request->important_dates);
      }else{
        $customer=CustomerImportantDate::where('customer_id',$id)->delete();
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
   * @return Response
   */
  public function destroy($id)
  {
    try {
      $customer=Customer::find($id);
      $customer->deleted_by=Auth::user()->id;
      $customer->save();
      $customer->delete();
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
  public function getImportantDateRow()
    {
        $index = request()->index ?? 0;

        return view('customers.important_date_row')->with(compact(
            'index'
        ));
    }
}

?>