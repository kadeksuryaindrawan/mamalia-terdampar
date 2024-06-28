<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeleteTemporaryProblemImageController;
use App\Http\Controllers\DeleteTemporaryTindakanImageController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\UploadTemporaryProblemImageController;
use App\Http\Controllers\UploadTemporaryTindakanImageController;
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
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home/ubahpassword/{id}', [DashboardController::class, 'ubahPassword'])->name('ubahpassword');
    Route::put('/home/ubahpassword/{id}', [DashboardController::class, 'updatePassword'])->name('updatepassword');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::resource('user', UserController::class);
});

Route::group(['middleware' => ['auth', 'role3:admin,pelapor,yayasan']], function () {
    Route::resource('masalah', ProblemController::class);
    Route::post('/uploadproblem', UploadTemporaryProblemImageController::class)->name('uploadtemporaryproblem');
    Route::delete('/deleteproblem', DeleteTemporaryProblemImageController::class)->name('deletetemporaryproblem');
    Route::get('/editfotomasalah/{id}', [ProblemController::class, 'editfotomasalah'])->name('editfotomasalah');
    Route::put('/editfotomasalahproses/{id}', [ProblemController::class, 'editfotomasalahproses'])->name('editfotomasalahproses');
});

Route::group(['middleware' => ['auth', 'role2:admin,yayasan']], function () {
    Route::get('/tindakan/create/{id}', [TindakanController::class, 'create'])->name('tindakan-create');
    Route::post('/tindakan/store/{id}', [TindakanController::class, 'store'])->name('tindakan-store');
    Route::get('/tindakan/edit/{id}', [TindakanController::class, 'edit'])->name('tindakan-edit');
    Route::put('/tindakan/update/{id}', [TindakanController::class, 'update'])->name('tindakan-update');
    Route::delete('/tindakan/destroy/{id}', [TindakanController::class, 'destroy'])->name('tindakan-destroy');
    Route::post('/uploadtemporarytindakan', UploadTemporaryTindakanImageController::class)->name('uploadtemporarytindakan');
    Route::delete('/deletetemporarytindakan', DeleteTemporaryTindakanImageController::class)->name('deletetemporarytindakan');
    Route::get('/tindakan/editfototindakan/{id}', [TindakanController::class, 'editfototindakan'])->name('editfototindakan');
    Route::put('/tindakan/editfototindakanproses/{id}', [TindakanController::class, 'editfototindakanproses'])->name('editfototindakanproses');
    Route::put('/tindakan/selesai/{id}', [TindakanController::class, 'selesai'])->name('tindakan-selesai');
});

Route::group(['middleware' => ['auth', 'role3:admin,yayasan,westerlaken']], function () {
    Route::get('/tindakan', [TindakanController::class, 'index'])->name('tindakan-index');
    Route::get('/tindakan/detail/{id}', [TindakanController::class, 'detail'])->name('tindakan-detail');
    Route::get('/tindakan/terakhir/{id}', [TindakanController::class, 'tindakanterakhir'])->name('tindakan-terakhir');
});

Auth::routes([
    'reset' => false,
    'verify' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
