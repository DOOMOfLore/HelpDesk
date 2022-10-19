<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Categories\CategoriesController;
use App\Http\Controllers\Classification\ClassificationController;
use App\Http\Controllers\Complaint\ComplaintController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\MainMenu\MainMenuController;
use App\Http\Controllers\PIC\PICController;
use App\Http\Controllers\Status\StatusController;
use App\Http\Controllers\SubClassification\SubClassificationController;
use App\Http\Controllers\UserInput\UserInputController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DokumenController::class, 'index']);

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('storecomplaint', [DokumenController::class, 'storecomplaint'])->name('storecomplaint');

Route::group(['middleware' => ['auth', 'prevent-back-history']], function () {
    Route::group(['middleware' => ['role:Superadmin|Admin']], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('check', [DokumenController::class, 'check'])->name('check');
        Route::get('open', [DokumenController::class, 'open'])->name('open');


        Route::group(['middleware' => ['role:Superadmin']], function () {
            //users
            Route::get('get-users', [UsersController::class, 'getUsers'])->name('get-users');
            Route::apiResource('users', UsersController::class);

            //complaint
            Route::apiResource('complaint', ComplaintController::class);
            Route::get('get-complaint-all', [ComplaintController::class, 'getComplaint'])->name('get-complaint-all');
            Route::get('release', [ComplaintController::class, 'release'])->name('complaint.release');
            Route::get('get-release-all', [ComplaintController::class, 'getRelease'])->name('get-release-all');
            Route::get('waitingapproval', [ComplaintController::class, 'waitingapproval'])->name('complaint.waitingapproval');
            Route::get('get-waitingapproval-all', [ComplaintController::class, 'getWaitingApproval'])->name('get-waitingapproval-all');
            Route::get('onprocess', [ComplaintController::class, 'onprocess'])->name('complaint.onprocess');
            Route::get('get-onprocess-all', [ComplaintController::class, 'getonprocess'])->name('get-onprocess-all');
            Route::get('unapproved', [ComplaintController::class, 'unapproved'])->name('complaint.unapproved');
            Route::get('get-unapproved-all', [ComplaintController::class, 'getunapproved'])->name('get-unapproved-all');
            Route::get('solved', [ComplaintController::class, 'solved'])->name('complaint.solved');
            Route::get('get-solved-all', [ComplaintController::class, 'getsolved'])->name('get-solved-all');

            //categories
            Route::apiResource('categories', CategoriesController::class);
            Route::get('get-categories-all', [CategoriesController::class, 'getCategories'])->name('get-categories-all');

            //main_menu
            Route::apiResource('main_menu', MainMenuController::class);
            Route::get('get-main_menu-all', [MainMenuController::class, 'getMainMenu'])->name('get-main_menu-all');

            //classification
            Route::apiResource('classification', ClassificationController::class);
            Route::get('get-classification-all', [ClassificationController::class, 'getClassification'])->name('get-classification-all');

            //sub_classification
            Route::apiResource('sub_classification', SubClassificationController::class);
            Route::get('get-sub_classification-all', [SubClassificationController::class, 'getSubClassification'])->name('get-sub_classification-all');

            //PIC
            Route::apiResource('pic', PICController::class);
            Route::get('get-pic-all', [PICController::class, 'getPIC'])->name('get-pic-all');

            //status
            Route::apiResource('status', StatusController::class);
            Route::get('get-status-all', [StatusController::class, 'getStatus'])->name('get-status-all');

            //user_input
            Route::apiResource('user_input', UserInputController::class);
            Route::get('get-user_input-all', [UserInputController::class, 'getUserInput'])->name('get-user_input-all');
        });
    });
});
