<?php

use App\Models\PurchaseOrderLine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetDueReport;
use App\Http\Controllers\CashController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WageController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellCarController;
use App\Http\Controllers\SellPosController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AddStockController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DailyReportSummary;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StorePosController;
use App\Http\Controllers\MoneySafeController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CashRegisterController;
use App\Http\Controllers\GeneralTaxController;
use App\Http\Controllers\ProductTaxController;
use App\Http\Controllers\ReceivableController;
use App\Http\Controllers\SellReturnController;
use App\Http\Controllers\ReturnStockController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\GetDueReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PayableReportController;
use App\Http\Controllers\InitialBalanceController;
use App\Http\Controllers\RepresentativeController;
use App\Http\Controllers\SupplierReportController;
use App\Http\Controllers\CustomersReportController;
use App\Http\Controllers\PurchasesReportController;
use App\Http\Controllers\RequiredProductController;
use App\Http\Controllers\NewInitialBalanceController;
use App\Http\Controllers\PurchaseOrderLineController;
use App\Http\Controllers\CustomerOfferPriceController;
use App\Http\Controllers\CustomerPriceOfferController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProcessInvoiceController;
use App\Http\Controllers\ProfitReportController;
use App\Http\Controllers\TransactionPaymentController;
use App\Http\Controllers\SalesPerEmployeeReportController;
use App\Http\Controllers\RepresentativeSalaryReportController;
use App\Http\Controllers\CustomerBalanceAdjustmentsController;
use App\Http\Controllers\StoreTransferController;
use App\Http\Controllers\productTransacrionReport;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['auth']], function () {
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    });
    // ++++++++++++++++++++++++++++++++++++ Notifications +++++++++++++++++++++++++++++++++
    // --------------- Mark All Posts As Read ---------------
    Route::get('notifications/markAllAsRead', [NotificationController::class,"markAsRead"])->name('Notification.Read');
    // --------------- delete notification  ---------------
    Route::get('notifications/delete/{id}', [NotificationController::class,"destroy_notification"])->name('Notification.delete');

    // Home cards route
    Route::get('returns', function () {
        return view('returns.index');
    })->name('returns');

    Route::get('settings/all', function () {
        return view('settings.index');
    })->name('settings.all');

    Route::get('reports/all', function () {
        return view('reports.index');
    })->name('reports.all');

    Route::get('brands/get-dropdown', [BrandController::class,'getDropdown']);
    Route::resource('brands', BrandController::class);
    Route::resource('store', App\Http\Controllers\StoreController::class);
    Route::resource('jobs',App\Http\Controllers\JobTypeController::class);
    // ======================== employees
    Route::resource('employees',App\Http\Controllers\EmployeeController::class);
    // ---------- attendance ------------
    Route::resource('attendance', AttendanceController::class);
    // add "new_row"
    Route::get('attendance/get-attendance-row/{row_index}', [AttendanceController::class , 'getAttendanceRow']);

    Route::get('add_point', [App\Http\Controllers\EmployeeController::class,'addPoints'])->name('employees.add_points');
    // +++++++++++++++++++++++ filters of "employees products" +++++++++++++++++++++
    Route::get('/employees/filter/{id}', [App\Http\Controllers\EmployeeController::class,'filterProducts']);
    // store() method
    // Route::post('/products', 'ProductController@store');

    // Wages
    Route::resource('wages',WageController::class);
    Route::get('wages/calculate-salary-and-commission/{employee_id}/{payment_type}', [WageController::class,'calculateSalaryAndCommission'])->name('calculateSalaryAndCommission');
    Route::post('wages/update-other-payment/', [WageController::class,'update_other_payment'])->name('update_other_payment');
    Route::get('settings/modules', [SettingController::class, 'getModuleSettings'])->name('getModules');
    Route::post('settings/modules', [SettingController::class, 'updateModuleSettings'])->name('updateModule');
    Route::get('toggle-dollar', [SettingController::class, 'toggleDollar'])->name('toggleDollar');

    // Get "مصدر الاموال" depending on "طريقة الدفع"
    Route::get('/wage/get-source-by-type-dropdown/{type}', [WageController::class,'getSourceByTypeDropdown']);
    // +++++++++++ Get "طريقة الحساب " depending on "الموظف" +++++++++++
    Route::get('/get-employee-payment-cycle/{id}',[WageController::class,'getEmployeePaymentCycle']);
    // +++++++++++++++++++++++++++ general-settings ++++++++++++++++++++
    Route::post('settings/update-general-settings', [SettingController::class, 'updateGeneralSetting'])->name('settings.updateGeneralSettings');
    // // general_setting : fetch "state" of selected "country" selectbox
    // Route::post('api/fetch-state',[SettingController::class,'fetchState']);
    // // general_setting : fetch "city" of selected "state" selectbox
    // Route::post('api/fetch-cities',[SettingController::class,'fetchCity']);


    Route::post('settings/remove-image/{type}', [SettingController::class,'removeImage']);
    Route::resource('settings', SettingController::class);
    Route::get('stores/get-dropdown', [StoreController::class,'getDropdown']);
    Route::resource('store',StoreController::class);
    //الاقسام
    Route::get('categories/get-dropdown/{category_id}', [CategoryController::class,'getDropdown']);
    Route::get('category/get-subcategories/{id}', [CategoryController::class, 'getSubcategories']);
    // employees subcategory
    Route::get('employees/get-subcategories/{id}', [EmployeeController::class, 'getSubcategories']);
     // ++++++++++++++++ get "job_type" permissions ++++++++++++++++
     Route::get('/get-job-type-permissions/{id}', [EmployeeController::class, 'getJobTypePermissions']);

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::get('categories/{category?}/sub-categories', [CategoryController::class, 'subCategories'])->name('sub-categories');
    Route::get('categories/sub_category_modal', [CategoryController::class, 'getSubCategoryModal'])->name('categories.sub_category_modal');
    // ++++++++++++++++++++ Employee Filters +++++++++++++++++++
    // fetch "sub_categories1" of selected "main_category" selectbox
    Route::post('api/fetch-sub_categories1',[EmployeeController::class,'fetch_sub_categories1']);
    // fetch "sub_categories2" of selected "sub_categories1" selectbox
    Route::post('api/fetch-sub_categories2',[EmployeeController::class,'fetch_sub_categories2']);
    // fetch "sub_categories3" of selected "sub_categories2" selectbox
    Route::post('api/fetch-sub_categories3',[EmployeeController::class,'fetch_sub_categories3']);

    // colors
    Route::resource('colors', ColorController::class)->except(['show']);
    // sizes
    Route::resource('sizes', SizeController::class)->except(['show']);
    // units
    Route::get('units/get-unit-data/{id}', [UnitController::class,'getUnitData']);
    Route::get('units/get-dropdown', [UnitController::class,'getDropdown']);
    Route::get('variations/units/get-dropdown', [UnitController::class,'getUnitsDropdown']);
    Route::get('product/get-unit-store', [UnitController::class,'getUnitStore']);

    Route::resource('units', UnitController::class)->except(['show']);
    Route::get('product/get-raw-price', [ProductController::class,'getRawPrice']);
    Route::get('product/get-raw-unit', [ProductController::class,'getRawUnit']);
    Route::post('product/multiDeleteRow', [ProductController::class,'multiDeleteRow']);
    Route::get('product/remove_damage/{id}', [ProductController::class,'get_remove_damage'])->name('get_remove_damage');
    Route::delete('product/convolutions/deleteExpiryRow/{id}', [ProductController::class,'deleteExpiryRow'])->name("deleteExpiryRow");
    Route::get('product/create/product_id={id}/getDamageProduct', [ProductController::class,'getDamageProduct'])->name("getDamageProduct");
    Route::get('product/remove_expiry/{id}', [ProductController::class,'get_remove_expiry'])->name('remove_expiry');
    Route::get('product/create/product_id={id}/convolutions', [ProductController::class,'addConvolution'])->name("addConvolution");
    // ======= add "new store" in realtime =====
    Route::post('product/create/add_store', [ProductController::class,'add_store'])->name('product.add_store');
    // ++++++++++++ get "stores" dropdown ++++++++++++
    Route::get('product/get-dropdown-store/', [ProductController::class,'getStoresDropdown']);
    // +++++++++++++++++++++ products filters +++++++++++++++++++++++++++
    // fetch "sub_categories1" of selected "main_category" selectbox
    Route::post('api/products/fetch_product_sub_categories1',[ProductController::class,'fetch_sub_categories1']);
    // fetch "sub_categories2" of selected "sub_categories1" selectbox
    Route::post('api/products/fetch_product_sub_categories2',[ProductController::class,'fetch_sub_categories2']);
    // fetch "sub_categories3" of selected "sub_categories2" selectbox
    Route::post('api/products/fetch_product_sub_categories3',[ProductController::class,'fetch_sub_categories3']);
    Route::get('product/add_product_raw', [ProductController::class,'addProductRow']);
    
    Route::resource('products', ProductController::class);
    //customers
    Route::get('customer/get-important-date-row', [CustomerController::class,'getImportantDateRow']);
    Route::resource('customers', CustomerController::class);
    
    
    
    
    
    ###################عمل مطابقة فواتير العملاء ######################################
    
    // Route::post('update-confirm-status', 'CustomerController@updateConfirmStatus');
    Route::post('/updateConfirmStatus',[CustomerController::class,'updateConfirmStatus']);

    ###################عمل مطابقة فواتير العملاء ######################################


    // general_setting : fetch "state" of selected "country" selectbox
    Route::post('api/customers/fetch-state',[CustomerController::class,'fetchState']);
    // general_setting : fetch "city" of selected "state" selectbox
    Route::post('api/customers/fetch-cities',[CustomerController::class,'fetchCity']);
    // general_setting : fetch "quarter" of selected "city" selectbox
    Route::post('api/customers/fetch-quarters',[CustomerController::class,'fetchQuarter']);
    // +++++++++++++++++++ Add "new region" +++++++++++++++++++
    Route::post('customers/create/', [CustomerController::class,'storeRegion'])->name('customers.storeRegion');
    // +++++++++++++++++++ Add "new quarter" +++++++++++++++++++
    Route::post('customers/create/storeQuarter', [CustomerController::class,'storeQuarter'])->name('customers.storeQuarter');
    Route::resource('customertypes', CustomerTypeController::class);
    Route::get('customer/get-dropdown', [CustomerController::class,'getDropdown']);
    // ++++++++++++ task 14-12-2023 : get "cities" dropdown ++++++++++++
    Route::get('customer/get-dropdown-city/{id}', [CustomerController::class,'getDropdownCity']);
    // ++++++++++++ task 14-12-2023 : get "quarters" dropdown ++++++++++++
    Route::get('customer/get-dropdown-quarter/{id}', [CustomerController::class,'getDropdownQuarter']);
    // ++++++++++++ task 02-01-2024 : get "customer types" dropdown ++++++++++++
    Route::get('customer/get-dropdown-customer-type/', [CustomerController::class,'getDropdownCustomerType']);
    Route::get('customer/dues', [CustomerController::class,'get_due'])->name('dues');
    Route::get('customer/customer_dues/{id}', [CustomerController::class,'customer_dues'])->name('customer_dues');

    Route::post('customer/pay_due/{id}', [CustomerController::class,'pay_due'])->name('customers.pay_due');
    Route::get('pay_due_view/{id}', [CustomerController::class,'pay_due_view'])->name('customers.pay_due_view');

    Route::get('customer/show-invoices/{customer_id}/{delivery_id}', [CustomerController::class,'show_customer_invoices'])->name('show_customer_invoices');
    Route::get('customer/show-invoices/{customer_id}', [CustomerController::class,'customer_invoices'])->name('customer_invoices');


    // stocks
    Route::get('recent_transactions', [AddStockController::class,'recentTransactions'])->name('recent_transactions');
    Route::get('add-stock/index', [AddStockController::class,'index'])->name('stocks.index');
    Route::view('add-stock/create', 'add-stock.create')->name('stocks.create');
    Route::view('add-stock/{id}/edit/', 'add-stock.edit')->name('stocks.edit');
    Route::get('add-stock/show/{id}',[AddStockController::class , 'show'])->name('stocks.show');
    Route::get('add-stock/add-payment/{id}',[AddStockController::class , 'addPayment'])->name('stocks.addPayment');
    Route::get('add-stock/receive_discount/{id}',[AddStockController::class , 'receive_discount_view'])->name('stocks.receive_discount_view');
    Route::post('add-stock/receive_discount_store/{id}',[AddStockController::class , 'receive_discount'])->name('stocks.receive_discount');

    Route::post('add-stock/post-payment/{id}',[AddStockController::class , 'storePayment'])->name('stocks.storePayment');
    Route::delete('add-stock/{id}/delete',[AddStockController::class , 'destroy'])->name('stocks.delete');

    // Initial Balance
    Route::get('initial-balance/get-raw-unit', [InitialBalanceController::class,'getRawUnit']);
    Route::resource('initial-balance', InitialBalanceController::class);
    Route::resource('new-initial-balance', NewInitialBalanceController::class);
    Route::get('suppliers/get-dropdown', [SuppliersController::class,'getDropdown']);
    Route::get('balance/get-raw-product', [ProductController::class,'getRawProduct']);
    //delivery
    Route::resource('delivery',  DeliveryController::class);
    Route::get('representative/plan', [DeliveryController::class,'indexForRep'])->name('rep_plan.index');
    // Route::get('delivery/edit/{id}',   [DeliveryController::class,'edit'])->name('delivery.edit');
    Route::get('delivery/create/{id}', [DeliveryController::class,'create'])->name('delivery.create');
    Route::get('plans', [DeliveryController::class,'plansList'])->name('delivery_plan.plansList');
    Route::get('plans/representatives', [DeliveryController::class,'plansListForRep'])->name('representatives.plansList');
    Route::post('delivery_plan/sign-in', [DeliveryController::class,'signIn']);
    Route::post('delivery_plan/sign-out', [DeliveryController::class,'signOut']);

    // Route::get('delivery/maps', [DeliveryController::class,'index'])->name('delivery.maps');


    //    Route::get('add-stock/add-payment/{id}', function ($id) {
    //        return view('add-stock.add-payment', compact('id'));
    //    })->name('stocks.addPayment');

    // store pos
    Route::resource('store-pos', StorePosController::class);
    // ########### General Tax ###########
    Route::resource('general-tax', GeneralTaxController::class);
    // ########### Product Tax ###########
    Route::get('product-tax/get-dropdown', [ProductTaxController::class,'getDropdown']);
    Route::resource('product-tax', ProductTaxController::class);
    Route::get('report/get-monthly-sale-report', [ReportController::class,'getMonthlySaleReport'])->name('report.monthly_sale_report');
    Route::get('report/get-store-stock-chart', [ReportController::class,'getStoreStockChart'])->name('report.store_stock_chart');
    // ########### Purchases Report ###########
    Route::resource('purchases-report', PurchasesReportController::class);
    // ########### Sales Report ###########
    Route::resource('sales-report', SalesReportController::class);
    // ########### Receivable Report ###########
    Route::resource('receivable-report', ReceivableController::class);
    // ########### Payable Report ###########
    Route::resource('payable-report', PayableReportController::class);
    // fetch "stores" of selected "branch" selectbox
    Route::post('api/fetch_branch_stores',[PayableReportController::class,'fetch_branch_stores']);
    // ########### Get Due Report ###########
    Route::resource('get-due-report', GetDueReportController::class);
    // ########### Supplier Report ###########
    Route::resource('get-supplier-report', SupplierReportController::class);
    


        // ########### product transaction Report ###########
        
        
        Route::resource('ProductReport', productTransacrionReport::class);
        Route::get('getProductReport', [productTransacrionReport::class, 'getProductReport'])->name('getProductReport');
        
        
        // ########### product transaction Report ###########
    
    
    
    
    
    
    
    
    // ########### Customers Report ###########
    Route::resource('customers-report', CustomersReportController::class);
    // ########### Daily Report Summary ###########
    Route::resource('daily-report-summary', DailyReportSummary::class);
    // ########### profit Report ###########
    Route::get('report/get-profit-loss', [ProfitReportController::class,'index'])->name('profit_report');

    // ########### Sales Per Employee Report ###########

    Route::resource('sales-per-employee', SalesPerEmployeeReportController::class);
    // ########### representative salary report ###########
    Route::resource('representative_salary_report', RepresentativeSalaryReportController::class);
    // ajax request : get_product_search
    Route::get('get-dashboard-data/{start_date}/{end_date}',  [ProfitReportController::class,'getDashboardData']);

    // selected_products : Add All Selected Product
    Route::get('/selected-product',[PurchaseOrderLineController::class,'deleteAll'])->name('product.delete');
    // Sell Screen
    Route::get('invoices/create', [SellPosController::class,'create'])->name('invoices.create');

    Route::get('invoices/edit/{invoice}', [SellPosController::class,'editInvoice'])->name('invoices.edit');
    // ++++++++++++ invoices : "delete all selected invoices" ++++++++++++
    Route::post('pos/multiDeleteRow', [SellPosController::class,'multiDeleteRow'])->name('pos.multiDeleteRow');

    Route::resource('pos',SellPosController::class);
    Route::resource('process-invoice',ProcessInvoiceController::class);
    // Route::get('transaction-payment/add-payment/{id}', [TransactionPaymentController::class,'addPayment'])->name('transaction-payment.add-payment');
    Route::resource('pos-pay',TransactionPaymentController::class);
    Route::get('transaction-payment/add-payment/{id}', [SellPosController::class, 'addPayment'])->name('add_payment');
    Route::post('transaction-payment/store-payment', [SellPosController::class, 'storePayment'])->name('store_payment');
    Route::get('print/invoice/{id}',[SellPosController::class, 'print'])->name('print_invoice');
    Route::get('show/payment/{id}',[SellPosController::class, 'show_payment'])->name('show_payment');
    Route::get('add/receipt/{trans_id}',[SellPosController::class, 'upload_receipt'])->name('upload_receipt');
    Route::get('show/receipt/{id}',[SellPosController::class, 'show_receipt'])->name('show_receipt');
    Route::post('add/receipt',[SellPosController::class, 'store_upload_receipt'])->name('store_upload_receipt');
    // ################################# Task : customer_price_offer #################################
    Route::view('customer_price_offer/index', 'customer_price_offer.index')->name('customer_price_offer.index');
    Route::view('customer_price_offer/create', 'customer_price_offer.create')->name('customer_price_offer.create');
    Route::view('customer_price_offer/edit/{id}', 'customer_price_offer.edit')->name('customer_price_offer.edit');
    // ========= "create_invoice" link =============
    // Route::get('customer_price_offer/create_invoice/{id}', [CustomerOfferPriceController::class, 'create_invoice'])->name('customer_price_offer.create_invoice');
    // Route::view('customer_price_offer/create_invoice/{id}', 'customer_price_offer.create_invoice')->name('customer_price_offer.create_invoice');
    // ################################# edit invoice #################################

    // Route::get('customer_price_offer/edit/{id}', [CustomerOfferPriceController::class,'edit'])->name('customer_price_offer.edit');
    Route::delete('/customer_price_offer/delete/{id}', [CustomerOfferPriceController::class, 'destroy'])->name('customer_price_offer.destroy');;
    // ################################# Task : purchase_order : Livewire #################################
    Route::view('purchase_order/create', 'purchase_order.create')->name('purchase_order.create');

    // ########### Purchase Order : index ###########
    Route::resource('purchase_order', PurchaseOrderLineController::class);
    // ########### Purchase Order : Livewire : edit ###########
    Route::view('purchase_order/{id}/edit/', [PurchaseOrderLineController::class,'edit'])->name('purchase-order.edit');
    // ########### Purchase Order : softDelete For PurchaseOrderTransaction ###########
    Route::get('/purchase_order/delete/{id}', [PurchaseOrderLineController::class, 'destroy'])->name('purchase_order.destroy');
    // ###########  Purchase Order : show recycle_bin For PurchaseOrderTransaction ###########
    Route::get('/soft-deleted-records', [PurchaseOrderLineController::class, 'softDeletedRecords'])->name('purchase_order.show_soft_deleted_records');
    // ###########  Purchase Order : restore softDeleteRecords For PurchaseOrderTransaction ###########
    Route::get('/purchase_order/restore/{id}', [PurchaseOrderLineController::class, 'restore'])->name('purchase_order.restore');
    // ###########  Purchase Order : force deleteRecords For PurchaseOrderTransaction ###########
    Route::get('/purchase_order/forceDelete/{id}', [PurchaseOrderLineController::class, 'forceDelete'])->name('purchase_order.forceDelete');
    // Route::view('purchase-order/{id}/edit/', 'purchase-order.edit')->name('purchase-order.edit');
    // ---- required_products ----
    Route::resource('required-products', RequiredProductController::class);
    // Route::get('purchase-order/edit/{id}', function ($id) {
    //     return view('purchase-order.edit', compact('id'));
    // })->name('purchase-order.edit');
    // Sell Return
    Route::get('sale-return/add/{id}', function ($id) {
        return view('returns.sell.create', compact('id'));
    })->name('sell.return');

    // Returns
    Route::get('sell-return', [SellReturnController::class,'index'])->name('sell_return.index');
    Route::get('sell-return/show/{id}', [SellReturnController::class,'show'])->name('sell_return.show');

    // supplier Returns
    Route::get('stock/return/product',[ReturnStockController::class,'show'])->name('suppliers.returns.products');
    Route::get('stock/return/invoices',[ReturnStockController::class,'index'])->name('suppliers.returns.invoices');
    // ++++++++++++++++ suppliers return : invoices : return_invoice : Task 09-01-2024 ++++++++++++++++++
    Route::get('stock/return/invoices/return_invoice/{id}',[ReturnStockController::class,'return_invoice'])
            ->name('suppliers.returns.return_invoice');
    // ++++++++++++++++ suppliers return : invoices : return_invoice : Livewire : Task 09-01-2024 ++++++++++++++++++
    Route::get('invoice-return/return/{id}', function ($id) {
        return view('suppliers.returns.return_invoice', compact('id'));
    })->name('returns.suppliers.return_invoice');
    // user check password
    Route::post('user/check-password', [HomeController::class, 'checkPassword'])->name('check_password');
    //suppliers
    Route::resource('suppliers',SuppliersController::class);
    // general_setting : fetch "state" of selected "country" selectbox
    Route::post('api/fetch-state',[SuppliersController::class,'fetchState']);
    // general_setting : fetch "city" of selected "state" selectbox
    Route::post('api/fetch-cities',[SuppliersController::class,'fetchCity']);

    //money safe
    Route::post('moneysafe/post-add-money-to-safe', [MoneySafeController::class,'postAddMoneyToSafe'])->name('moneysafe.post-add-money-to-safe');
    Route::get('moneysafe/get-add-money-to-safe/{id}', [MoneySafeController::class,'getAddMoneyToSafe'])->name('moneysafe.get-add-money-to-safe');
    Route::post('moneysafe/post-take-money-to-safe', [MoneySafeController::class,'postTakeMoneyFromSafe'])->name('moneysafe.post-take-money-to-safe');
    Route::get('moneysafe/get-take-money-to-safe/{id}', [MoneySafeController::class,'getTakeMoneyFromSafe'])->name('moneysafe.get-take-money-to-safe');
    Route::get('moneysafe/watch-money-to-safe-transaction/{id}', [MoneySafeController::class,'getMoneySafeTransactions'])->name('moneysafe.watch-money-to-safe-transaction');
    Route::resource('moneysafe', MoneySafeController::class);

    // Sell car
    Route::resource('sell-car', SellCarController::class);

    // Branch
    Route::resource('branches',BranchController::class);
    Route::get('get_branch_stores/{ids}', [BranchController::class, 'getBranchStores']);

    Route::post('api/fetch-customers-by-city',[DeliveryController::class,'fetchCustomerByCity']);

    // Transfer
    Route::view('transfer/import/{id}','transfer.import')->name('transfer.import');
    Route::view('transfer/export/{id}','transfer.export')->name('transfer.export');

    Route::resource('representatives', RepresentativeController::class);
    Route::get('representatives/print-representative-invoice/{transaction_id}', [RepresentativeController::class,'printRepresentativeInvoice'])->name('representatives.print_representative_invoice');
    Route::get('representatives/pay/{transaction_id}', [RepresentativeController::class,'pay'])->name('representatives.pay');
    Route::resource('expense', ExpenseController::class);

    // Reports
    // Product Report
    Route::get('reports/product/',[ReportController::class,'getProductReport'])->name('reports.products');
    Route::get('reports/product/{id}',[ReportController::class,'viewProductDetails'])->name('reports.product_details');
    Route::get('reports/{product}/sell_price_less_purchase_price',[ReportController::class,'sell_price_less_purchase_price'])->name('reports.sell_price_less_purchase_price');
    // Initial Balance
    Route::get('reports/initial_balance',[ReportController::class,'initialBalanceReport'])->name('reports.initial_balance');
    // Add Stock
    Route::get('reports/add_stock',[ReportController::class,'addStock'])->name('reports.add_stock');
    // Best Seller
    Route::get('reports/best_seller',[ReportController::class,'bestSellerReport'])->name('reports.best_seller');
    // Daily Sales Report
    Route::get('reports/daily_sales_report',[ReportController::class,'dailySalesReport'])->name('reports.daily_sales_report');
    // Daily purchase Report
    Route::get('reports/daily_purchase_report',[ReportController::class,'dailyPurchaseReport'])->name('reports.daily_purchase_report');
    // ++++++++++++++++++ Task 03-01-2024 : Cash +++++++++++++++++++++
    Route::resource('cash', CashController::class);

    // close cashier
    Route::get('cash/add-closing-cash/{cash_register_id}', [CashController::class,'addClosingCash']);
    Route::post('cash/save-add-closing-cash', [CashController::class,'saveAddClosingCash'])->name('cash.save-add-closing-cash');
    Route::resource('cash-register', CashRegisterController::class);
    Route::get('add-stock/get-source-by-type-dropdown/{type}', [AddStockController::class,'getSourceByTypeDropdown']);
    Route::get('get_currency', [SettingController::class,'get_currency']);

    // Customer Balance Adjustment
    Route::resource('customer-balance-adjustment', CustomerBalanceAdjustmentsController::class);

    // Store Transfer
    Route::view('store_transfer/create','store_transfer.create')->name('store_transfer.create');
    Route::get('store_transfer', [StoreTransferController::class,'index'])->name('store_transfer.index');




});

Route::get('create-or-update-system-property/{key}/{value}', [SettingController::class,'createOrUpdateSystemProperty'])->middleware('timezone');


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
