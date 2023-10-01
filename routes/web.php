<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KadivController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PimpinanController;
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
    return view('auth/login');
});

Auth::routes();


//pegawai
Route::middleware(['auth','user-role:pegawai'])->group(function()
{
    Route::get('/dashboard',[PegawaiController::class, 'pegawaiDashboard']) ->name('pegawai.dashboard');
    Route::get('/calculate-remaining-leave', [PegawaiController::class, 'showCalculationResult'])->name('calculate.remaining.leave');
    Route::post('/calculate-remaining-leave', [PegawaiController::class, 'calculateRemainingLeave'])->name('calculate.remaining.leave.post');

    //alasan penting
    Route::get('/pegawai/ctalpen', [PegawaiController::class, 'riwayatAlpen']);
    Route::Post('/pegawai/ctalpen/simpan', [PegawaiController::class, 'simpanAlpen']);
    Route::get('/pegawai/printalpen/{id}', [PegawaiController::class, 'printAlpen']);
    Route::get('/pegawai/infoalpen/{id}', [PegawaiController::class, 'infoAlpen']);

    //cuti besar
    Route::get('/pegawai/ctbsr', [PegawaiController::class, 'riwayatBsr']);
    Route::Post('/pegawai/ctbsr/simpan', [PegawaiController::class, 'simpanBsr']);
    Route::get('/pegawai/printbsr/{id}', [PegawaiController::class, 'printBsr']);
    Route::get('/pegawai/infobsr/{id}', [PegawaiController::class, 'infoBsr']);

    //cuti diluar tanggungan negara
    Route::get('/pegawai/ctdtn', [PegawaiController::class, 'riwayatDtn']);
    Route::Post('/pegawai/ctdtn/simpan', [PegawaiController::class, 'simpanDtn']);
    Route::get('/pegawai/printdtn/{id}', [PegawaiController::class, 'printDtn']);
    Route::get('/pegawai/infodtn/{id}', [PegawaiController::class, 'infoDtn']);

    //cuti tahunan
    Route::get('/pegawai/ctthn', [PegawaiController::class, 'riwayatThn']);
    Route::Post('/pegawai/ctthn/simpan', [PegawaiController::class, 'simpanThn']);
    Route::get('/pegawai/printthn/{id}', [PegawaiController::class, 'printThn']);
    Route::get('/pegawai/infothn/{id}', [PegawaiController::class, 'infoThn']);

    //cuti sakit
    Route::get('/pegawai/ctskt', [PegawaiController::class, 'riwayatSkt']);
    Route::Post('/pegawai/ctskt/simpan', [PegawaiController::class, 'simpanSkt']);
    Route::get('/pegawai/printskt/{id}', [PegawaiController::class, 'printSkt']);
    Route::get('/pegawai/infoskt/{id}', [PegawaiController::class, 'infoSkt']);

    //cuti bersallin
    Route::get('/pegawai/ctsln', [PegawaiController::class, 'riwayatSln']);
    Route::Post('/pegawai/ctsln/simpan', [PegawaiController::class, 'simpanSln']);
    Route::get('/pegawai/printsln/{id}', [PegawaiController::class, 'printSln']);
});

//kadiv
Route::middleware(['auth','user-role:kadiv'])->group(function()
{
    Route::get('/kadiv/dashboard', [KadivController::class, 'dashboardKadiv']);
    Route::get('/kadiv/daftarpg', [KadivController::class, 'daftarpgKadiv']);
    Route::get('/kadiv/detilpg/{id}', [KadivController::class, 'detilpgKadiv']);
    Route::post('/kadiv/save-lama-kerja/{id}', [KadivController::class, 'saveLamaKerja'])->name('kadiv.save-lama-kerja');
    Route::post('/kadiv/usernonaktif/{id}', [KadivController::class, 'userNonaktif'])->name('kadiv.updatepg');
    Route::get('/kadiv/buatakun', [KadivController::class, 'buatAkunKadiv'])->name('register');
    Route::post('/kadiv/registrasi', [KadivController::class, 'registrasiKadiv']);
    Route::get('/kadiv/dashboard',[KadivController::class, 'kadivDashboard']) ->name('kadiv.dashboard');

    //alasan penting
    Route::get('/kadiv/ctalpen', [KadivController::class, 'riwayatAlpen']);
    Route::Post('/kadiv/ctalpen/simpan', [KadivController::class, 'simpanAlpen']);
    Route::get('/kadiv/printalpen/{id}', [KadivController::class, 'printAlpen']);
    Route::put('/kadiv/teruskanalpen/{id}', [KadivController::class, 'teruskanAlpen'])->name('kadiv.updatealpen');
    Route::get('/kadiv/infoalpen/{id}', [KadivController::class, 'infoAlpen']);

    //cuti besar
    Route::get('/kadiv/ctbsr', [KadivController::class, 'riwayatBsr']);
    Route::Post('/kadiv/ctbsr/simpan', [KadivController::class, 'simpanBsr']);
    Route::get('/kadiv/printbsr/{id}', [KadivController::class, 'printBsr']);
    Route::put('/kadiv/teruskanbsr/{id}', [KadivController::class, 'teruskanBsr'])->name('kadiv.updatebsr');
    Route::get('/kadiv/infobsr/{id}', [KadivController::class, 'infoBsr']);

    //cuti diluar tanggungan negara
    Route::get('/kadiv/ctdtn', [KadivController::class, 'riwayatDtn']);
    Route::Post('/kadiv/ctdtn/simpan', [KadivController::class, 'simpanDtn']);
    Route::get('/kadiv/printdtn/{id}', [KadivController::class, 'printDtn']);
    Route::put('/kadiv/teruskandtn/{id}', [KadivController::class, 'teruskanDtn'])->name('kadiv.updatedtn');
    Route::get('/kadiv/infodtn/{id}', [KadivController::class, 'infoDtn']);

    //cuti tahunan
    Route::get('/kadiv/ctthn', [KadivController::class, 'riwayatThn']);
    Route::Post('/kadiv/ctthn/simpan', [KadivController::class, 'simpanThn']);
    Route::get('/kadiv/printthn/{id}', [KadivController::class, 'printThn']);
    Route::put('/kadiv/teruskanthn/{id}', [KadivController::class, 'teruskanThn'])->name('kadiv.updatethn');
    Route::get('/kadiv/infothn/{id}', [KadivController::class, 'infoThn']);

    //cuti sakit
    Route::get('/kadiv/ctskt', [KadivController::class, 'riwayatSkt']);
    Route::Post('/kadiv/ctskt/simpan', [KadivController::class, 'simpanSkt']);
    Route::get('/kadiv/printskt/{id}', [KadivController::class, 'printSkt']);
    Route::put('/kadiv/teruskanskt/{id}', [KadivController::class, 'teruskanSkt'])->name('kadiv.updateskt');
    Route::get('/kadiv/infoskt/{id}', [KadivController::class, 'infoSkt']);

    //cuti bersalin
    Route::get('/kadiv/ctsln', [KadivController::class, 'riwayatSln']);
    Route::Post('/kadiv/ctsln/simpan', [KadivController::class, 'simpanSln']);
    Route::get('/kadiv/printsln/{id}', [KadivController::class, 'printSln']);
    Route::put('/kadiv/teruskansln/{id}', [KadivController::class, 'teruskanSln'])->name('kadiv.updatesln');
    Route::get('/kadiv/infosln/{id}', [KadivController::class, 'infoSln']);
});

//pimpinan
Route::middleware(['auth','user-role:pimpinan'])->group(function()
{
    Route::get('/pimpinan/dashboard',[PimpinanController::class, 'pimpinanDashboard']) ->name('pimpinan.dashboard');
    Route::get('/pimpinan/daftarpg', [PimpinanController::class, 'daftarpgPimpinan']);
    Route::get('/pimpinan/detilpg/{id}', [PimpinanController::class, 'detilpgPimpinan']);

    //alasan penting
    Route::get('/pimpinan/ctalpen', [PimpinanController::class, 'riwayatAlpen']);
    Route::put('/pimpinan/setujuialpen/{id}', [PimpinanController::class, 'setujuiAlpen'])->name('pimpinan.updatealpen');
    Route::get('/pimpinan/infoalpen/{id}', [PimpinanController::class, 'infoAlpen']);
    Route::get('/pimpinan/printalpen/{id}', [PimpinanController::class, 'printAlpen']);

    //cuti besar
    Route::get('/pimpinan/ctbsr', [PimpinanController::class, 'riwayatBsr']);
    Route::put('/pimpinan/setujuibsr/{id}', [PimpinanController::class, 'setujuiBsr'])->name('pimpinan.updatebsr');
    Route::get('/pimpinan/infobsr/{id}', [PimpinanController::class, 'infoBsr']);
    Route::get('/pimpinan/printbsr/{id}', [PimpinanController::class, 'printBsr']);

    //cuti diluar tanggungan negara
    Route::get('/pimpinan/ctdtn', [PimpinanController::class, 'riwayatDtn']);
    Route::put('/pimpinan/setujuidtn/{id}', [PimpinanController::class, 'setujuiDtn'])->name('pimpinan.updatedtn');
    Route::get('/pimpinan/infodtn/{id}', [PimpinanController::class, 'infoDtn']);
    Route::get('/pimpinan/printdtn/{id}', [pimpinanController::class, 'printDtn']);

    //cuti tahunan
    Route::get('/pimpinan/ctthn', [PimpinanController::class, 'riwayatThn']);
    Route::put('/pimpinan/setujuithn/{id}', [PimpinanController::class, 'setujuiThn'])->name('pimpinan.updatethn');
    Route::get('/pimpinan/infothn/{id}', [PimpinanController::class, 'infoThn']);
    Route::get('/pimpinan/printthn/{id}', [pimpinanController::class, 'printThn']);

    //cuti sakit
    Route::get('/pimpinan/ctskt', [PimpinanController::class, 'riwayatSkt']);
    Route::put('/pimpinan/setujuiskt/{id}', [PimpinanController::class, 'setujuiSkt'])->name('pimpinan.updateskt');
    Route::get('/pimpinan/infoskt/{id}', [PimpinanController::class, 'infoSkt']);
    Route::get('/pimpinan/printskt/{id}', [PimpinanController::class, 'printSkt']);

    //cuti bersalin
    Route::get('/pimpinan/ctsln', [PimpinanController::class, 'riwayatSln']);
    Route::put('/pimpinan/setujuisln/{id}', [PimpinanController::class, 'setujuiSln'])->name('pimpinan.updatesln');
    Route::get('/pimpinan/viewsln/{id}', [PimpinanController::class, 'viewSln']);
    Route::get('/pegawai/infosln/{id}', [PegawaiController::class, 'infoSln']);
    Route::get('/pimpinan/printsln/{id}', [PimpinanController::class, 'printSln']);
});


Route::get('/kadiv', function () {
    return view('layouts/kadiv');
});
