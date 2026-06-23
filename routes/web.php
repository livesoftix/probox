<?php
use App\Http\Controllers\StockOpeningController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\LedgerDetailController;
use App\Http\Controllers\PayableController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\EmployeeTypeController;
use App\Http\Controllers\ErpParamController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\StockManageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BankReciptController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\BankPaymentController; 
use App\Http\Controllers\OfficeCashController; 
use App\Http\Controllers\GateExController; 
use App\Http\Controllers\account\BillController;
use App\Http\Controllers\account\LoanController;
use App\Http\Controllers\GluePurchaseController;
use App\Http\Controllers\GlueReturnController;
use App\Http\Controllers\InkPurchaseController;
use App\Http\Controllers\InkReturnController;
use App\Http\Controllers\account\GroupController;
use App\Http\Controllers\account\PartyController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PlatePurchaseController; 
use App\Http\Controllers\PlateReturnController; 
use App\Http\Controllers\account\Level1Controller;
use App\Http\Controllers\account\Level2Controller;
use App\Http\Controllers\account\Level3Controller;
use App\Http\Controllers\JournalVoucherController;
use App\Http\Controllers\OpenBalController;
use App\Http\Controllers\PaymentInvoiceController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\DeliveryChallanController;
use App\Http\Controllers\ConfectioneryController;
use App\Http\Controllers\RecieveableableController;
use App\Http\Controllers\category\CategoryController;
use App\Http\Controllers\LeminationPurchaseController;
use App\Http\Controllers\LaminationReturnController;
use App\Http\Controllers\PackagingSpecController;
use App\Http\Controllers\DisposablePurchaseController;

use App\Http\Controllers\CorrugationPurchaseController;
use App\Http\Controllers\CorrugationReturnController;
use App\Http\Controllers\ShipperPurchasesController;
use App\Http\Controllers\ShipperReturnController;
use App\Http\Controllers\account\AccountMasterController;
use App\Http\Controllers\WastageSaleController;
use App\Http\Controllers\WastageController;
use App\Http\Controllers\SaleInvoiceController;
use App\Http\Controllers\ConfectBillingController;
use App\Http\Controllers\GatePassInController;
use App\Http\Controllers\GatePassOutController;
use App\Http\Controllers\RegistrationFormController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StorageLinkController;
use App\Http\Controllers\PhpIniController;
use App\Http\Controllers\PhpInfoController;
use App\Http\Controllers\ProductLogController;
use App\Http\Controllers\ChequeReceiptsController;
use App\Http\Controllers\DatabaseTestController;
use App\Http\Controllers\CreateAccountController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SReportsController;
use App\Http\Controllers\DailyStatementController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportStockController;
use App\Http\Controllers\JobSheetController;
use App\Http\Controllers\CustomController;
use App\Http\Controllers\DepartmentSectionController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ExtraTimeController;
use App\Http\Controllers\DyeSectionController;
use App\Http\Controllers\PasteSectionController;
use App\Http\Controllers\ProcessSectionController;
use App\Http\Controllers\AttendenceFormController;
use App\Http\Controllers\DyePurchaseController;
use App\Http\Controllers\DyeReturnController;
use App\Http\Controllers\GeneralJobSheetController;
use App\Http\Controllers\GeneralDeliveryChallanController;
use App\Http\Controllers\GeneralBillingController;
use App\Http\Controllers\WageBoxboardController;
use App\Http\Controllers\SalaryCalculatorController;
use App\Http\Controllers\BankCashReportController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockAdjController;
use App\Http\Controllers\BoxboardReportStockController;
use App\Http\Controllers\TempJobSheetController;
use Illuminate\Support\Facades\Artisan;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/config-clear', function () {
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    return "✅ Config cleared and cached!";
});

// Route to run migrations via web (admin only, secure as needed)
Route::get('/probox/migrate', function () {
    \Artisan::call('migrate', ['--force' => true]);
    return "✅ Migration completed!";
})->middleware(['auth', 'admin']);

Route::get('/probox/backup', [BackupController::class, 'runBackup'])->name('admin.backup');

Route::get('/probox', function () {
    return redirect()->route('login');
});

Route::get('/probox/create-storage-link', [StorageLinkController::class, 'createLink']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/probox/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard.admin');
    Route::get('/probox/create_account', [CreateAccountController::class, 'index'])->name('create_account.list');
    Route::get('/probox/create_account/reports', [CreateAccountController::class, 'reports'])->name('create_account.reports');
    Route::post('/probox/create_account', [CreateAccountController::class, 'store'])->name('create_account.store');
    Route::get('/probox/create_account/delete/{id}', [CreateAccountController::class, 'delete'])->name('create_account.delete');
    Route::get('/probox/create_account/edit/{id}', [CreateAccountController::class, 'edit'])->name('create_account.edit');
    Route::put('/probox/create_account/update/{id}', [CreateAccountController::class, 'update'])->name('create_account.update');


});



Route::middleware('auth')->group(function () {
    
    Route::get('/probox/salary_calc', [SalaryCalculatorController::class, 'index'])->name('salary_calc.list');
    Route::post('/probox/salary_calc', [SalaryCalculatorController::class, 'store'])->name('salary_calc.store');
    Route::post('/probox/salary_calc/get-data', [SalaryCalculatorController::class, 'getSalaryData'])->name('salary_calc.get_data');    
    
    Route::get('/probox/attendence_form', [AttendenceFormController::class, 'index'])->name('attendence_form.list');
    Route::post('/probox/attendence_form', [AttendenceFormController::class, 'store'])->name('attendence_form.store');
    Route::get('/probox/attendence_form/reports', [AttendenceFormController::class, 'reports'])->name('attendence_form.reports');
    Route::delete('/probox/attendence_form/{id}', [AttendenceFormController::class, 'destroy'])->name('attendence_form.destroy');
    Route::get('/probox/attendence_form/{id}/edit', [AttendenceFormController::class, 'edit'])->name('attendence_form.edit');
    Route::put('/probox/attendence_form/{id}', [AttendenceFormController::class, 'update'])->name('attendence_form.update');
    
    Route::get('/probox/check-attendance-status', [AttendenceFormController::class, 'checkAttendanceStatus'])->name('check.attendance.status');
    
    
    Route::get('/probox/get-boxboard-details/{item_id}', [JobSheetController::class, 'getBoxboardDetails']);
    Route::get('/probox/get-ink-details/{item_id}', [JobSheetController::class, 'getinkDetails']);
    
    Route::get('/probox/get-lamination-details', [JobSheetController::class, 'getLaminationDetails']);
    Route::get('/probox/get-glue-details/{item_id}', [JobSheetController::class, 'getglueDetails']);
    Route::get('/probox/get-shipper-details/{item_id}', [JobSheetController::class, 'getshipperDetails']);
    Route::get('/probox/job_sheet', [JobSheetController::class, 'index'])->name('job.index');
    Route::post('/probox/job_sheet/store', [JobSheetController::class, 'store'])->name('job.store');
    Route::get('/probox/job_sheet/report', [JobSheetController::class, 'report'])->name('job.report');
    Route::delete('/probox/job-details', [JobSheetController::class, 'destroy'])->name('job-details.destroy');
    Route::get('/probox/job-details/{v_no}/edit', [JobSheetController::class, 'edit'])->name('job-details.edit');
    Route::put('/probox/job-details/{v_no}', [JobSheetController::class, 'update'])->name('job-details.update');
    Route::get('/probox/get-product-details', [JobSheetController::class, 'getProductDetails'])->name('get.product.details');
    
//temp job sheet
    Route::get('/probox/temp_job_sheet', [TempJobSheetController::class, 'report'])->name('tempjob.index');
    Route::post('/probox/temp_job_sheet/store', [TempJobSheetController::class, 'store'])->name('tempjob.store');
    Route::get('/probox/temp_job_sheet/report', [TempJobSheetController::class, 'report'])->name('tempjob.report');
    Route::get('/probox/temp_job_sheet/addnew', [TempJobSheetController::class, 'create'])->name('tempjob.list');
    Route::get('/tempjob/{id}/print', [TempJobSheetController::class, 'print'])
    ->name('tempjob.print');
    Route::delete('/probox/Tempjob-details', [TempJobSheetController::class, 'destroy'])->name('tempjob.destroy');

    Route::get('/probox/get-products/{customerId}', [JobSheetController::class, 'getProducts']);
    Route::get('/probox/fetch-custom-rate', [JobSheetController::class, 'fetchRate'])->name('fetch.custom.rate');
    Route::get('/probox/fetch-shipper-stock', [JobSheetController::class, 'fetchShipperStock'])->name('fetch.shipper.stock');
    Route::get('/probox/fetch-corrugation-stock', [JobSheetController::class, 'fetchCorrugationStock'])->name('fetch.corrugation.stock');
    
    
    Route::get('/probox/daily_statement/reports', [DailyStatementController::class, 'reports'])->name('daily_statement.reports');
    
    Route::get('/probox/expense/reports', [ExpenseController::class, 'reports'])->name('expense.reports');

    
    
    
    Route::get('/probox/general/job/sheet', [GeneralJobSheetController::class, 'index'])->name('general_job_sheet.list');
    Route::post('/probox/general-job-sheet', [GeneralJobSheetController::class, 'store'])->name('general-job-sheet.store');
    Route::get('/probox/general-job-sheet/report', [GeneralJobSheetController::class, 'report'])->name('general_job_sheet.report');
    Route::delete('/probox/general-job-sheet/{id}', [GeneralJobSheetController::class, 'destroy'])->name('general_job_sheet.destroy');
    Route::get('/probox/get-purchase-items', [GeneralJobSheetController::class, 'getPurchaseItems']);
    Route::get('/probox/get-purchase-item-details', [GeneralJobSheetController::class, 'getPurchaseItemDetails']);
    Route::get('/probox/general-job-sheet/{id}/edit', [GeneralJobSheetController::class, 'edit'])->name('general_job_sheet.edit');
    Route::put('/probox/general-job-sheet/{id}', [GeneralJobSheetController::class, 'update'])->name('general_job_sheet.update');
    
    
    Route::get('/probox/general/delivery/challan', [GeneralDeliveryChallanController::class, 'index'])->name('general_delivery_challan.list');
    Route::get('/probox/get-general-job-sheet-data', [GeneralDeliveryChallanController::class, 'getGeneralJobSheetData']);
    Route::post('/probox/general/delivery/challan/store', [GeneralDeliveryChallanController::class, 'store'])->name('general_delivery_challan.store');
    Route::get('/probox/general/delivery/challan/report', [GeneralDeliveryChallanController::class, 'report'])->name('general_delivery_challan.report');
    Route::delete('/probox/general-delivery-challan/{id}', [GeneralDeliveryChallanController::class, 'destroy'])->name('general_delivery_challan.destroy'); 
    Route::get('/probox/general-delivery-challan/{id}/edit', [GeneralDeliveryChallanController::class, 'edit'])->name('general_delivery_challan.edit'); 
    Route::put('/probox/general-delivery-challan//{id}', [GeneralDeliveryChallanController::class, 'update'])->name('general_delivery_challan.update'); 
     
     
    Route::get('/probox/general/billing', [GeneralBillingController::class, 'index'])->name('general_billing.list');
    Route::post('/probox/general/billing/store', [GeneralBillingController::class, 'store'])->name('general_billing.store');  
    Route::get('/probox/general/billing/report', [GeneralBillingController::class, 'report'])->name('general_billing.report');  
        Route::delete('/probox/general/billing/{id}', [GeneralBillingController::class, 'destroy'])->name('general_billing.destroy'); 
    Route::get('/probox/get-voucher-numbers/{partyId}', [GeneralBillingController::class, 'getVoucherNumbers'])->name('get.voucher.numbers');
    Route::get('/probox/get-voucher-details/{voucherNo}', [GeneralBillingController::class, 'getVoucherDetails']);
    Route::get('/probox/check-existing-billings', [GeneralBillingController::class, 'checkExistingBillings']);
     
     
     
    Route::get('/probox/boxboard/wage', [WageBoxboardController::class, 'index'])->name('boxboard_wage.list'); 
    Route::get('/probox/boxboard/wage/report', [WageBoxboardController::class, 'report'])->name('boxboard_wage.report'); 
    Route::get('/probox/boxboard/wage/vouchers/{employee_id}', [WageBoxboardController::class, 'getVouchersByEmployee'])->name('boxboard_wage.vouchers'); 
    Route::get('/probox/boxboard/wage/details/{employee_id}/{v_no}', [WageBoxboardController::class, 'getVoucherDetails'])->name('boxboard_wage.details'); 
    Route::post('/probox/boxboard/wage/store', [WageBoxboardController::class, 'store'])->name('boxboard_wage.store');  
    
     Route::delete('/probox/boxboard/wage/store/{id}', [WageBoxboardController::class, 'destroy'])->name('boxboard_wage.destroy');  
     
    Route::get('/probox/reports/stock', [ReportStockController::class, 'reports'])->name('report.stock');
    Route::get('/probox/reports/boxboard-stock', [BoxboardReportStockController::class, 'boxboard_report'])->name('report.boxboard_stock');
    Route::get('/probox/report_stock', [App\Http\Controllers\ReportStockController::class, 'index'])->name('report_stock.index');
    Route::get('/probox/report_stock/create', [App\Http\Controllers\ReportStockController::class, 'create'])->name('report_stock.create');
    Route::post('/probox/report_stock', [App\Http\Controllers\ReportStockController::class, 'store'])->name('report_stock.store');
    Route::get('/probox/report_stock/{id}/edit', [App\Http\Controllers\ReportStockController::class, 'edit'])->name('report_stock.edit');
    Route::post('/probox/report_stock/{id}/edit', [App\Http\Controllers\ReportStockController::class, 'edit'])->name('report_stock.edit.post');
    Route::put('/probox/report_stock/{id}', [App\Http\Controllers\ReportStockController::class, 'update'])->name('report_stock.update');
    Route::delete('/probox/report_stock/{id}', [App\Http\Controllers\ReportStockController::class, 'destroy'])->name('report_stock.destroy');

    
    Route::get('/probox/purchase/reports', [ReportsController::class, 'reports'])->name('purchase.reports');
    
    
    Route::get('/probox/sale/reports', [SReportsController::class, 'reports'])->name('sale.reports');
    Route::get('/probox/bank_cash/reports', [BankCashReportController::class, 'reports'])->name('bank_cash.reports');
    
    
    Route::get('/probox/get-item-details/{id}', [PaymentInvoiceController::class, 'getItemDetails'])->name('getItemDetails');
    Route::post('/probox/update-status/{id}', [CashController::class, 'updateStatus'])->name('cash.updateStatus');
   
    Route::get('/probox/user/dashboard', [DashboardController::class, 'user_index'])->name('dashboard.user');
    Route::get('/probox/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    
    Route::get('/probox/department', [DepartmentController::class, 'index'])->name('department.list');
    Route::get('/probox/department/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/probox/department', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('/probox/department/{id}/edit', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::post('/probox/department/{id}', [DepartmentController::class, 'update'])->name('department.update');
    Route::delete('/probox/department/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');
    
    Route::get('/probox/employee', [EmployeeController::class, 'index'])->name('employee.list');
    
    Route::get('/probox/employees', [EmployeesController::class, 'index'])->name('employees.list');
    Route::post('/probox/employees', [EmployeesController::class, 'store'])->name('employees.store');
    Route::get('/probox/employees/reports', [EmployeesController::class, 'reports'])->name('employees.reports');
        Route::get('/probox/employees/{id}', [EmployeesController::class, 'show'])->name('employees.show');

    Route::delete('/probox/employees/{id}', [EmployeesController::class, 'destroy'])->name('employees.destroy');
    Route::get('/probox/employees/{id}/edit', [EmployeesController::class, 'edit'])->name('employees.edit');
    Route::put('/probox/employees/{id}', [EmployeesController::class, 'update'])->name('employees.update');
   Route::get('/probox/extra-times/{id}', [EmployeesController::class, 'getRate']);
    
    Route::get('/probox/employee_type', [EmployeeTypeController::class, 'index'])->name('employee_type.list');
    Route::post('/probox/employee_type', [EmployeeTypeController::class, 'store'])->name('employee_type.store');
    Route::get('/probox/get-employee-details/{id}', [EmployeeTypeController::class, 'getEmployeeDetails']);
    
    
    Route::get('/probox/employee_type/reports', [EmployeeTypeController::class, 'reports'])->name('employee_type.reports');
    Route::get('/probox/employee_type/{id}/edit', [EmployeeTypeController::class, 'edit'])->name('employee_type.edit');
    Route::put('/probox/employee_type/{id}', [EmployeeTypeController::class, 'update'])->name('employee_type.update');
    Route::delete('/probox/employee_type/{id}', [EmployeeTypeController::class, 'destroy'])->name('employee_type.destroy');
    
    Route::get('/probox/category', [CategoryController::class, 'index'])->name('category.list');
    Route::post('/probox/category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/probox/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/probox/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/probox/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::get('/probox/category/create', [CategoryController::class, 'create'])->name('category.create');
    
    Route::get('/probox/bank', [BankController::class, 'index'])->name('bank.list');
    Route::post('/probox/bank', [BankController::class, 'store'])->name('bank.store');
    
    Route::get('/probox/erp_param', [ErpParamController::class, 'index'])->name('erp_param.list');
    Route::get('/probox/erp_param/create', [ErpParamController::class, 'create'])->name('erp_param.create');
    Route::post('/probox/erp_param', [ErpParamController::class, 'store'])->name('erp_param.store');
    Route::get('/probox/erp_param/{id}/edit', [ErpParamController::class, 'edit'])->name('erp_param.edit');
    Route::put('/probox/erp_param/{id}', [ErpParamController::class, 'update'])->name('erp_param.update');
    Route::delete('/probox/erp_param/{id}', [ErpParamController::class, 'destroy'])->name('erp_param.destroy');

    Route::get('/probox/cash', [CashController::class, 'index'])->name('cash.list');
    Route::get('/probox/cash/reports', [CashController::class, 'reports'])->name('cash.reports');
    Route::post('/probox/cash', [CashController::class, 'store'])->name('cash.store');
    Route::put('/probox/cash/{v_no}/update', [CashController::class, 'update'])->name('cash.update'); // Use PUT for update
    Route::get('/probox/cash/{v_no}/edit', [CashController::class, 'edit'])->name('cash.edit');
    Route::get('/probox/cash/{id}', [CashController::class, 'destroy'])->name('cash.destroy');
    Route::delete('/probox/cash-delete/{id}', [CashController::class, 'delete'])->name('cash.delete');
    Route::get('/probox/cash/create', [CashController::class, 'create'])->name('cash.create');

    Route::get('/probox/payment', [PaymentController::class, 'index'])->name('payment.list');
    Route::get('/probox/paymentreports', [PaymentController::class, 'reports'])->name('payment.reports');
    Route::post('/probox/payment', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/probox/payment/{v_no}/edit', [PaymentController::class, 'edit'])->name('payment.edit');
    Route::put('/probox/payment/{v_no}/update', [PaymentController::class, 'update'])->name('payment.update');
    Route::get('/probox/payment/{id}', [PaymentController::class, 'destroy'])->name('payment.destroy');
    Route::delete('/probox/payment-delete/{id}', [PaymentController::class, 'delete'])->name('payment.delete');
    Route::get('/probox/payment/create', [PaymentController::class, 'create'])->name('payment.create');

   
    Route::get('/probox/bank_payment', [BankPaymentController::class, 'index'])->name('bank_payment.list');
    Route::post('/probox/bank_payment', [BankPaymentController::class, 'store'])->name('bank_payment.store');
    Route::get('/probox/bank_payment/reports', [BankPaymentController::class, 'reports'])->name('bank_payment.reports');
    Route::get('/probox/bank_payment/{v_no}/edit', [BankPaymentController::class, 'edit'])->name('bank_payment.edit');
    Route::put('/probox/bank_payment/{v_no}/update', [BankPaymentController::class, 'update'])->name('bank_payment.update');
    Route::get('/probox/bank_payment/{id}', [BankPaymentController::class, 'destroy'])->name('bank_payment.destroy');
    Route::delete('/probox/bank_payment-delete/{id}', [BankPaymentController::class, 'delete'])->name('bank_payment.delete');

    Route::get('/probox/gate_ex', [GateExController::class, 'index'])->name('gate_ex.list');
    Route::post('/probox/gate_ex', [GateExController::class, 'store'])->name('gate_ex.store');
    Route::get('/probox/gate_ex/reports', [GateExController::class, 'reports'])->name('gate_ex.reports');
    Route::get('/probox/gate_ex/{v_no}/edit', [GateExController::class, 'edit'])->name('gate_ex.edit');
    Route::put('/probox/gate_ex/{v_no}/update', [GateExController::class, 'update'])->name('gate_ex.update');
    Route::get('/probox/gate_ex/{id}', [GateExController::class, 'destroy'])->name('gate_ex.destroy');
    Route::delete('/probox/gate_ex-delete/{id}', [GateExController::class, 'delete'])->name('gate_ex.delete');
    
    
    Route::get('/probox/office_cash', [OfficeCashController::class, 'index'])->name('office_cash.list');
    Route::post('/probox/office_cash', [OfficeCashController::class, 'store'])->name('office_cash.store');
    Route::get('/probox/office_cash/reports', [OfficeCashController::class, 'reports'])->name('office_cash.reports');
    Route::get('/probox/office_cash/{v_no}/edit', [OfficeCashController::class, 'edit'])->name('office_cash.edit');
    Route::put('/probox/office_cash/{v_no}/update', [OfficeCashController::class, 'update'])->name('office_cash.update');
    Route::get('/probox/office_cash/{id}', [OfficeCashController::class, 'destroy'])->name('office_cash.destroy');
    Route::delete('/probox/office_cash-delete/{id}', [OfficeCashController::class, 'delete'])->name('office_cash.delete');
    
    Route::get('/probox/bank_recipt', [BankReciptController::class, 'index'])->name('bank_recipt.list');
    Route::post('/probox/bank_recipt', [BankReciptController::class, 'store'])->name('bank_recipt.store');
    Route::get('/probox/bank_recipt/reports', [BankReciptController::class, 'reports'])->name('bank_recipt.reports');
    Route::get('/probox/bank_recipt/{id}/edit', [BankReciptController::class, 'edit'])->name('bank_recipt.edit');
    Route::put('/probox/bank_recipt/{v_no}/update', [BankReciptController::class, 'update'])->name('bank_recipt.update');
    Route::get('/probox/bank_recipt/{id}', [BankReciptController::class, 'destroy'])->name('bank_recipt.destroy');
    Route::delete('/probox/bank_recipt-delete/{id}', [BankReciptController::class, 'delete'])->name('bank_recipt.delete');

    Route::get('/probox/ledger', [LedgerController::class, 'index'])->name('ledger.list');
    Route::get('/probox/ledger_detail', [LedgerDetailController::class, 'index'])->name('ledger_detail.list');

    Route::get('/probox/payables', [PayableController::class, 'index'])->name('payables.list');

    Route::get('/probox/recieveables', [RecieveableableController::class, 'index'])->name('recieveables.list');
    
//   Route::get('/probox/packaging-specs', [PackagingSpecController::class, 'index'])->name('packaging-specs.index');
    Route::resource('/probox/packaging-specs', PackagingSpecController::class);
    // Route::get('packaging-specs/{packagingSpec}/pdf', [PackagingSpecController::class, 'downloadPDF'])->name('packaging-specs.pdf');
    Route::get('/probox/packaging-specs/{packagingSpec}/print', [PackagingSpecController::class, 'print'])->name('packaging-specs.print');
    
    //search routes for packaging specs
    Route::get('/probox/search-company', [PackagingSpecController::class, 'searchCompany']);
Route::get('/probox/search-item', [PackagingSpecController::class, 'searchItem']);

    Route::get('/probox/journal_voucher', [JournalVoucherController::class, 'index'])->name('journal_voucher.list');
    Route::post('/probox/journal_voucher', [JournalVoucherController::class, 'store'])->name('journal_voucher.store');
    Route::get('/probox/journal_voucher/reports', [JournalVoucherController::class, 'reports'])->name('journal_voucher.reports');
    Route::get('/probox/journal_voucher/{v_no}/edit', [JournalVoucherController::class, 'edit'])->name('journal_voucher.edit');
    Route::get('/probox/journal_voucher/delete/{id}', [JournalVoucherController::class, 'delete'])->name('journal_voucher.delete');
    Route::put('/probox/journal_voucher/{v_no}/update', [JournalVoucherController::class, 'update'])->name('journal_voucher.update');
    Route::delete('/probox/journal_voucher/{id}', [JournalVoucherController::class, 'destroy'])->name('journal_voucher.destroy');

    Route::get('/probox/open_bal', [OpenBalController::class, 'index'])->name('open_bal.list');
    Route::post('/probox/open_bal', [OpenBalController::class, 'store'])->name('open_bal.store');
    Route::get('/probox/open_bal/reports', [OpenBalController::class, 'reports'])->name('open_bal.reports');
    Route::get('/probox/open_bal/{v_no}/edit', [OpenBalController::class, 'edit'])->name('open_bal.edit');
    Route::get('/probox/open_bal/delete/{id}', [OpenBalController::class, 'delete'])->name('open_bal.delete');
    Route::put('/probox/open_bal/{v_no}/update', [OpenBalController::class, 'update'])->name('open_bal.update');
    Route::delete('/probox/open_bal/{id}', [OpenBalController::class, 'destroy'])->name('open_bal.destroy');
    
    
    Route::get('/probox/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::get('/probox/employee/create1', [EmployeeController::class, 'create1'])->name('employee.create1');
    Route::post('/probox/employee', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('/probox/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::put('/probox/employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('/probox/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');

    Route::post('/probox/account/level1', [Level1Controller::class, 'store'])->name('level1.store');
    Route::get('/probox/account/level1', [Level1Controller::class, 'index'])->name('level1.list');
    Route::get('/probox/account/level1/create', [Level1Controller::class, 'create'])->name('level1.create');
    Route::get('/probox/account/level1/{id}/edit', [Level1Controller::class, 'edit'])->name('level1.edit');
    Route::post('/probox/account/level1/{id}', [Level1Controller::class, 'update'])->name('level1.update');
    Route::delete('/probox/account/level1/{id}', [Level1Controller::class, 'destroy'])->name('level1.destroy');

    Route::post('/probox/account/level2', [Level2Controller::class, 'store'])->name('level2.store');
    Route::get('/probox/account/level2', [Level2Controller::class, 'index'])->name('level2.list');
    Route::get('/probox/account/level2/create', [Level2Controller::class, 'create'])->name('level2.create');
    Route::get('/probox/account/level2/{id}/edit', [Level2Controller::class, 'edit'])->name('level2.edit');
    Route::post('/probox/account/level2/{id}', [Level2Controller::class, 'update'])->name('level2.update');
    Route::delete('/probox/account/level2/{id}', [Level2Controller::class, 'destroy'])->name('level2.destroy');

    Route::post('/probox/account/level3', [Level3Controller::class, 'store'])->name('level3.store');
    Route::get('/probox/account/level3', [Level3Controller::class, 'index'])->name('level3.list');
    Route::get('/probox/account/level3/create', [Level3Controller::class, 'create'])->name('level3.create');

    Route::post('/probox/account/group', [GroupController::class, 'store'])->name('group.store');
    Route::get('/probox/account/group', [GroupController::class, 'index'])->name('group.list');
    Route::get('/probox/account/group/create', [GroupController::class, 'create'])->name('group.create');

    Route::post('/probox/account/a_master', [AccountMasterController::class, 'store'])->name('amaster.store');
    Route::get('/probox/account/a_master', [AccountMasterController::class, 'index'])->name('amaster.list');
    Route::get('/probox/account/reports', [AccountMasterController::class, 'reports'])->name('account.reports');
    Route::get('/probox/account/a_master/create', [AccountMasterController::class, 'create'])->name('amaster.create');
    Route::get('/probox/account/a_master/{id}/edit', [AccountMasterController::class, 'edit'])->name('amaster.edit');
    Route::post('/probox/account/a_master/{id}', [AccountMasterController::class, 'update'])->name('amaster.update');
    Route::delete('/probox/account/a_master/{id}', [AccountMasterController::class, 'destroy'])->name('amaster.destroy');

    Route::post('/probox/amount/party', [PartyController::class, 'store'])->name('party.store');
    Route::get('/probox/account/party', [PartyController::class, 'index'])->name('party.list');
    Route::get('/probox/account/party/create', [PartyController::class, 'create'])->name('party.create');
    Route::get('/probox/account/bill', [BillController::class, 'index'])->name('bill.list');
    Route::post('/probox/account/bill', [BillController::class, 'store'])->name('bill.store');
    Route::get('/probox/account/bill/create', [BillController::class, 'create'])->name('bill.create');
    Route::get('/probox/account/loan', [LoanController::class, 'index'])->name('loan.list');
    Route::post('/probox/account/loan', [LoanController::class, 'store'])->name('loan.store');
    Route::get('/probox/account/loan/create', [LoanController::class, 'create'])->name('loan.create');

    Route::get('/probox/inventory/itemmaster', [InventoryController::class, 'index_itemmaster'])->name('inventory.itemmaster.list');
    Route::get('/probox/inventory/itemmaster/{id}/edit', [InventoryController::class, 'itemmasteredit'])->name('inventory.itemmaster.edit');
    Route::post('/probox/inventory/itemmaster/{id}', [InventoryController::class, 'itemmasterupdate'])->name('inventory.itemmaster.update');
    Route::delete('/probox/inventory/itemmaster/{id}', [InventoryController::class, 'itemmasterdestroy'])->name('inventory.itemmaster.destroy');
       Route::get('/probox/productqty/{item_id}/{v_date}/{which}', [StockManageController::class, 'ink'])->name('paymentqty.list');
    Route::get('/probox/lamination/{item_id}/{v_date}/{size}', [StockManageController::class, 'lamination'])->name('paymentqty.lamination');
    Route::get('/probox/inventory/itemtype', [InventoryController::class, 'index_itemtype'])->name('inventory.itemtype.list');
    Route::post('/probox/inventory/itemmaster', [InventoryController::class, 'itemmaster'])->name('inventory.itemmaster');
    Route::post('/probox/inventory/itemtype', [InventoryController::class, 'itemtype'])->name('inventory.itemtype');
    Route::get('/probox/inventory/itemtype/{id}/edit', [InventoryController::class, 'itemtypeedit'])->name('inventory.itemtype.edit');
    Route::post('/probox/inventory/itemtype/{id}', [InventoryController::class, 'itemtypeupdate'])->name('inventory.itemtype.update');
    Route::delete('/probox/inventory/itemtype/{id}', [InventoryController::class, 'itemtypedestroy'])->name('inventory.itemtype.destroy');
    Route::get('/probox/inventory/create/itemmaster', [InventoryController::class, 'createitemmaster'])->name('inventory.create.itemmaster');
    Route::get('/probox/inventory/itemLog', [InventoryController::class, 'itemlogList'])->name('inventory.item_log');


    Route::get('/probox/inventory/create/itemtype', [InventoryController::class, 'createitemtype'])->name('inventory.create.itemtype');
    Route::post('/probox/inventory/boxboard', [InventoryController::class, 'boxboard'])->name('inventory.boxboard');
    Route::post('/probox/inventory/lamination', [InventoryController::class, 'lamination'])->name('inventory.lamination');
    Route::post('/probox/inventory/corrugation', [InventoryController::class, 'corrugation'])->name('inventory.corrugation');
    Route::post('/probox/inventory/plates', [InventoryController::class, 'plates'])->name('inventory.plates');
    Route::post('/probox/inventory/dye', [InventoryController::class, 'dye'])->name('inventory.dye');
    Route::post('/probox/inventory/ink', [InventoryController::class, 'ink'])->name('inventory.ink');

    
    Route::get('/probox/stock_report', [StockReportController::class, 'index'])->name('stock_report.list');
    Route::post('/probox/stock_report/store', [StockReportController::class, 'store'])->name('stock_report.store');
    Route::get('/probox/stock_report/reports', [StockReportController::class, 'reports'])->name('stock_report.reports');


    Route::get('/probox/delivery_challan', [DeliveryChallanController::class, 'index'])->name('delivery_challan.list');
    Route::get('/probox/get-products/{partyId}', [DeliveryChallanController::class, 'getProducts']);

    Route::get('/probox/delivery_challan/reports', [DeliveryChallanController::class, 'reports'])->name('delivery_challan.reports');
    Route::post('/probox/delivery_challan', [DeliveryChallanController::class, 'store'])->name('delivery_challan.store');
    Route::get('/probox/delivery_challan/edit/{v_no}', [DeliveryChallanController::class, 'edit'])->name('delivery_challan.edit');
    Route::put('/probox/delivery_challan/update/{id}', [DeliveryChallanController::class, 'update'])->name('delivery_challan.update');
    Route::get('/probox/delivery_challan/{v_no}/delete', [DeliveryChallanController::class, 'destroy'])->name('delivery_challan.destroy');
    Route::delete('/probox/delivery_challan/{id}/del', [DeliveryChallanController::class, 'delete'])->name('delivery_challan.delete');

    Route::get('/probox/delivery_challan/editCon/{v_no}', [DeliveryChallanController::class, 'editCon'])->name('delivery_challan.editDel');
    Route::put('/probox/delivery_challan/{v_no}/updateCon', [DeliveryChallanController::class, 'updateCon'])->name('delivery_challan.updateDel');

    Route::get('/probox/get-aid/{accountId}', [ConfectioneryController::class, 'getAid']);
    Route::get('/probox/confectionery', [ConfectioneryController::class, 'index'])->name('confectionery.list');
    Route::post('/probox/confectionery', [ConfectioneryController::class, 'store'])->name('confectionery.store');
    Route::get('/probox/confectionery/reports', [ConfectioneryController::class, 'reports'])->name('confectionery.reports');
    Route::get('/probox/confectionery/edit/{v_no}', [ConfectioneryController::class, 'edit'])->name('confectionery.edit');
    Route::put('/probox/confectionery/update/{id}', [ConfectioneryController::class, 'update'])->name('confectionery.update');
    Route::get('/probox/confectionery/{v_no}/delete', [ConfectioneryController::class, 'destroy'])->name('confectionery.destroy');
    Route::delete('/probox/confectionery/{id}/del', [ConfectioneryController::class, 'delete'])->name('confectionery.delete');
    //  stock-adj
    Route::resource('/probox/stock-adj', StockAdjController::class)->names('stock-adj');
    Route::delete('/stock-adj-detail/{id}', [StockAdjController::class, 'destroyDetail'])
    ->name('stock-adj.destroy-detail');
    // Route::get('/probox/stock-adj', [StockAdjController::class, 'report'])->name('stock-adj.report');
    Route::get('/probox/reports/stock_report', [StockAdjController::class, 'report'])->name('stock_report');



    

    Route::get('/probox/confectionery/editCon/{v_no}', [ConfectioneryController::class, 'editCon'])->name('confectionery.editCon');
    Route::put('/probox/confectionery/{v_no}/updateCon', [ConfectioneryController::class, 'updateCon'])->name('confectionery.updateCon');
    
    Route::get('/probox/wastage_sale', [WastageSaleController::class, 'index'])->name('wastage_sale.list');
    Route::get('/probox/wastage_sale/reports', [WastageSaleController::class, 'reports'])->name('wastage_sale.reports');
    Route::post('/probox/wastage_sale', [WastageSaleController::class, 'store'])->name('wastage_sale.store');
    Route::get('/probox/wastage_sale/{v_no}/delete', [WastageSaleController::class, 'destroy'])->name('wastage_sale.destroy');
    Route::delete('/probox/wastage_sale/{id}/delete', [WastageSaleController::class, 'delete'])->name('wastage_sale.delete');
    Route::get('/probox/wastage_sale/edit/{v_no}', [WastageSaleController::class, 'edit'])->name('wastage_sale.edit');
    Route::put('/probox/wastage_sale/update/{id}', [WastageSaleController::class, 'update'])->name('wastage_sale.update');
    
    
    
    Route::get('/probox/dye_purchase', [DyePurchaseController::class, 'index'])->name('dye_purchase.list');
    Route::get('/probox/dye_purchase/reports', [DyePurchaseController::class, 'reports'])->name('dye_purchases.reports');
    Route::post('/probox/dye_purchase', [DyePurchaseController::class, 'store'])->name('dye_purchase.store');
    Route::get('/probox/dye_purchase/{v_no}/delete', [DyePurchaseController::class, 'destroy'])->name('dye_purchase.destroy');
    Route::delete('/probox/dye_purchase/{id}/delete', [DyePurchaseController::class, 'delete'])->name('dye_purchase.delete');
    Route::get('/probox/dye_purchase/edit/{v_no}', [DyePurchaseController::class, 'edit'])->name('dye_purchase.edit');
    Route::put('/probox/dye_purchase/update/{id}', [DyePurchaseController::class, 'update'])->name('dye_purchase.update');
    
     Route::get('/probox/disposable_purchase', [DisposablePurchaseController::class, 'index'])->name('disposable_purchase.list');
    Route::get('/probox/disposable_purchase/reports', [DisposablePurchaseController::class, 'reports'])->name('disposable_purchase.reports');
    Route::post('/probox/disposable_purchase', [DisposablePurchaseController::class, 'store'])->name('disposable_purchase.store');
    Route::get('/probox/disposable_purchase/edit/{v_no}', [DisposablePurchaseController::class, 'edit'])->name('disposable_purchase.edit');
    Route::put('/probox/disposable_purchase/update/{id}', [DisposablePurchaseController::class, 'update'])->name('disposable_purchase.update');
    Route::get('/probox/disposable_purchase/{v_no}/delete', [DisposablePurchaseController::class, 'destroy'])->name('disposable_purchase.destroy');
    Route::delete('/probox/disposable_purchase/{id}/del', [DisposablePurchaseController::class, 'delete'])->name('disposable_purchase.delete');
    Route::get('/probox/disposable_purchase/{v_no}/edit-freight', [DisposablePurchaseController::class, 'editFreight'])->name('disposable_purchase.editFreight');
    Route::post('/probox/disposable_purchase/{v_no}/update-freight', [DisposablePurchaseController::class, 'updateFreight'])->name('disposable_purchase.updateFreight');
        Route::post('/probox/disposable-purchase/update-image/{id}', [DisposablePurchaseController::class, 'updateImage'])->name('disposable_purchase.updateImage');

    
    
    Route::get('/probox/dye_purchase/editDye/{v_no}', [DyePurchaseController::class, 'editDye'])->name('dye_purchase.editDye');
    Route::put('/probox/dye_purchase/{v_no}/updateDye', [DyePurchaseController::class, 'updateDye'])->name('dye_purchase.updateDye');
    
    
    Route::get('/probox/wastage/reports', [WastageController::class, 'reports'])->name('wastage.reports');

    Route::get('/probox/get-vnoss/{accountId}', [SaleInvoiceController::class, 'getVnoss']);
    Route::get('/probox/get-entry-detailss/{vno}', [SaleInvoiceController::class, 'getEntryDetailss']);

    Route::get('/probox/pharma_billing', [SaleInvoiceController::class, 'index'])->name('pharma_billing.list');
    Route::get('/probox/pharma_billing/reports', [SaleInvoiceController::class, 'reports'])->name('pharma_billing.reports');
    Route::post('/probox/pharma_billing', [SaleInvoiceController::class, 'store'])->name('pharma_billing.store');
    Route::delete('/probox/pharma-billing/{billing_no}/del', [SaleInvoiceController::class, 'destroy'])->name('pharma_billing.destroy');


    Route::get('/probox/get-vnos/{accountId}', [ConfectBillingController::class, 'getVnos']);
    Route::get('/probox/get-entry-details/{vno}', [ConfectBillingController::class, 'getEntryDetails']);

    Route::get('/probox/confect_billing', [ConfectBillingController::class, 'index'])->name('confect_billing.list');
    Route::get('/probox/confect_billing/reports', [ConfectBillingController::class, 'reports'])->name('confect_billing.reports');
    Route::post('/probox/confect_billing', [ConfectBillingController::class, 'store'])->name('confect_billing.store');
    Route::delete('/probox/confect-billing/{billing_no}/del', [ConfectBillingController::class, 'destroy'])
    ->name('confect_billing.destroy');



    Route::get('/probox/gate_pass_in', [GatePassInController::class, 'index'])->name('gate_pass_in.list');
    Route::get('/probox/gate_pass_in/reports', [GatePassInController::class, 'reports'])->name('gate_pass_in.reports');
    Route::post('/probox/gate_pass_in', [GatePassInController::class, 'store'])->name('gate_pass_in.store');
    Route::get('/probox/gate_pass_in/{v_no}/delete', [GatePassInController::class, 'destroy'])->name('gate_pass_in.destroy');
    Route::delete('/probox/gate_pass_in/{id}/delete', [GatePassInController::class, 'delete'])->name('gate_pass_in.delete');
    Route::get('/probox/gate_pass_in/edit/{v_no}', [GatePassInController::class, 'edit'])->name('gate_pass_in.edit');
    Route::put('/probox/gate_pass_in/update/{id}', [GatePassInController::class, 'update'])->name('gate_pass_in.update');

    Route::get('/probox/gate_pass_out', [GatePassOutController::class, 'index'])->name('gate_pass_out.list');
    Route::get('/probox/gate_pass_out/reports', [GatePassOutController::class, 'reports'])->name('gate_pass_out.reports');
    Route::post('/probox/gate_pass_out', [GatePassOutController::class, 'store'])->name('gate_pass_out.store');
    Route::get('/probox/gate_pass_out/{v_no}/delete', [GatePassOutController::class, 'destroy'])->name('gate_pass_out.destroy');
    Route::delete('/probox/gate_pass_out/{id}/delete', [GatePassOutController::class, 'delete'])->name('gate_pass_out.delete');
    Route::get('/probox/gate_pass_out/edit/{v_no}', [GatePassOutController::class, 'edit'])->name('gate_pass_out.edit');
    Route::put('/probox/gate_pass_out/update/{id}', [GatePassOutController::class, 'update'])->name('gate_pass_out.update');

    Route::get('/probox/cheque_receipts', [ChequeReceiptsController::class, 'index'])->name('cheque.index');
    Route::get('/probox/cheque_receipts/reports', [ChequeReceiptsController::class, 'reports'])->name('cheque_receipts.reports');
    Route::post('/probox/cheque_receipts', [ChequeReceiptsController::class, 'store'])->name('cheque_receipts.store');
    Route::delete('/probox/cheque-receipts/{id}', [ChequeReceiptsController::class, 'destroy'])->name('chequeReceipts.destroy');
    Route::get('/probox/cheque_receipts/edit/{v_no}', [ChequeReceiptsController::class, 'edit'])->name('cheque_receipts.edit');
    Route::put('/probox/cheque_receipts/update/{id}', [ChequeReceiptsController::class, 'update'])->name('cheque_receipts.update');
    Route::get('/probox/cheque_receipt/{v_no}/delete', [ChequeReceiptsController::class, 'del'])->name('cheque_receipts.del');

    Route::get('/probox/country', [CountryController::class, 'index'])->name('country.index');
    Route::post('/probox/country', [CountryController::class, 'store'])->name('country.store');
    Route::get('/probox/country/add_country', [CountryController::class, 'list'])->name('country.list');
    Route::delete('/probox/country/{id}', [CountryController::class, 'destroy'])->name('country.destroy');
    
    Route::get('/probox/custom', [CustomController::class, 'index'])->name('custom.index');
    Route::post('/probox/custom', [CustomController::class, 'store'])->name('custom.store');
    Route::get('/probox/custom/add_country', [CustomController::class, 'list'])->name('custom.list');
    Route::delete('/probox/custom/{id}', [CustomController::class, 'destroy'])->name('custom.destroy');

    Route::get('/probox/printing', [DepartmentSectionController::class, 'index'])->name('print.index');
    Route::post('/probox/printing', [DepartmentSectionController::class, 'store'])->name('print.store');
    Route::get('/probox/printing/edit/{id}', [DepartmentSectionController::class, 'edit'])->name('print.edit');
    Route::put('/probox/printing/{id}', [DepartmentSectionController::class, 'update'])->name('print.update');
    Route::get('/probox/printing/add_printing', [DepartmentSectionController::class, 'list'])->name('print.list');
    Route::delete('/probox/printing/{id}', [DepartmentSectionController::class, 'destroy'])->name('print.destroy');
    
    
    Route::get('/probox/designation', [DesignationController::class, 'index'])->name('designation.index');
    Route::post('/probox/designation', [DesignationController::class, 'store'])->name('designation.store');
    Route::get('/probox/designation/edit/{id}', [DesignationController::class, 'edit'])->name('designation.edit');
    Route::put('/probox/designation/{id}', [DesignationController::class, 'update'])->name('designation.update');
    Route::get('/probox/designation/add_printing', [DesignationController::class, 'list'])->name('designation.list');
    Route::delete('/probox/designation/{id}', [DesignationController::class, 'destroy'])->name('designation.destroy');
    
    
    Route::get('/probox/extra_time', [ExtraTimeController::class, 'index'])->name('extra_time.index');
    Route::post('/probox/extra_time', [ExtraTimeController::class, 'store'])->name('extra_time.store');
    Route::get('/probox/extra_time/edit/{id}', [ExtraTimeController::class, 'edit'])->name('extra_time.edit');
    Route::put('/probox/extra_time/{id}', [ExtraTimeController::class, 'update'])->name('extra_time.update');
    Route::get('/probox/extra_time/add_printing', [ExtraTimeController::class, 'list'])->name('extra_time.list');
    Route::delete('/probox/extra_time/{id}', [ExtraTimeController::class, 'destroy'])->name('extra_time.destroy');
    
    
    Route::get('/probox/process', [ProcessSectionController::class, 'index'])->name('process.index');
    Route::post('/probox/process', [ProcessSectionController::class, 'store'])->name('process.store');
    Route::get('/probox/process/add_process', [ProcessSectionController::class, 'list'])->name('process.list');
    Route::delete('/probox/process/{id}', [ProcessSectionController::class, 'destroy'])->name('process.destroy');
    
    Route::get('/probox/paste', [PasteSectionController::class, 'index'])->name('paste.index');
    Route::post('/probox/paste', [PasteSectionController::class, 'store'])->name('paste.store');
    Route::get('/probox/paste/add_paste', [PasteSectionController::class, 'list'])->name('paste.list');
    Route::delete('/probox/paste/{id}', [PasteSectionController::class, 'destroy'])->name('paste.destroy');
    
    
    Route::get('/probox/registration_form/add_product', [RegistrationFormController::class, 'index'])->name('registration_form.list');
    Route::post('/probox/registration_form/add_product', [RegistrationFormController::class, 'store'])->name('registration_form.store');
    Route::get('/probox/registration_form/reports', [RegistrationFormController::class, 'reports'])->name('registration_form.reports');
        Route::get('/probox/registration_form/{id}', [RegistrationFormController::class, 'show'])->name('registration_form.show');
        Route::get('/product/{id}/jpg', [ProductController::class, 'downloadJpg'])->name('product.download.jpg');

    Route::get('/probox/registration_form/edit/{id}', [RegistrationFormController::class, 'edit'])->name('registration_form.edit');
    Route::get('/probox/search-users', [RegistrationFormController::class, 'searchUsers'])->name('search.users');
    Route::put('/probox/registration_form/update/{id}', [RegistrationFormController::class, 'update'])->name('registration_form.update');
    Route::delete('/probox/registration_form/{id}', [RegistrationFormController::class, 'destroy'])->name('registration_form.destroy');
    Route::delete('/probox/registration_form/remove-image/{id}', [RegistrationFormController::class, 'removeImage'])->name('remove.image');

    Route::get('/probox/product-log', [ProductLogController::class, 'index'])->name('product_log.index');
    Route::get('/probox/product-log/report', [ProductLogController::class, 'report'])->name('product_log.report');

    Route::get('/probox/profile', [UserController::class, 'profile'])->name('profile');
    
    
    Route::get('/probox/payment_invoice', [PaymentInvoiceController::class, 'index'])->name('payment_invoice.list');
    Route::get('/probox/payment_invoice/reports', [PaymentInvoiceController::class, 'reports'])->name('payment_invoice.reports');
    Route::post('/probox/payment_invoice', [PaymentInvoiceController::class, 'store'])->name('payment_invoice.store');
    Route::get('/probox/purchase-details/edit/{v_no}', [PaymentInvoiceController::class, 'edit'])->name('purchase_details.edit');
    Route::get('/probox/purchase-details/editBoxboard/{v_no}', [PaymentInvoiceController::class, 'editBoxboard'])->name('purchase_details.editBoxboard');
    Route::put('/probox/purchase-details/{v_no}/updateBoxboard', [PaymentInvoiceController::class, 'updateBoxboard'])->name('purchase_details.updateBoxboard');
    Route::put('/probox/purchase-details/{v_no}/update', [PaymentInvoiceController::class, 'update'])->name('purchase_details.update');
    Route::delete('/probox/purchase-details/{id}/delete', [PaymentInvoiceController::class, 'destroy'])->name('purchase_details.delete');
    Route::get('/probox/purchase-details/{id}/del', [PaymentInvoiceController::class, 'delete'])->name('purchase_details.destroy');

    Route::get('/probox/purchase_return', [PurchaseReturnController::class, 'index'])->name('purchase_return.list');
    Route::post('/probox/purchase_return', [PurchaseReturnController::class, 'store'])->name('purchase_return.store');
    Route::get('/probox/purchase_return/reports', [PurchaseReturnController::class, 'reports'])->name('purchase_return.reports');
    Route::get('/probox/purchase_return/{id}/delete', [PurchaseReturnController::class, 'destroy'])->name('purchase_return.destroy');
    Route::delete('/probox/purchase_return/{id}/del', [PurchaseReturnController::class, 'delete'])->name('purchase_return.delete');
    Route::get('/probox/purchase_return/edit/{v_no}', [PurchaseReturnController::class, 'edit'])->name('purchase_return.edit');
    Route::put('/probox/purchase_return/update/{id}', [PurchaseReturnController::class, 'update'])->name('purchase_return.update');

    Route::get('/probox/plate_purchase', [PlatePurchaseController::class, 'index'])->name('plate_purchase.list');
    Route::get('/probox/plate_purchase/reports', [PlatePurchaseController::class, 'reports'])->name('plate_purchase.reports');
    Route::get('/probox/get-products-by-country', [PlatePurchaseController::class, 'getProductsByCountry']);
    Route::post('/probox/plate_purchase', [PlatePurchaseController::class, 'store'])->name('plate_purchase.store');
    Route::get('/probox/plate_purchase/edit/{v_no}', [PlatePurchaseController::class, 'edit'])->name('plate_purchase.edit');
    Route::put('/probox/plate_purchase/update/{id}', [PlatePurchaseController::class, 'update'])->name('plate_purchase.update');
    Route::get('/probox/plate_purchase/{v_no}/delete', [PlatePurchaseController::class, 'destroy'])->name('plate_purchase.destroy');
    Route::delete('/probox/plate_purchase/{id}/del', [PlatePurchaseController::class, 'delete'])->name('plate_purchase.delete');
    
    
    
    Route::get('/probox/plate_return', [PlateReturnController::class, 'index'])->name('plate_return.list');
    Route::get('/probox/plate_return/reports', [PlateReturnController::class, 'reports'])->name('plate_return.reports');
    Route::post('/probox/plate_return', [PlateReturnController::class, 'store'])->name('plate_return.store');
    Route::delete('/probox/plate_return/{id}', [PlateReturnController::class, 'destroy'])->name('plate_return.destroy');

    Route::get('/probox/glue_purchase', [GluePurchaseController::class, 'index'])->name('glue_purchase.list');
    Route::get('/probox/glue_purchase/reports', [GluePurchaseController::class, 'reports'])->name('glue_purchase.reports');
    Route::post('/probox/glue_purchase', [GluePurchaseController::class, 'store'])->name('glue_purchase.store');
    Route::get('/probox/glue_purchase/edit/{v_no}', [GluePurchaseController::class, 'edit'])->name('glue_purchase.edit');
    Route::put('/probox/glue_purchase/update/{id}', [GluePurchaseController::class, 'update'])->name('glue_purchase.update');
    Route::get('/probox/glue_purchase/{v_no}/delete', [GluePurchaseController::class, 'destroy'])->name('glue_purchase.destroy');
    Route::delete('/probox/glue_purchase/{id}/del', [GluePurchaseController::class, 'delete'])->name('glue_purchase.delete');
     Route::get('/probox/glue_purchase/editBoxboard/{v_no}', [GluePurchaseController::class, 'editBoxboard'])->name('glue_purchase.editBoxboard');
    Route::put('/probox/glue_purchase/{v_no}/updateBoxboard', [GluePurchaseController::class, 'updateBoxboard'])->name('glue_purchase.updateBoxboard');

    
    Route::get('/probox/glue_return', [GlueReturnController::class, 'index'])->name('glue_return.list');
    Route::get('/probox/glue_return/reports', [GlueReturnController::class, 'reports'])->name('glue_return.reports');
    Route::post('/probox/glue_return', [GlueReturnController::class, 'store'])->name('glue_return.store');
    Route::delete('/probox/glue_return/{id}', [GlueReturnController::class, 'destroy'])->name('glue_return.destroy');
    
    
    
    
    Route::get('/probox/ink_purchase', [InkPurchaseController::class, 'index'])->name('ink_purchase.list');
    Route::get('/probox/ink_purchase/reports', [InkPurchaseController::class, 'reports'])->name('ink_purchase.reports');
    Route::post('/probox/ink_purchase', [InkPurchaseController::class, 'store'])->name('ink_purchase.store');
    Route::get('/probox/ink_purchase/edit/{v_no}', [InkPurchaseController::class, 'edit'])->name('ink_purchase.edit');
    Route::put('/probox/ink_purchase/update/{id}', [InkPurchaseController::class, 'update'])->name('ink_purchase.update');
    Route::get('/probox/ink_purchase/{v_no}/delete', [InkPurchaseController::class, 'destroy'])->name('ink_purchase.destroy');
    Route::delete('/probox/ink_purchase/{id}/del', [InkPurchaseController::class, 'delete'])->name('ink_purchase.delete');
     Route::get('/probox/ink_purchase/editBoxboard/{v_no}', [InkPurchaseController::class, 'editBoxboard'])->name('ink_purchase.editBoxboard');
    Route::put('/probox/ink_purchase/{v_no}/updateBoxboard', [InkPurchaseController::class, 'updateBoxboard'])->name('ink_purchase.updateBoxboard');


    
    Route::get('/probox/ink_return', [InkReturnController::class, 'index'])->name('ink_return.list');
    Route::get('/probox/ink_return/reports', [InkReturnController::class, 'reports'])->name('ink_return.reports');
    Route::post('/probox/ink_return', [InkReturnController::class, 'store'])->name('ink_return.store');
    Route::delete('/probox/ink_return/{id}', [InkReturnController::class, 'destroy'])->name('ink_return.destroy');
    
    
    
    Route::get('/probox/shippers_purchase', [ShipperPurchasesController::class, 'index'])->name('shipper_purchases.list');
    Route::get('/probox/shippers_purchase/reports', [ShipperPurchasesController::class, 'reports'])->name('shipper_purchases.reports');
    Route::post('/probox/shippers_purchase', [ShipperPurchasesController::class, 'store'])->name('shipper_purchases.store');
    Route::get('/probox/shippers_purchase/edit/{v_no}', [ShipperPurchasesController::class, 'edit'])->name('shipper_purchases.edit');
    Route::put('/probox/shippers_purchase/update/{id}', [ShipperPurchasesController::class, 'update'])->name('shipper_purchases.update');
    Route::get('/probox/shippers_purchase/{v_no}/delete', [ShipperPurchasesController::class, 'destroy'])->name('shipper_purchases.destroy');
    Route::delete('/probox/shippers_purchase/{id}/del', [ShipperPurchasesController::class, 'delete'])->name('shipper_purchases.delete');
    Route::get('/probox/shippers_purchase/editBoxboard/{v_no}', [ShipperPurchasesController::class, 'editBoxboard'])->name('shipper_purchases.editBoxboard');
    Route::put('/probox/shippers_purchase/{v_no}/updateBoxboard', [ShipperPurchasesController::class, 'updateBoxboard'])->name('shipper_purchases.updateBoxboard');


    Route::get('/probox/shipper_return', [ShipperReturnController::class, 'index'])->name('shipper_return.list');
    Route::get('/probox/shipper_return/reports', [ShipperReturnController::class, 'reports'])->name('shipper_return.reports');
    Route::post('/probox/shipper_return', [ShipperReturnController::class, 'store'])->name('shipper_return.store');
    Route::delete('/probox/shipper_return/{id}', [ShipperReturnController::class, 'destroy'])->name('shipper_return.destroy');
    
    
    Route::get('/probox/dye_return', [DyeReturnController::class, 'index'])->name('dye_return.list');
    Route::get('/probox/dye_return/reports', [DyeReturnController::class, 'reports'])->name('dye_return.reports');
    Route::post('/probox/dye_return', [DyeReturnController::class, 'store'])->name('dye_return.store');
    Route::delete('/probox/dye_return/{id}', [DyeReturnController::class, 'destroy'])->name('dye_return.destroy');



    Route::get('/probox/lemination_purchase', [LeminationPurchaseController::class, 'index'])->name('lemination_purchase.list');
    Route::get('/probox/lemination_purchase/reports', [LeminationPurchaseController::class, 'reports'])->name('lemination_purchase.reports');
    Route::post('/probox/lemination_purchase', [LeminationPurchaseController::class, 'store'])->name('lemination_purchase.store');
    Route::get('/probox/lemination_purchase/edit/{v_no}', [LeminationPurchaseController::class, 'edit'])->name('lemination_purchase.edit');
    Route::put('/probox/lemination_purchase/update/{id}', [LeminationPurchaseController::class, 'update'])->name('lemination_purchase.update');
    Route::get('/probox/lemination_purchase/{v_no}/delete', [LeminationPurchaseController::class, 'destroy'])->name('lemination_purchase.destroy');
    Route::delete('/probox/lemination_purchase/{id}/del', [LeminationPurchaseController::class, 'delete'])->name('lemination_purchase.delete');
    Route::get('/probox/lemination_purchase/editBoxboard/{v_no}', [LeminationPurchaseController::class, 'editBoxboard'])->name('lemination_purchase.editBoxboard');
    Route::put('/probox/lemination_purchase/{v_no}/updateBoxboard', [LeminationPurchaseController::class, 'updateBoxboard'])->name('lemination_purchase.updateBoxboard');
    




    
    
    Route::get('/probox/lamination_return', [LaminationReturnController::class, 'index'])->name('lamination_return.list');
    Route::get('/probox/lamination_return/reports', [LaminationReturnController::class, 'reports'])->name('lamination_return.reports');
    Route::post('/probox/lamination_return', [LaminationReturnController::class, 'store'])->name('lamination_return.store');
    Route::delete('/probox/lamination_return/{id}', [LaminationReturnController::class, 'destroy'])->name('lamination_return.destroy');
    
    



     Route::get('/probox/corrugation_return', [CorrugationReturnController::class, 'index'])->name('corrugation_return.list');
    Route::get('/probox/corrugation_return/reports', [CorrugationReturnController::class, 'reports'])->name('corrugation_return.reports');
    Route::post('/probox/corrugation_return', [CorrugationReturnController::class, 'store'])->name('corrugation_return.store');
    Route::delete('/probox/corrugation_return/{id}', [CorrugationReturnController::class, 'destroy'])->name('corrugation_return.destroy');
    
    
    

    Route::get('/probox/corrugation_purchase', [CorrugationPurchaseController::class, 'index'])->name('corrugation_purchase.list');
    Route::get('/probox/corrugation_purchase/reports', [CorrugationPurchaseController::class, 'reports'])->name('corrugation_purchase.reports');
    Route::post('/probox/corrugation_purchase', [CorrugationPurchaseController::class, 'store'])->name('corrugation_purchase.store');
    Route::get('/probox/corrugation_purchase/edit/{v_no}', [CorrugationPurchaseController::class, 'edit'])->name('corrugation_purchase.edit');
    Route::put('/probox/corrugation_purchase/update/{id}', [CorrugationPurchaseController::class, 'update'])->name('corrugation_purchase.update');
    Route::get('/probox/corrugation_purchase/{v_no}/delete', [CorrugationPurchaseController::class, 'destroy'])->name('corrugation_purchase.destroy');
    Route::delete('/probox/corrugation_purchase/{id}/del', [CorrugationPurchaseController::class, 'delete'])->name('corrugation_purchase.delete');
    Route::get('/probox/corrugation_purchase/editBoxboard/{v_no}', [CorrugationPurchaseController::class, 'editBoxboard'])->name('corrugation_purchase.editBoxboard');
    Route::put('/probox/corrugation_purchase/{v_no}/updateBoxboard', [CorrugationPurchaseController::class, 'updateBoxboard'])->name('corrugation_purchase.updateBoxboard');
    
});


Route::post('probox/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('probox/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('probox/login', [LoginController::class, 'login']);
Route::get('probox/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('probox/register', [RegisterController::class, 'register']);

// Auth::routes(['login' => false, 'register' => false, 'logout' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
