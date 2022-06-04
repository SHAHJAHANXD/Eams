<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\MessageChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ZoomMeetingController;
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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/agora-chat', 'App\Http\Controllers\AgoraVideoController@index');
    Route::post('/agora/token', 'App\Http\Controllers\AgoraVideoController@token');
    Route::post('/agora/call-user', 'App\Http\Controllers\AgoraVideoController@callUser');
});



Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware(['auth','can:admin-access'])->group(function () {
    Route::get('/', 'AdminController@index')->name('index');
    Route::get('/reset-password', 'AdminController@reset_password')->name('reset-password');
    Route::put('/update-password', 'AdminController@update_password')->name('update-password');
    Route::get('/logout', 'AdminController@logout')->name('logout');
    Route::get('/profile', 'AdminController@adminProfile')->name('admin.profile');
    Route::get('/profile-edit/{employee_id}', 'AdminController@adminProfile_edit')->name('admin.profile-edit');
    Route::put('/profile/{employee_id}', 'AdminController@adminProfile_update')->name('admin.profile-update');
    Route::get('/employees/key-storking/{id}', 'AdminController@key_storking')->name('key_storking');
    Route::get('/zoom-meeting', [ZoomMeetingController::class, 'meeting']);
    Route::get('/generate-new/zoom-meeting', [ZoomMeetingController::class, 'meeting']);
    // Routes for employees //
    Route::get('/employees/list-employees', 'EmployeeController@index')->name('employees.index');
    Route::get('/employees/add-employee', 'EmployeeController@create')->name('employees.create');
    Route::post('/employees', 'EmployeeController@store')->name('employees.store');
    Route::get('/employees/attendance', 'EmployeeController@attendance')->name('employees.attendance');
    Route::post('/employees/attendance', 'EmployeeController@attendance')->name('employees.attendance');
    Route::delete('/employees/attendance/{attendance_id}', 'EmployeeController@attendanceDelete')->name('employees.attendance.delete');
    Route::get('/employees/profile/{employee_id}', 'EmployeeController@employeeProfile')->name('employees.profile');
    Route::get('/employees/productivity/{employee_id}', 'EmployeeController@employeeProductivity')->name('employees.productivity');
    Route::get('/get/pdf/{employee_id}','EmployeeController@pdfcreate')->name('employees.gen.pdf');
    Route::delete('/employees/{employee_id}', 'EmployeeController@destroy')->name('employees.delete');

    //Routes for Tasks
    Route::get('/tasks/list', 'TaskController@index')->name('task.index');
    Route::get('/task/add', 'TaskController@create')->name('task.create');
    Route::post('/task', 'TaskController@store')->name('task.store');
    Route::get('/task/view/{task_id}', 'TaskController@viewTask')->name('task.view');
    Route::delete('/task/{task_id}', 'TaskController@destroy')->name('task.delete');
    // Routes for employees monitoring//
    Route::get('/employees/monitoring', 'EmployeeController@monitoring')->name('monitoring.index');

    Route::get('/employees/monitoring/{employee_id}', 'EmployeeController@employeeMonitoring')->name('monitoring.listing');
    Route::get('/chat-with/{id}', [EmployeeController::class, 'chats']);

    Route::post('/save-chat', [MessageChatController::class, 'store'])->name('chat.store');
    Route::get('/zoom-meeting', [ZoomMeetingController::class, 'meeting']);
    // Routes for leaves //
    Route::get('/leaves/list-leaves', 'LeaveController@index')->name('leaves.index');
    Route::put('/leaves/{leave_id}', 'LeaveController@update')->name('leaves.update');
    // Routes for leaves //

    // Routes for expenses //
    Route::get('/expenses/list-expenses', 'ExpenseController@index')->name('expenses.index');
    Route::put('/expenses/{expense_id}', 'ExpenseController@update')->name('expenses.update');
    // Routes for expenses //

    // Routes for holidays //
    Route::get('/holidays/list-holidays', 'HolidayController@index')->name('holidays.index');
    Route::get('/holidays/add-holiday', 'HolidayController@create')->name('holidays.create');
    Route::post('/holidays', 'HolidayController@store')->name('holidays.store');
    Route::get('/holidays/edit-holiday/{holiday_id}', 'HolidayController@edit')->name('holidays.edit');
    Route::put('/holidays/{holiday_id}', 'HolidayController@update')->name('holidays.update');
    Route::delete('/holidays/{holiday_id}', 'HolidayController@destroy')->name('holidays.delete');
    // Routes for holidays //
});

Route::namespace('Employee')->prefix('employee')->name('employee.')->middleware( ['web', 'activity'] ,['auth','can:employee-access'])->group(function () {

    Route::get('/', 'EmployeeController@index')->name('index');
    Route::get('/profile', 'EmployeeController@profile')->name('profile');
    Route::get('/profile-edit/{employee_id}', 'EmployeeController@profile_edit')->name('profile-edit');
    Route::put('/profile/{employee_id}', 'EmployeeController@profile_update')->name('profile-update');
    Route::post('/profile/update-picture', 'EmployeeController@update_picture')->name('profile-update');

    Route::get('/user-status-active/{id}', [EmployeeController::class, 'status1']);
    Route::get('/user-status-block/{id}', [EmployeeController::class, 'status0']);
    Route::get('/chat-with/{id}', [EmployeeController::class, 'chat']);
    Route::post('/save-chat', [MessageChatController::class, 'store'])->name('chat.store');
    Route::get('/zoom-meeting', [ZoomMeetingController::class, 'meeting']);
    Route::get('/generate-new/zoom-meeting', [ZoomMeetingController::class, 'meeting']);
    // Routes for Attendances //
    Route::get('/productivity/{employee_id}', 'EmployeeController@employeeProductivity');
    Route::get('/get/pdf/{employee_id}',[EmployeeController::class, 'pdfcreate'])->name('gen.pdf');
    Route::get('/attendance/list-attendances', 'AttendanceController@index')->name('attendance.index');
    Route::post('/attendance/list-attendances', 'AttendanceController@index')->name('attendance.index');
    Route::post('/attendance/get-location', 'AttendanceController@location')->name('attendance.get-location');
    Route::get('/attendance/register', 'AttendanceController@create')->name('attendance.create');
    Route::post('/attendance/{employee_id}', 'AttendanceController@store')->name('attendance.store');
    Route::put('/attendance/{attendance_id}', 'AttendanceController@update')->name('attendance.update');
    // Routes for Attendances //


    //Employee Tasks
    Route::get('/tasks/list', 'TaskController@index')->name('task.index');
    Route::get('/task/view/{task_id}', 'TaskController@viewTask')->name('task.view');
    /*
    *
    */
    // Routes for Leaves //
    Route::get('/leaves/apply', 'LeaveController@create')->name('leaves.create');
    Route::get('/leaves/list-leaves', 'LeaveController@index')->name('leaves.index');
    Route::post('/leaves/{employee_id}', 'LeaveController@store')->name('leaves.store');
    Route::get('/leaves/edit-leave/{leave_id}', 'LeaveController@edit')->name('leaves.edit');
    Route::put('/leaves/{leave_id}', 'LeaveController@update')->name('leaves.update');
    Route::delete('/leaves/{leave_id}', 'LeaveController@destroy')->name('leaves.delete');
    // Routes for Leaves //

    // Routes for Expenses//
    Route::get('/expenses/list-expenses', 'ExpenseController@index')->name('expenses.index');
    Route::get('/expenses/claim-expense', 'ExpenseController@create')->name('expenses.create');
    Route::post('/expenses/{employee_id}', 'ExpenseController@store')->name('expenses.store');
    Route::get('/expenses/edit-expense/{expense_id}', 'ExpenseController@edit')->name('expenses.edit');
    Route::put('/expenses/{expense_id}', 'ExpenseController@update')->name('expenses.update');
    Route::delete('/expenses/{expense_id}', 'ExpenseController@destroy')->name('expenses.delete');
    // Routes for Expenses//

    // Routes for Self //
    Route::get('/self/holidays', 'SelfController@holidays')->name('self.holidays');
    Route::get('/self/salary_slip', 'SelfController@salary_slip')->name('self.salary_slip');
    Route::get('/self/salary_slip_print', 'SelfController@salary_slip_print')->name('self.salary_slip_print');
    // Routes for Self //
});

Route::get('/logout', [AdminController::class, 'logout'])->name('logout');



Route::group(['prefix' => 'activity', 'namespace' => 'jeremykenedy\LaravelLogger\App\Http\Controllers', 'middleware' => ['web', 'auth', 'activity']], function () {

    // Dashboards
    Route::get('/', 'LaravelLoggerController@showAccessLog')->name('activity');
    Route::get('/cleared', ['uses' => 'LaravelLoggerController@showClearedActivityLog'])->name('cleared');

    // Drill Downs
    Route::get('/log/{id}', 'LaravelLoggerController@showAccessLogEntry');
    Route::get('/cleared/log/{id}', 'LaravelLoggerController@showClearedAccessLogEntry');

    // Forms
    Route::delete('/clear-activity', ['uses' => 'LaravelLoggerController@clearActivityLog'])->name('clear-activity');
    Route::delete('/destroy-activity', ['uses' => 'LaravelLoggerController@destroyActivityLog'])->name('destroy-activity');
    Route::post('/restore-log', ['uses' => 'LaravelLoggerController@restoreClearedActivityLog'])->name('restore-activity');
});
