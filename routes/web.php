<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManagerController;
// make sure you import the classes above

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
    return view('login-page');
});

Route::get('/registration/form',[AuthController::class,'loadRegisterForm']);
Route::post('/register/user',[AuthController::class,'registerUser'])->name('registerUser');

Route::get('/login/form',[AuthController::class,'loadLoginPage']);

Route::post('/login/user',[AuthController::class,'LoginUser'])->name('LoginUser');



Route::get('/logout',[AuthController::class,'LogoutUser']);

Route::get('/forgot/password',[AuthController::class,'forgotPassword']);

Route::post('/forgot',[AuthController::class,'forgot'])->name('forgot');

Route::get('/reset/password',[AuthController::class,'loadResetPassword']);

Route::post('/reset/user/password',[AuthController::class,'ResetPassword'])->name('ResetPassword');

// admin routes here
Route::group(['middleware' => ['web','checkAdmin']],function(){
    Route::get('/admin/home',[AuthController::class,'loadHomePage']);

    // routes to manage managers
    Route::get('/get/all/managers',[AdminController::class,'loadAllManagers']);
    Route::get('/register/manager',[AdminController::class,'RegisterManager'])->name('RegisterManager');
    Route::get('/edit/manager',[AdminController::class,'editManager'])->name('editManager');
    Route::get('delete/manager/{id}',[AdminController::class,'deleteManager'])->name('deleteManager'); //this is our delete route
});

// manager routes here
Route::group(['middleware' => ['web','checkManager']],function(){
    Route::get('/manager/home',[ManagerController::class,'loadManagerHome']);
    // manage employees 
    Route::get('/manage/employees',[ManagerController::class,'getAllEmployees']);
    Route::get('/get/states/{id}',[ManagerController::class,'getStates'])->name('getStates');
    Route::get('/get/cities/{id}',[ManagerController::class,'getCities'])->name('getCities');
    Route::get('/register/employee',[ManagerController::class,'RegisterEmployee'])->name('RegisterEmployee');
    Route::get('/delete/employee/{id}',[ManagerController::class,'deleteEmployee'])->name('deleteEmployee'); //this is our delete route
    Route::get('/edit/employee',[ManagerController::class,'editEmployee'])->name('editEmployee');

});