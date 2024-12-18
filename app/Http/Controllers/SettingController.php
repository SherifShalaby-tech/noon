<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\State;
use App\Models\System;
use App\Models\Unit;
use App\Models\User;
use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{

    protected $commonUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $settings = System::pluck('value', 'key');
        $config_languages = config('constants.langs');
        $languages = [];
        foreach ($config_languages as $key => $value) {
            $languages[$key] = $value['full_name'];
        }
        $currencies  = $this->allCurrencies();
        $selected_currencies = System::getProperty('currency') ? json_decode(System::getProperty('currency'), true) : [];
        // Get All Countries
        $countries = Country::pluck('name', 'id');
        $units = Unit::orderBy('created_at', 'desc')->get();
        return view('general-settings.index', compact(
            'countries',
            'settings',
            'languages',
            'currencies',
            'selected_currencies',
            'units'
        ));
    }
    // ++++++++++++++ fetchState(): to get "states" of "selected country" selectbox ++++++++++++++
    public function fetchState(Request $request)
    {
        $data['states'] = State::where('country_id', $request->country_id)->get(['id', 'name']);
        return response()->json($data);
    }
    // ++++++++++++++ fetchCity(): to get "cities" of "selected city" selectbox ++++++++++++++
    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where('state_id', $request->state_id)->get(['id', 'name']);
        return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //          get show and hide module
    public function getModuleSettings(): Factory|View|Application
    {
        $modules = User::modulePermissionArray();
        $module_settings = System::getProperty('module_settings') ? json_decode(System::getProperty('module_settings'), true) : [];
        return view('settings.module')->with(compact(
            'modules',
            'module_settings'
        ));
    }

    //          update show and hide module
    public function updateModuleSettings(Request $request): RedirectResponse
    {
        $module_settings = $request->module_settings;

        try {
            System::updateOrCreate(
                ['key' => 'module_settings'],
                ['value' => json_encode($module_settings), 'date_and_time' => Carbon::now()]
            );
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
    public function updateGeneralSetting(Request $request)
    {
        try {
            DB::beginTransaction();

            System::updateOrCreate(
                ['key' => 'site_title'],
                ['value' => $request->site_title, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'developed_by'],
                ['value' => $request->developed_by, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'timezone'],
                ['value' => $request->timezone, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'invoice_terms_and_conditions'],
                ['value' => $request->invoice_terms_and_conditions, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'language'],
                ['value' => $request->language, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            if (!empty($request->language)) {
                session()->put('language', $request->language);
            }
            System::updateOrCreate(
                ['key' => 'currency'],
                ['value' => $request->currency, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'dollar_exchange'],
                ['value' => $request->dollar_exchange, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'start_date'],
                ['value' => $request->start_date, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'end_date'],
                ['value' => $request->end_date, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'tax'],
                ['value' => $request->tax, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'product_sku_start'],
                ['value' => $request->product_sku_start, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            // return isset($request->activate_processing) && $request->activate_processing=="on"?1:0;
            System::updateOrCreate(
                ['key' => 'activate_processing'],
                ['value' => isset($request->activate_processing) && $request->activate_processing == "on" ? 1 : 0, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'update_processing'],
                ['value' => $request->update_processing == "on" || isset($request->update_processing) ? 1 : 0, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'loading_cost_currency'],
                ['value' => $request->loading_cost_currency, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            if (!empty($request->currency)) {
                $currency = Currency::find($request->currency);
                $currency_data = [
                    'country' => $currency->country,
                    'code' => $currency->code,
                    'symbol' => $currency->symbol,
                    'decimal_separator' => '.',
                    'thousand_separator' => ',',
                    'currency_precision' => !empty(System::getProperty('numbers_length_after_dot')) ? System::getProperty('numbers_length_after_dot') : 5,
                    'currency_symbol_placement' => 'before',
                ];
                $request->session()->put('currency', $currency_data);
            }
            System::updateOrCreate(
                ['key' => 'invoice_lang'],
                ['value' => $request->invoice_lang, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'help_page_content'],
                ['value' => $request->help_page_content, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'watsapp_numbers'],
                ['value' => $request->watsapp_numbers, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            // +++++++++++++++++++++ Country_id ++++++++++++++++++++
            System::updateOrCreate(
                ['key' => 'country_id'],
                ['value' => $request->country_id, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'num_of_digital_numbers'],
                ['value' => $request->num_of_digital_numbers, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            System::updateOrCreate(
                ['key' => 'keyboord_letter_to_toggle_dollar'],
                ['value' => $request->keyboord_letter_to_toggle_dollar, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
            $data['letter_header'] = null;
            if ($request->has('letter_header') && !is_null('letter_header')) {
                $imageData = $this->getCroppedImage($request->letter_header);
                $extention = explode(";", explode("/", $imageData)[1])[0];
                $image = rand(1, 1500) . "_image." . $extention;
                $filePath = public_path('uploads/' . $image);
                $data['letter_header'] = $image;
                $fp = file_put_contents($filePath, base64_decode(explode(",", $imageData)[1]));
            }
            $data['letter_footer'] = null;
            if ($request->has('letter_footer') && !is_null('letter_footer')) {
                $imageData = $this->getCroppedImage($request->letter_footer);
                $extention = explode(";", explode("/", $imageData)[1])[0];
                $image = rand(1, 1500) . "_image." . $extention;
                $filePath = public_path('uploads/' . $image);
                $data['letter_footer'] = $image;
                $fp = file_put_contents($filePath, base64_decode(explode(",", $imageData)[1]));
            }
            $data['logo'] = null;
            if ($request->has('logo') && !is_null('logo')) {
                $imageData = $this->getCroppedImage($request->logo);
                $extention = explode(";", explode("/", $imageData)[1])[0];
                $image = rand(1, 1500) . "_image." . $extention;
                $filePath = public_path('uploads/' . $image);
                $data['logo'] = $image;
                $fp = file_put_contents($filePath, base64_decode(explode(",", $imageData)[1]));
            }

            foreach ($data as $key => $value) {
                if (!empty($value)) {
                    System::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
                    );
                    if ($key == 'logo') {
                        $logo = System::getProperty('logo');
                        $request->session()->put('logo', $logo);
                    }
                }
            }
            // Add Loading Cost to Units

            if (!empty($request->units)) {
                foreach ($request->units as $unit) {
                    $unit_update = Unit::find($unit['unit_id']);
                    $data_cost = [
                        'loading_cost' =>  $this->commonUtil->num_uf($unit['loading_cost']),
                    ];
                    $unit_update->update($data_cost);
                }
            }
            Artisan::call("optimize:clear");
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
            dd($e);
        }

        return redirect()->back()->with('status', $output);
    }
    public function allCurrencies($exclude_array = [])
    {
        $query = Currency::select('id', DB::raw("concat(country, ' - ',currency, '(', code, ') ', symbol) as info"))
            ->orderBy('country');
        if (!empty($exclude_array)) {
            $query->whereNotIn('id', $exclude_array);
        }

        $currencies = $query->pluck('info', 'id');

        return $currencies;
    }
    function getCroppedImage($img)
    {
        if (strlen($img) < 200) {
            return $this->getBase64Image($img);
        } else {
            return $img;
        }
    }
    public function removeImage($type)
    {
        try {
            System::where('key', $type)->update(['value' => null]);
            request()->session()->put($type, null);
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
    function getBase64Image($Image)
    {
        $image_path = str_replace(env("APP_URL") . "/", "", $Image);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $image_path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $image_content = curl_exec($ch);
        curl_close($ch);
        //    $image_content = file_get_contents($image_path);
        $base64_image = base64_encode($image_content);
        $b64image = "data:image/jpeg;base64," . $base64_image;
        return $b64image;
    }

    public function createOrUpdateSystemProperty($key, $value)
    {
        try {
            System::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'date_and_time' => Carbon::now(), 'created_by' => 1]
            );

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
            dd($e);
        }

        return $output;
    }
    public function get_currency()
    {
        $currency = Currency::find(request()->selectedValue);
        $info = $currency->country . ' - ' . $currency->currency . '(' . $currency->code . ') ' . $currency->symbol;
        $data = [
            '' => __('lang.please_select'),
            $currency->id => $info,
            '2' => 'America - Dollars(USD) $',
        ];
        return $data;
    }
    public function toggleDollar()
    {
        try {
            $toggle_dollar = System::getProperty('toggle_dollar');
            if (isset($toggle_dollar)) {
                $toggle_dollar = !(int)$toggle_dollar;
            } else {
                $toggle_dollar = 1;
            }
            System::updateOrCreate(
                ['key' => 'toggle_dollar'],
                ['value' => $toggle_dollar, 'date_and_time' => Carbon::now(), 'created_by' => Auth::user()->id]
            );
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
            dd($e);
        }
        return $output;
    }
}
