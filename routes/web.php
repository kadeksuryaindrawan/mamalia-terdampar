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

Route::get('locale/{locale}', function ($locale) {
    session()->put('locale', $locale);;
    return redirect()->back();
})->name('locale');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/donation', [DashboardController::class, 'donation'])->name('donation');
    Route::get('/home/ubahpassword/{id}', [DashboardController::class, 'ubahPassword'])->name('ubahpassword');
    Route::put('/home/ubahpassword/{id}', [DashboardController::class, 'updatePassword'])->name('updatepassword');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::resource('user', UserController::class);
});

Route::group(['middleware' => ['auth', 'role3:admin,pelapor,yayasan']], function () {
    Route::resource('laporan', ProblemController::class);
    Route::post('/uploadproblem', UploadTemporaryProblemImageController::class)->name('uploadtemporaryproblem');
    Route::delete('/deleteproblem', DeleteTemporaryProblemImageController::class)->name('deletetemporaryproblem');
    Route::get('/editfotolaporan/{id}', [ProblemController::class, 'editfotomasalah'])->name('editfotomasalah');
    Route::put('/editfotolaporanproses/{id}', [ProblemController::class, 'editfotomasalahproses'])->name('editfotomasalahproses');
});

Route::group(['middleware' => ['auth', 'role2:admin,yayasan']], function () {
    Route::get('/penanganan/create/{id}', [TindakanController::class, 'create'])->name('tindakan-create');
    Route::post('/penanganan/store/{id}', [TindakanController::class, 'store'])->name('tindakan-store');
    Route::get('/penanganan/edit/{id}', [TindakanController::class, 'edit'])->name('tindakan-edit');
    Route::put('/penanganan/update/{id}', [TindakanController::class, 'update'])->name('tindakan-update');
    Route::delete('/penanganan/destroy/{id}', [TindakanController::class, 'destroy'])->name('tindakan-destroy');
    Route::post('/uploadtemporarytindakan', UploadTemporaryTindakanImageController::class)->name('uploadtemporarytindakan');
    Route::delete('/deletetemporarytindakan', DeleteTemporaryTindakanImageController::class)->name('deletetemporarytindakan');
    Route::get('/penanganan/editfototindakan/{id}', [TindakanController::class, 'editfototindakan'])->name('editfototindakan');
    Route::put('/penanganan/editfototindakanproses/{id}', [TindakanController::class, 'editfototindakanproses'])->name('editfototindakanproses');
    Route::put('/penanganan/selesai', [TindakanController::class, 'selesai'])->name('tindakan-selesai');
    Route::get('/penanganan', [TindakanController::class, 'index'])->name('tindakan-index');
    Route::get('/penanganan/detail/{id}', [TindakanController::class, 'detail'])->name('tindakan-detail');
    Route::get('/penanganan/terakhir/{id}', [TindakanController::class, 'tindakanterakhir'])->name('tindakan-terakhir');
});

Auth::routes([
    'reset' => false,
    'verify' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
