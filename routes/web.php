<?php

use Illuminate\Support\Facades\Route;
use App\Models\Barang;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\HargaController;
use App\Http\Controllers\PackingController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\KasirController;

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        $barangs = Barang::all();

        return view('dashboard', compact('barangs'));

    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | MASTER BARANG
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin,owner')->group(function () {

 Route::get('/barang', [BarangController::class, 'index'])
        ->name('barang.index');

    Route::get('/barang/create', [BarangController::class, 'create'])
        ->name('barang.create');

    Route::post('/barang', [BarangController::class, 'store'])
        ->name('barang.store');

    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])
        ->name('barang.edit');

    Route::put('/barang/{id}', [BarangController::class, 'update'])
        ->name('barang.update');

    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])
        ->name('barang.destroy');


});

    /*
    |--------------------------------------------------------------------------
    | PEMBELIAN
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin,owner')->group(function () {

       Route::get('/pembelian-supplier', [PembelianController::class, 'index'])
        ->name('pembelian.index');

    Route::get('/pembelian-supplier/create', [PembelianController::class, 'create'])
        ->name('pembelian.create');

    Route::post('/pembelian-supplier', [PembelianController::class, 'store'])
        ->name('pembelian.store');

    Route::get('/pembelian-supplier/{id}/po', [PembelianController::class, 'cetakPO'])
        ->name('pembelian.po');


});
    /*
    |--------------------------------------------------------------------------
    | GUDANG
    |--------------------------------------------------------------------------
    */
Route::middleware('role:admin,gudang')->group(function () {

    Route::get('/gudang', [GudangController::class, 'index'])
        ->name('gudang.index');

    Route::post('/gudang/update-stok/{id}', [GudangController::class, 'updateStok'])
        ->name('gudang.updateStok');

    Route::get('/gudang/{id}', [GudangController::class, 'terimaBarang'])
        ->name('gudang.terima');

    Route::post('/gudang/{id}', [GudangController::class, 'simpanBarangMasuk'])
        ->name('gudang.simpan');
});
/*
|--------------------------------------------------------------------------
| KASIR
|--------------------------------------------------------------------------
*/

Route::middleware('role:admin,kasir')->group(function () {

    Route::get('/kasir', [KasirController::class, 'index'])
        ->name('kasir.index');

    Route::post('/kasir/store', [KasirController::class, 'store'])
        ->name('kasir.store');

    Route::get('/kasir/struk/{id}', [KasirController::class, 'struk'])
        ->name('kasir.struk');

    Route::post('/kasir/tambah-stok/{id}', [KasirController::class, 'tambahStok'])
        ->name('kasir.tambahStok');

});
   
   /*
|--------------------------------------------------------------------------
| PACKING
|--------------------------------------------------------------------------
*/

Route::middleware('role:admin,packing')->group(function () {

    Route::get('/packing', [PackingController::class, 'index'])
        ->name('packing.index');

    Route::post('/packing/update-status/{id}', [PackingController::class, 'updateStatus'])
        ->name('packing.update');

});
   
   /*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/
Route::middleware('role:admin,owner')->group(function () {

     // LAPORAN UTAMA
    Route::get('/owner/laporan', [OwnerController::class, 'laporan'])
        ->name('owner.laporan');

    Route::get('/owner/laporan/pdf', [OwnerController::class, 'exportPdf'])
        ->name('owner.pdf');
        
    // LAPORAN PENJUALAN
    Route::get('/owner/laporan/penjualan', [OwnerController::class, 'laporanPenjualan'])
        ->name('owner.laporan.penjualan');

    Route::get('/owner/laporan/penjualan/pdf', [OwnerController::class, 'pdfPenjualan'])
        ->name('owner.pdf.penjualan');        
        
    // LAPORAN PEMBELIAN
    Route::get('/owner/laporan/pembelian', [OwnerController::class, 'laporanPembelian'])
        ->name('owner.laporan.pembelian');

    Route::get('/owner/laporan/pembelian/pdf', [OwnerController::class, 'pdfPembelian'])
        ->name('owner.pdf.pembelian');
        
        // LAPORAN BARANG MASUK
Route::get('/owner/laporan/barang-masuk', [OwnerController::class, 'laporanBarangMasuk'])
    ->name('owner.laporan.barang.masuk');

Route::get('/owner/laporan/barang-masuk/pdf', [OwnerController::class, 'pdfBarangMasuk'])
    ->name('owner.pdf.barang.masuk');
    
        
    // PENENTUAN HARGA
    Route::get('/owner/penentuan-harga', [HargaController::class, 'index'])
        ->name('harga.index');

    Route::get('/owner/penentuan-harga/{id}/edit', [HargaController::class, 'edit'])
        ->name('harga.edit');

    Route::put('/owner/penentuan-harga/{id}', [HargaController::class, 'update'])
        ->name('harga.update');

});
/*
    |--------------------------------------------------------------------------
    | Supplier
    |--------------------------------------------------------------------------
    */
Route::get('/supplier', [SupplierController::class, 'index'])
    ->name('supplier.index');

Route::post('/supplier', [SupplierController::class, 'store'])
    ->name('supplier.store');

Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit'])
    ->name('supplier.edit');

Route::put('/supplier/{id}', [SupplierController::class, 'update'])
    ->name('supplier.update');

Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])
    ->name('supplier.destroy');


    
 /*
|--------------------------------------------------------------------------
| INVOICE
|--------------------------------------------------------------------------
*/
Route::get('/invoice', [InvoiceController::class,'index'])
    ->name('invoice.index');

Route::get('/invoice/{id}', [InvoiceController::class,'create'])
    ->name('invoice.create');

Route::post('/invoice/{id}', [InvoiceController::class,'store'])
    ->name('invoice.store');

Route::get('/invoice/{id}/show', [InvoiceController::class,'show'])
    ->name('invoice.show');

Route::get('/invoice/{id}/pdf', [InvoiceController::class, 'pdf'])
    ->name('invoice.pdf');
});
