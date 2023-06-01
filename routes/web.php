<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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

Route::get('/testing', function () {
    $x = \App\Models\Ticket::make([
        'title' => 'test',
        'description' => 'test',
        'status' => 'test',
        'priority' => 'test',
        'user_id' => 1,
    ]);
    dd($x);
});
Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('all-accounts', 'App\Http\Controllers\AllAccountController');
Route::resource('composite-products','App\Http\Controllers\CompositeProductsController');
Route::get('composite-products-all/{stock_id}','App\Http\Controllers\CompositeProductsController@getAllByStock');
Route::resource('balance-sheet', 'App\Http\Controllers\BalanceSheetController');
Route::post('get-balance-sheet', 'App\Http\Controllers\BalanceSheetController@getReport');
Route::post('download-sheet', 'App\Http\Controllers\BalanceSheetController@downloadSheet')->name('download-sheet');
Route::post('download-product-sheet', 'App\Http\Controllers\ProductsController@downloadSheet')->name('download-product-sheet');

Route::get('days-search','App\Http\Controllers\DayController@daySearch');
Route::resource('days', 'App\Http\Controllers\DayController');
Route::post('return-day', 'App\Http\Controllers\DayController@returnDay')->name('return-day');
Route::resource('costs', 'App\Http\Controllers\CostController');


Route::resource('account-statement', 'App\Http\Controllers\AccountStatementController');
Route::resource('project-statement', 'App\Http\Controllers\ProjectStatementController');
Route::get('account-graph', 'App\Http\Controllers\AccountStatementController@accountGraph');
Route::post('get-account-graph', 'App\Http\Controllers\AccountStatementController@getAccountGraph')->name('get-account-graph');
Route::post('account-statemeent-excel','App\Http\Controllers\AccountStatementController@excel')->name('account-statemeent-excel');

Route::resource('income-list', 'App\Http\Controllers\IncomeListController');

Route::resource('stock-management', 'App\Http\Controllers\StockManageMentController');

Route::resource('stocks', 'App\Http\Controllers\StockController');
Route::get('stock-excel/{id}','App\Http\Controllers\StockController@exel')->name('stock-excel');
Route::resource('orders', 'App\Http\Controllers\PurchaseOrderController');

Route::get('order-total/{id}', 'App\Http\Controllers\PurchaseOrderController@getTotal')->name('order-total');

Route::get('create-permission', 'App\Http\Controllers\ReceiptsController@createPermission')->name('create-permission');
Route::post('permission-add', 'App\Http\Controllers\ReceiptsController@permissionAdd')->name('permission-add');

Route::get('make-payment', 'App\Http\Controllers\InvoicesController@makePayment')->name('make-payment');

Route::get('stock-report', 'App\Http\Controllers\StockController@stockReport')->name('stock-report');
Route::post('create-stock-report', 'App\Http\Controllers\StockController@createStockReport')->name('create-stock-report');

Route::get('client-report', 'App\Http\Controllers\ClientsController@clientReport')->name('client-report');
Route::post('create-client-report', 'App\Http\Controllers\ClientsController@createClientReport')->name('create-client-report');


Route::resource('sections', 'App\Http\Controllers\SectionsController');


Route::resource('clients', 'App\Http\Controllers\ClientsController');
Route::get('/ClientDetails/{id?}{start_at?}{end_at?}', 'App\Http\Controllers\ClientsController@edit')->name('ClientDetails');
// Route::get('Search_client', 'App\Http\Controllers\ClientsController@Search_client')->name('Search_client');

Route::resource('InvoiceAttachments', 'App\Http\Controllers\InvoiceAttachmentsController');
Route::get('download/{invoice_id}/{file_name}', 'App\Http\Controllers\InvoiceAttachmentsController@get_file');

Route::get('View_file/{invoice_id}/{file_name}', 'App\Http\Controllers\InvoiceAttachmentsController@open_file');

Route::post('delete_file', 'App\Http\Controllers\InvoiceAttachmentsController@destroy')->name('delete_file');

Route::resource('SupplierAttachments', 'App\Http\Controllers\SupplierAttachmentsController');
Route::get('download_s/{supplier_id}/{file_name}', 'App\Http\Controllers\SupplierAttachmentsController@get_file');
Route::get('View_file_s/{supplier_id}/{file_name}', 'App\Http\Controllers\SupplierAttachmentsController@open_file');
Route::post('delete_file_s', 'App\Http\Controllers\SupplierAttachmentsController@destroy')->name('delete_file_s');

Route::resource('ClientAttachments', 'App\Http\Controllers\ClientAttachmentsController');
Route::get('download_c/{client_id}/{file_name}', 'App\Http\Controllers\ClientAttachmentsController@get_file');
Route::get('View_file_c/{client_id}/{file_name}', 'App\Http\Controllers\ClientAttachmentsController@open_file');
Route::post('delete_file_c', 'App\Http\Controllers\ClientAttachmentsController@destroy')->name('delete_file_c');


Route::get('/offer_data/{id}', 'App\Http\Controllers\InvoicesController@getoffer');
Route::get('/get-offer/{id}', 'App\Http\Controllers\OffersController@getOffer')->name('get-offer');


Route::resource('suppliers', 'App\Http\Controllers\SuppliersController');
Route::get('/SupplierDetails/{id?}{start_at?}{end_at?}', 'App\Http\Controllers\SuppliersController@edit')->name('SupplierDetails');



Route::resource('products', 'App\Http\Controllers\ProductsController');

Route::get('product_cat/{id}','App\Http\Controllers\ProductsController@product_cat');


Route::resource('offers', 'App\Http\Controllers\OffersController');
Route::resource('offer_products', 'App\Http\Controllers\OfferProductsController');
Route::get('/OfferDetails/{id}', 'App\Http\Controllers\OfferProductsController@edit');
Route::post('add_product', 'App\Http\Controllers\OfferProductsController@add_product')->name('add_product');
Route::post('delete_product', 'App\Http\Controllers\OfferProductsController@destroy')->name('delete_product');
Route::get('Print_offer/{id}','App\Http\Controllers\OffersController@Print_offer');
Route::get('Print_offer_en/{id}','App\Http\Controllers\OffersController@Print_offer_en');


Route::resource('invoices', 'App\Http\Controllers\InvoicesController');

Route::post('payment', 'App\Http\Controllers\InvoicesController@payment')->name('payment');
Route::get('/InvoiceDetails/{id}', 'App\Http\Controllers\InvoicesController@edit');
Route::get('Print_invoice/{id}','App\Http\Controllers\InvoicesController@Print_invoice');
Route::get('Print_invoice_Permission/{id}','App\Http\Controllers\InvoicesController@Print_invoice_Permission');




Route::resource('returned_invoices', 'App\Http\Controllers\ReturnedInvoiceController');
Route::get('Print_returned/{id}','App\Http\Controllers\ReturnedInvoiceController@Print_returned');





Route::resource('receipts', 'App\Http\Controllers\ReceiptsController');
Route::get('/ReceiptDetails/{id}', 'App\Http\Controllers\ReceiptsController@edit');
Route::post('PaymentReceipt', 'App\Http\Controllers\ReceiptsController@payment')->name('PaymentReceipt');
Route::resource('returned-receipts', 'App\Http\Controllers\ReturnedReceiptsController');

Route::get('Print_receipt/{id}','App\Http\Controllers\ReceiptsController@Print_receipt');
Route::get('Print_receipt_Permission/{id}','App\Http\Controllers\ReceiptsController@Print_receipt_Permission');


Route::resource('receipts_s', 'App\Http\Controllers\SpareReceiptsController');
Route::get('/ReceiptDetails_s/{id}', 'App\Http\Controllers\SpareReceiptsController@edit');
Route::post('PaymentReceipt_s', 'App\Http\Controllers\SpareReceiptsController@payment')->name('PaymentReceipt_s');
Route::get('Print_receipt_s/{id}','App\Http\Controllers\SpareReceiptsController@Print_receipt');
Route::get('Print_receipt_Permission_s/{id}','App\Http\Controllers\SpareReceiptsController@Print_receipt_Permission');


Route::post('invoice_finish', 'App\Http\Controllers\InvoicesController@invoice_finish')->name('invoice_finish');
Route::post('spare_invoice_finish', 'App\Http\Controllers\SpareinvoicesController@spare_invoice_finish')->name('spare_invoice_finish');
Route::post('returned_finish', 'App\Http\Controllers\ReturnedInvoiceController@returned_finish')->name('returned_finish');


Route::post('receipt_finish', 'App\Http\Controllers\ReceiptsController@receipt_finish')->name('receipt_finish');
Route::post('spare_receipts_finish', 'App\Http\Controllers\SpareReceiptsController@spare_receipts_finish')->name('spare_receipts_finish');


Route::get('offers_report', 'App\Http\Controllers\Offers_Report@index');
Route::get('revenues_report', 'App\Http\Controllers\Offers_Report@revenues_report');

Route::post('/Search_offers', 'App\Http\Controllers\Offers_Report@Search_offers');
Route::post('/search_revenue', 'App\Http\Controllers\Offers_Report@search_revenue');

Route::get('expenses_report', 'App\Http\Controllers\Offers_Report@expenses');
Route::post('Search_expenses', 'App\Http\Controllers\Offers_Report@Search_expenses');


Route::get('checks_report', 'App\Http\Controllers\Offers_Report@checks_report')->name('checks_report');
Route::post('search_checks', 'App\Http\Controllers\Offers_Report@search_checks');

Route::get('expenses2_report', 'App\Http\Controllers\Offers_Report@expenses2');
Route::post('Search_expenses2', 'App\Http\Controllers\Offers_Report@Search_expenses2');

Route::get('invoice_report', 'App\Http\Controllers\Offers_Report@invoice_report');
Route::post('Search_invoice', 'App\Http\Controllers\Offers_Report@Search_invoice');

Route::get('invoice_report_s', 'App\Http\Controllers\Offers_Report@invoice_report_s');
Route::post('Search_invoice_s', 'App\Http\Controllers\Offers_Report@Search_invoice_s');

Route::get('client_report', 'App\Http\Controllers\Offers_Report@client_report');
Route::get('clients_report', 'App\Http\Controllers\Offers_Report@clients_report');
Route::post('Search_client', 'App\Http\Controllers\Offers_Report@Search_client');

Route::get('supplier_report', 'App\Http\Controllers\Offers_Report@supplier_report');
Route::get('suppliers_report', 'App\Http\Controllers\Offers_Report@suppliers_report');
Route::get('products_report', 'App\Http\Controllers\Offers_Report@products_report');
Route::get('spares_report', 'App\Http\Controllers\Offers_Report@spares_report');
Route::post('Search_supplier', 'App\Http\Controllers\Offers_Report@Search_supplier');

Route::get('assetss', 'App\Http\Controllers\Offers_Report@assets');

Route::get('/section/{id}', 'App\Http\Controllers\OffersController@getproducts');

Route::resource('collective_offers','App\Http\Controllers\CollectiveOffersController');

Route::resource('asset-management', 'App\Http\Controllers\AssetManagementController');
Route::get('mokhss-elahlak', 'App\Http\Controllers\AssetManagementController@mokhss_elahlak');
Route::get('show-mokhss-elahlak', 'App\Http\Controllers\AssetManagementController@show_mokhss_elahlak');
Route::post('create-mokhss-elahlak', 'App\Http\Controllers\AssetManagementController@create_mokhss_elahlak');







Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', 'App\Http\Controllers\RoleController');
    Route::resource('users', 'App\Http\Controllers\UserController');
    Route::resource('product-spare', 'App\Http\Controllers\ProductSpareController');
    Route::get('get-all-products/{search?}', 'App\Http\Controllers\ProductSpareController@getAllProducts');

    Route::resource('addresses', 'App\Http\Controllers\AddresseController');
    Route::get('get-addresses-select2/{search?}', 'App\Http\Controllers\AddresseController@getAddressesSelect2');


    Route::resource('insurances', 'App\Http\Controllers\InsuranceController');
    Route::get('get-client-invoices/{client_id}', 'App\Http\Controllers\InsuranceController@getClientInvoices');
    Route::get('get-client-invoicesProducts/{client_id}/{invoice_id?}', 'App\Http\Controllers\InsuranceController@getClientInvoicesProducts');
    Route::post('insurances-excel', 'App\Http\Controllers\InsuranceController@insurancesExcel');
    Route::post('print-insurance-table', 'App\Http\Controllers\InsuranceController@printInsuranceTable');
    Route::resource('employees', 'App\Http\Controllers\EmployeeController');
    Route::get(
        'attendances/{employee?}/{date?}',
        'App\Http\Controllers\AttendanceController@viewEmployeeAttendance'
    );
    Route::post('attendances/checkin/{employee?}/{date?}', 'App\Http\Controllers\AttendanceController@checkin');
    Route::post('attendances/checkout/{employee?}/{date?}', 'App\Http\Controllers\AttendanceController@checkout');

    Route::resource('compensation-types', 'App\Http\Controllers\CompensationTypeController');
    Route::resource('tickets', 'App\Http\Controllers\TicketController');
    Route::get('tickets/compensation/{ticket}', 'App\Http\Controllers\TicketController@createCompensation');
    Route::post('tickets/compensation/{ticket}', 'App\Http\Controllers\TicketController@storeCompensation')->name('tickets.compensation.store');
    Route::get('check-client-insurance/{client}', 'App\Http\Controllers\InsuranceController@checkClientInsuranceState')->name('client-insurance-check');
    Route::get('get-client-insurance/{client}', 'App\Http\Controllers\InsuranceController@getClientInsurance')->name('client-insurance');
    Route::get('get-client-invoice-products/{client_id}', 'App\Http\Controllers\InsuranceController@retrieveClientInvoiceProducts')->name('client-invoice-products');
    Route::get('get-spare-products-by-ticket/{ticket}/{stock}','App\Http\Controllers\TicketController@ticketSpareProducts');
    Route::get('get-ticket-offers/{ticket_id}', 'App\Http\Controllers\OffersController@getTicketOffers');
    Route::post('get-client-serials', 'App\Http\Controllers\InsuranceController@getClientSerial');
    Route::get('get-client-serials/{client_id}', 'App\Http\Controllers\InsuranceController@retrieveClientSerials');
    Route::get('get-invoice-products-address/{invoice_product_id}', 'App\Http\Controllers\InsuranceController@getInvoiceProductAddress');
    Route::get('get-insurance-address/{serial_id}', 'App\Http\Controllers\InsuranceController@getSerialAddress');

    Route::get('create-offer-for-ticket/{ticket}','App\Http\Controllers\OffersController@createOfferForTicket');
});
// get all attendance for specific employee

//Route::get('/{page}', 'App\Http\Controllers\AdminController@index');






