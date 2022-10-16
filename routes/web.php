<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Categories\CategoriesController;
use App\Http\Controllers\Complaint\ComplaintController;
use App\Http\Controllers\Complaint\OnProcessController;
use App\Http\Controllers\Complaint\ReleaseController;
use App\Http\Controllers\Complaint\UnapprovedController;
use App\Http\Controllers\Complaint\WaitingApprovalController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\MainMenu\MainMenuController;
use App\Http\Controllers\Users\UsersController;
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
    return view('welcome');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'prevent-back-history']], function () {
    Route::group(['middleware' => ['role:Superadmin']], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('check', [DokumenController::class, 'check'])->name('check');
        Route::get('open', [DokumenController::class, 'open'])->name('open');
        
        //users
        Route::get('get-users', [UsersController::class, 'getUsers'])->name('get-users');
        Route::apiResource('users', UsersController::class);

        //complaint
        Route::apiResource('complaint', ComplaintController::class);
        Route::get('get-complaint-all', [ComplaintController::class, 'getComplaint'])->name('get-complaint-all');
        Route::apiResource('release', ReleaseController::class);
        Route::get('get-release-all', [ReleaseController::class, 'getRelease'])->name('get-release-all');
        Route::apiResource('waiting_approval', WaitingApprovalController::class);
        Route::get('get-waitingapproval-all', [WaitingApprovalController::class, 'getWaitingApproval'])->name('get-waitingapproval-all');
        Route::apiResource('onprocess', OnProcessController::class);
        Route::get('get-onprocess-all', [OnProcessController::class, 'getonprocess'])->name('get-onprocess-all');
        Route::apiResource('unapproved', UnapprovedController::class);
        Route::get('get-unapproved-all', [UnapprovedController::class, 'getunapproved'])->name('get-unapproved-all');
        
        //categories
        Route::apiResource('categories', CategoriesController::class);
        Route::get('get-categories-all', [CategoriesController::class, 'getCategories'])->name('get-categories-all');

        //main_menu
        Route::apiResource('main_menu', MainMenuController::class);
        Route::get('get-main_menu-all', [MainMenuController::class, 'getMainMenu'])->name('get-main_menu-all');
    });
});
