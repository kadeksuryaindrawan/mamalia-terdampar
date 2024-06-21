<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeleteTemporaryProblemImageController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\UploadTemporaryProblemImageController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index']);
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::resource('user', UserController::class);
});

Route::group(['middleware' => ['auth', 'role2:admin,pelapor']], function () {
    Route::resource('masalah', ProblemController::class);
    Route::post('/uploadproblem', UploadTemporaryProblemImageController::class)->name('uploadtemporaryproblem');
    Route::delete('/deleteproblem', DeleteTemporaryProblemImageController::class)->name('deletetemporaryproblem');
    Route::get('/editfotomasalah/{id}', [ProblemController::class, 'editfotomasalah'])->name('editfotomasalah');
    Route::put('/editfotomasalahproses/{id}', [ProblemController::class, 'editfotomasalahproses'])->name('editfotomasalahproses');
});

Auth::routes([
    'reset' => false,
    'verify' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
