<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BAController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DinasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;

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

Route::get('/',function(){
    return view('home');
})->name('home');

Route::get('/dashboard',[DashboardController::class, 'index'])
    ->name('dashboard');

Route::post('/logout',[LogoutController::class, 'store'])->name('logout');

Route::get('/login',[LoginController::class, 'index'])->name('login');
Route::post('/login',[LoginController::class, 'store']);

Route::get('/register',[RegisterController::class, 'index'])->name('register');
Route::post('/register',[RegisterController::class, 'store']);

//ADMIN
Route::get('/admin/dashboard',[AdminController::class, 'AdminDashboard'])->name('admindashboard');

//KELURAHAN
Route::get('/penduduk/dashboard',[KelurahanController::class, 'PendudukDashboard'])->name('pendudukdashboard');
Route::get('/penduduk/report',[KelurahanController::class, 'PendudukReport'])->name('pendudukreport');
Route::get('/penduduk/rekap',[KelurahanController::class, 'PendudukRekap'])->name('pendudukrekap');
Route::get('/pendudukcreate',[KelurahanController::class, 'CreateView'])->name('pendudukcreateview');
Route::post('/pendudukcreate',[KelurahanController::class, 'Create'])->name('pendudukcreate');
Route::get('/pendudukupdate/{id}',[KelurahanController::class, 'UpdateView'])->name('pendudukupdateview');
Route::get('/pendudukupdate',[KelurahanController::class, 'Update'])->name('pendudukupdate');
Route::get('/pendudukdelete/{id}',[KelurahanController::class, 'Delete'])->name('pendudukdelete');

Route::get('/home/rekap',[DashboardController::class, 'RekapHome'])->name('rekaphome');

//BA
Route::post('/ba_create',[BAController::class, 'Create'])->name('ba_create');
Route::get('/ba_update',[BAController::class, 'UpdateView'])->name('ba_updateview');
Route::post('/ba_update',[BAController::class, 'Update'])->name('ba_update');
Route::get('/ba/printview', [BAController::class, 'printview'])->name('printview');
Route::get('/ba/printpdf', [BAController::class, 'printPDF'])->name('printpdf');

//DINAS
Route::get('/dinas/dashboard',[DinasController::class, 'DinasDashboard'])->name('dinasdashboard');
Route::get('/dinas/report',[DinasController::class, 'DinasReport'])->name('dinasreport');
Route::get('/dinas/rekap',[DinasController::class, 'PendudukRekap'])->name('dinasrekap');
Route::get('/dinas/rekapstatus',[DinasController::class, 'PendudukRekapStatus'])->name('dinasrekapstatus');
Route::get('/mentri/dashboard',[DinasController::class, 'MentriDashboard'])->name('mentridashboard');
Route::post('/mentri/update',[DinasController::class, 'MentriUpdate'])->name('mentriupdate');
Route::get('/periode',[DinasController::class, 'PeriodeView'])->name('periode');
Route::post('/periodecreate',[DinasController::class, 'PeriodeCreate'])->name('periodecreate');

//search

//not used
Route::get('/posts', function () {
    return view('posts.index');
});
