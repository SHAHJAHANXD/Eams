<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// save screen shot API
Route::post('/store/screen', 'Employee\EmployeeController@saveImage')->name('employees.store.screen');

Route::post('/change-assignee', 'Employee\TaskController@changeAssignee')->name('employees.change.assignee');

Route::post('/change-status', 'Employee\TaskController@changeStatus')->name('employees.change.status');
Route::get('/notifications/{id}', 'Auth\RegisterController@notifications')->name('notifications');
Route::get('/notifications/read/{id}', 'Auth\RegisterController@notificationsRead')->name('notifications.read');



