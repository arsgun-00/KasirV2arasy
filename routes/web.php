<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;


use App\Models\Produk;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManageUserController;


Route::get('/',[UserController::class,'login'])->name('login');
Route::get('/register',[UserController::class,'register'])->name('register');
Route::post('/register',[UserController::class,'registerStore'])->name('register.store');
Route::post('/login',[UserController::class,'loginCheck'])->name('login.check');
Route::resource('users', UserController::class);

// dasboard
Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
Route::get('/top-selling-products', [DashboardController::class, 'getTopSellingProducts']);
Route::get('/low-stock-products', [DashboardController::class, 'getLowStockProducts']);
Route::get('/monthly-revenue', [DashboardController::class, 'getMonthlyRevenue']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/penjualan/datatable', [PenjualanController::class, 'datatable'])->name('penjualan.datatable');
Route::get('/penjualan/{id}/bayar', [PenjualanController::class, 'bayarCash'])->name('penjualan.bayarCash');
Route::post('/penjualan/bayar-cash', [PenjualanController::class, 'bayarCashStore'])->name('penjualan.bayarCashStore');
Route::get('/penjualan/{id}/nota', [PenjualanController::class, 'Nota'])->name('penjualan.nota');
Route::get('/dashboard/get-top-selling-products', [DashboardController::class, 'getTopSellingProducts'])->name('dashboard.getTopSellingProducts');
Route::get('/dashboard/get-low-stock-products', [DashboardController::class, 'getLowStockProducts'])->name('dashboard.getLowStockProducts');
Route::get('/dashboard/get-monthly-revenue', [DashboardController::class, 'getMonthlyRevenue'])->name('dashboard.getMonthlyRevenue');


Route::group(['middleware' => ['auth']], function () {
    Route::post('produk/cetak/label',[ProdukController::class,'cetakLabel'])->name('produk.cetakLabel');
    Route::get('produk/datatables/log',[ProdukController::class,'datatablesLog'])->name('produk.datatableLog');
    Route::get('produk/datatables',[ProdukController::class,'datatable'])->name('produk.datatable');
    Route::get('penjualan/datatables',[PenjualanController::class,'datatable'])->name('penjualan.datatable');
    Route::PUT('produk/edit/{id}/tambahStok',[ProdukController::class,'tambahStok'])->name('produk.tambahStok');
    Route::get('produk/logproduk',[ProdukController::class,'logproduk'])->name('produk.logproduk');
    Route::resource('produk', ProdukController::class);
    Route::resource('penjualan', PenjualanController::class);
    Route::get('penjualan/bayarCash/{id}',[PenjualanController::class,'bayarCash'])->name('penjualan.bayarCash');
    Route::post('penjualan/bayarCash',[PenjualanController::class,'bayarCashStore'])->name('penjualan.bayarCashStore');
    Route::get('penjualan/nota/{id}',[PenjualanController::class,'nota'])->name('penjualan.nota');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/manage-user', [ManageUserController::class, 'index'])->name('manage-user.index');
});

