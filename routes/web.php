<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', [LandingController::class, 'index'])->name('index');
Route::get('about', [LandingController::class, 'about'])->name('about');
Route::get('transportation', [LandingController::class, 'contact'])->name('contact');
Route::get('annoucement', [LandingController::class, 'service'])->name('service');
Route::get('logout', [LandingController::class, 'logout'])->name('logout');


Auth::routes();

//Normal Users Routes List
Route::middleware(['auth', 'user-access:user'])->group(function () {
   
    Route::get('/user/home', [HomeController::class, 'index'])->name('user.home');
    Route::get('/user/booking', [HomeController::class, 'user_booking'])->name('user.booking');
    Route::get('/user/dashboard', [HomeController::class, 'user_dashboard'])->name('user.dashboard');
    Route::get('/user/transportation', [HomeController::class, 'user_transportation'])->name('user.transportation');
    Route::get('/user/billing-reports/payment', [HomeController::class, 'billing_payment'])->name('user.reports.payment');
    Route::get('/user/check-fully-booked', [HomeController::class, 'checkFullyBooked'])->name('user.check-fully-booked');

    Route::get('/user/reset-password', [HomeController::class, 'reset_password'])->name('user.reset.password');
    Route::post('/user/change-password', [HomeController::class, 'change_password'])->name('user.change.password');
   
    Route::post('/client/add/booking', [HomeController::class, 'client_booking'])->name('user.add.booking');
    Route::get('/user/user-profile', [HomeController::class, 'user_profile'])->name('user.profile');
    Route::post('/user/user-profile/update', [HomeController::class, 'user_profile_update'])->name('user.update.profile');
    Route::get('/get/transportation-details/for-client', [HomeController::class, 'getTransportationDetailsForClient'])->name('get.transportation.details.for.client');
    Route::get('/user/billing-details/for-client/{id}', [HomeController::class, 'view_billings'])->name('view.billings.for.client');
    Route::get('/get/billings/for-client', [HomeController::class, 'getBillingsForClient'])->name('user.billings.payment');
    Route::get('/get-user-details/{id}', [HomeController::class, 'getTransportationDetails'])->name('get-transportation-details');
    Route::get('/client/view-billing/payment/{id}', [HomeController::class, 'view_payment'])->name('view.billing.for.client');

    Route::get('user/get/todaysBooking', [HomeController::class, 'getTodayBookings'])->name('user.todaysBooking.date');
});

// Admin Routes List
Route::middleware(['auth', 'user-access:admin'])->group(function () {
   
    Route::get('/admin/dashboard', [AdminController::class, 'admin_dashboard'])->name('admin.home');
    
    Route::get('/employee/birthday', [AdminController::class, 'employee_birthday'])->name('employee.birthday');
    Route::get('/admin/client/account', [AdminController::class, 'clientAccount'])->name('client.account');
    Route::post('register.action', [AdminController::class, 'register']);
    Route::post('employee.accounts', [AdminController::class, 'employee_account']);
    Route::post('helper/accounts', [AdminController::class, 'helper_account'])->name('helper.account');
    Route::post('add/truck', [AdminController::class, 'add_truck']);
    Route::get('admin/employee/details/{id}', [AdminController::class, 'employeeDetails']);
    Route::get('decline/booking/{id}', [AdminController::class, 'decline_booking'])->name('decline.booking');
    Route::get('admin/helper/details/{id}', [AdminController::class, 'employeeDetails'])->name('admin.helper.details');
    Route::get('/admin/employee/account', [AdminController::class, 'employeeAccount'])->name('employee.account');
    Route::get('/admin/disabled/driver/{id}', [AdminController::class, 'disable_driver'])->name('disabled.driver');
    Route::get('/admin/enable/driver/{id}', [AdminController::class, 'enable_driver'])->name('enable.driver');
    Route::get('/admin/transportation', [AdminController::class, 'transportation'])->name('admin.transportation');
    Route::get('/admin/booking-calendar', [AdminController::class, 'booking'])->name('booking.calendar');
    Route::get('/admin/calendar', [AdminController::class, 'calendar'])->name('admin.calendar');
    Route::get('/getAssignedDriversAndHelpers', [AdminController::class, 'getAssignedDriversAndHelpers'])->name('getAssignedDriversAndHelpers');

    Route::get('/admin/check-fully-booked', [AdminController::class, 'checkFullyBooked'])->name('admin.check-fully-booked');
    Route::post('transportation/details/{id}', [AdminController::class, 'transportation_details'])->name('transportation.details');

    Route::post('transpo/{id}/status', [AdminController::class, 'update_transportation_status'])->name('transpo.status.update');

    Route::post('/admin/password/update', [AdminController::class, 'updateProfileForAdmin'])->name('admin.password.update');


    Route::put('/truck.update/{id}', [AdminController::class, 'truck_update']);
    Route::post('update/status/{id}', [AdminController::class, 'update_status'])->name('update.status');
    Route::post('admin/booking/client', [AdminController::class, 'admin_booking'])->name('admin.booking.for.client');
    Route::post('admin/booking/from/client', [AdminController::class, 'admin_booking_from_client'])->name('admin.booking.from.client');
    Route::get('/get-assigned-companies', [AdminController::class, 'assignedCompanies'])->name('getAssignedCompanies');
    Route::get('/get-assigned-truck', [AdminController::class, 'assignedTruck'])->name('getAssignedTruck');
    Route::get('/get-assigned-truck/url', [AdminController::class, 'assignedTruckURL'])->name('getAssignedTruckURL');
    Route::get('/get-assigned-driver', [AdminController::class, 'assignedDriver'])->name('getAssignedDriver');
    Route::get('/get-assigned-driver-for-client', [AdminController::class, 'assignedDriverForClient'])->name('getAssignedDriverForClient');
    Route::get('/get-assigned-helper', [AdminController::class, 'assignedHelper'])->name('getAssignedHelper');
    
    // Route::get('/getAssignedEmployees', [AdminController::class, 'getAssignedEmployees'])->name('getAssignedEmployees');
    Route::patch('admin/booking/update/{id}', [AdminController::class, 'calendar_update'])->name('calendar.update');
    // Route::patch('admin/booking/update/date/{id}', [AdminController::class, 'calendar_update_date'])->name('calendar.update.date');
    Route::get('/admin/billing', [AdminController::class, 'admin_billing'])->name('admin.billing');
    Route::get('/admin/booking/pending', [AdminController::class, 'booking_pending'])->name('booking.pending');
    Route::get('/admin/payroll', [AdminController::class, 'admin_payroll'])->name('admin.payroll');
    Route::get('/admin/payroll/information', [AdminController::class, 'payroll_info'])->name('payroll.info');
    Route::get('/admin/view/payroll/{id}/reports', [AdminController::class, 'view_payrollDetails'])->name('view.payroll.details');
    Route::get('/admin/view/payroll/{id}/details/reports', [AdminController::class, 'view_payrollDetails_reports'])->name('view.payroll.details.report');
    Route::get('/admin/payroll/{id}/paid', [AdminController::class, 'payroll_paid'])->name('payroll.paid');
    Route::get('/view/billing/{id}', [AdminController::class, 'view_billing'])->name('view.billing');
    Route::get('/view/payroll/employee/{id}', [AdminController::class, 'view_payroll'])->name('view.payroll');

    Route::post('admin/payroll-update-status/{id}', [AdminController::class, 'updateStatusforpayroll'])->name('update.status.payroll');

    Route::get('/view/payroll/helper/{id}', [AdminController::class, 'view_payroll_helper'])->name('view.payroll.helper');
    // Route::post('/billing/details/{id}', [AdminController::class, 'billing_details'])->name('billing.details');
    Route::put('/update/billing/details/{id}', [AdminController::class, 'update_billing'])->name('update.billing');
    Route::put('/update/user/{id}', [AdminController::class, 'update_user'])->name('update.user');
    Route::get('client/filter', [AdminController::class, 'client_filter'])->name('client.filter');
    Route::get('search/invoice-number', [AdminController::class, 'search_invoice'])->name('search.invoice.number');
    Route::get('/payment/reports/client/filter', [AdminController::class, 'client_filter_payment'])->name('payment.filterClient');
    Route::post('cash/advance/{id}', [AdminController::class, 'cash_advance'])->name('cash.advance');
    Route::post('/add-damage/{id}', [AdminController::class, 'addDamage'])->name('add.damage');
    Route::post('/save-billing', [AdminController::class, 'save_billing'])->name('save.billing');
    Route::post('/save-payroll', [AdminController::class, 'save_payroll'])->name('save.payroll');
    Route::get('admin/billing/information', [AdminController::class, 'billing_info'])->name('billing.information');
    Route::get('admin/billing/details/{id}', [AdminController::class, 'billing_details'])->name('view.billing.details');
    Route::get('admin/billing/details/report/{id}', [AdminController::class, 'billing_details_report'])->name('view.billing.details.report');
    Route::get('admin/billing/paid/{id}', [AdminController::class, 'billing_paid'])->name('billing.paid');
    Route::get('/bookings/today', [AdminController::class, 'getTodayBookings'])->name('admin.todaysBooking.date');

    // Reports
    Route::get('admin/billing/reports', [AdminController::class, 'billing_reports'])->name('admin.billingReports');
    Route::get('admin/payment/reports', [AdminController::class, 'payment_reports'])->name('admin.paymentReports');
    Route::get('admin/transportation/reports', [AdminController::class, 'transportation_reports'])->name('admin.transportationReports');
    Route::get('admin/payroll/reports', [AdminController::class, 'payroll_reports'])->name('admin.payrollReports');
    Route::get('admin/transportation/getTransportations', [AdminController::class, 'getTransportations']);
    Route::get('/filter-data', [AdminController::class, 'filterData'])->name('filter.data');

    Route::get('tranportation/filter', [AdminController::class, 'salary_filter'])->name('filterTransportationDate');
    Route::post('admin/save-truck', [AdminController::class, 'add_truck'])->name('save.truck');
    Route::post('admin/update-truck/{id}', [AdminController::class, 'update_truck'])->name('update.truck');
    Route::get('admin/list-of-trucks', [AdminController::class, 'truck_list'])->name('list.of.trucks');

    Route::get('admin/get/booking', [AdminController::class, 'get_booking'])->name('get.bookings.client');

    Route::post('/update-transportation/for-admin/{id}', [AdminController::class, 'updateStatus'])->name('update_transportation.for.admin');
    Route::post('admin/billing/payment', [AdminController::class, 'billing_payment'])->name('billing.payment');
    Route::delete('/admin/delete-billing/{id}', [AdminController::class, 'delete_billing'])->name('delete.billing');

    // Route::get('/api/driver-assignment-counts', [AdminController::class, 'getDriverAssignmentCounts']);


    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/admin/profile', [ProfileController::class, 'admin_profile'])->name('admin.profile');
    Route::put('/admin/profile/update', [ProfileController::class, 'admin_profile_update'])->name('admin.profile.update');
    Route::post('/profile/photo/update', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::post('/profile/update/{id}', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile/update/photo/{id}', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');


});

//Employee Routes List
Route::middleware(['auth', 'user-access:employee'])->group(function () {
   
    Route::get('/driver/employee/dashboard', [EmployeeController::class, 'employee_index'])->name('user.employee');
    Route::get('/driver/employee/profile', [EmployeeController::class, 'employee_profile'])->name('driver.profile');
    Route::post('/driver/employee/profile-update', [EmployeeController::class, 'employee_profile_update'])->name('driver.profile.update');
    Route::get('/driver/transporation', [EmployeeController::class, 'employee_transportation'])->name('driver.transportation');
    Route::post('/update-transportation/{id}', [EmployeeController::class, 'update_transportation'])->name('update_transportation');
    Route::get('/reset-password', [EmployeeController::class, 'reset_password'])->name('reset.password');
    Route::post('/change-password', [EmployeeController::class, 'changePassword'])->name('change.password.submit');
    Route::get('/driver/payroll', [EmployeeController::class, 'payroll'])->name('employee.payroll');
    Route::get('/driver/payroll/reports', [EmployeeController::class, 'payroll_reports'])->name('employee.payroll.reports');
    Route::get('view/driver/payroll-details/{id}', [EmployeeController::class, 'view_payroll'])->name('view.payroll.details.for.driver');  
    Route::get('view/driver/payroll-details/reports/{id}', [EmployeeController::class, 'view_payroll_reports'])->name('view.payroll.details.for.driver.reports');              
    Route::get('employee/driver/payroll-filter/reports/', [EmployeeController::class, 'filter_payroll_reports'])->name('employee.payroll.filter');              
    
});




