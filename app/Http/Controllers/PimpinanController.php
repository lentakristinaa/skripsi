<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CtAlpen;
use App\Models\CtBsr;
use App\Models\CtThn;
use App\Models\CtDtn;
use App\Models\CtSkt;
use App\Models\CtSln;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PimpinanController extends Controller
{
    public function pimpinanDashboard() {
        return view('pimpinan/dashboard');
    }

    public function daftarpgPimpinan() {
        $user = User::where('role', 'pegawai')->get();
        return view('pimpinan/daftar-pg', ['user' => $user]);
    }

    public function detilpgPimpinan($id) {
        $user = User::find($id);
        $tanggalMasuk = Carbon::parse($user->tgl_msk);
        $tanggalSekarang = Carbon::now();
        $selisihTahun = $tanggalMasuk->diffInYears($tanggalSekarang);
        $user->lama_krja = (int) $selisihTahun;
        $user->save();

        return view('pimpinan/detil-pg', ['user' => $user]);
    }

    //ALASAN PENTING
    public function riwayatAlpen() {
        $srt = CtAlpen::all();
        return view ('pimpinan/ct-alpen', ['srt' => $srt]);
    }

    public function setujuiAlpen ($id, Request $Request) {
        $acc = CtAlpen::find( $id);
        $acc->status = $Request->status;
        $acc->save();

        $hitungAlpen = CtAlpen::where('id_user', $acc->id_user)
        ->where('status', 'disetujui')
        ->sum('durasi');
        $hitungSkt = CtSkt::where('id_user', $acc->id_user)
        ->where('status', 'disetujui')
        ->sum('durasi');
        $hitungThn = CtThn::where('id_user', $acc->id_user)
        ->where('status', 'disetujui')
        ->sum('durasi');
        $sisa_ct = 12 - ($hitungAlpen + $hitungSkt + $hitungThn);
        $user = User::find($acc->id_user);
        $user->sisa_ct = $sisa_ct;
        $user->save();

        return redirect ('pimpinan/ctalpen');
    }

    public function infoAlpen($id) {
        $srt = CtAlpen::find($id);
        return view('pimpinan/infoalpen', ['srt' => $srt]);
    }

    public function printAlpen($id) {
        $print = CtAlpen::find($id);
        return view ('pimpinan/printalpen', [
            'nama' => $print->user->name,
            'nip' => $print->user->nip,
            'golongan' => $print->user->golongan,
            'jabatan' => $print->user->jabatan,
            'durasi' => $print->durasi,
            'tgl_mulai' => $print->tgl_mulai,
            'tgl_sls' => $print->tgl_sls,
            'alamat' => $print->user->alamat,
            'keterangan' => $print->keterangan,
            'tgl_pgjn' => $print->tgl_pgjn = date('y-m-d')
        ]);
    }

    //CUTI BESAR
    public function riwayatBsr() {
        $srt = CtBsr::all();
        return view ('pimpinan/ct-bsr', ['srt' => $srt]);
    }

    public function setujuiBsr ($id, Request $Request) {
        $acc= CtBsr::find( $id);
        $acc->status = $Request->status;
        $acc->save();
        return redirect ('pimpinan/ctbsr');
    }

    public function infoBsr($id) {
        $srt = CtBsr::find($id);
        return view('pimpinan/infobsr', ['srt' => $srt]);
    }

    public function printBsr($id) {
        $print = CtBsr::find($id);
        return view ('pimpinan/printbsr', [
            'nama' => $print->user->name,
            'nip' => $print->user->nip,
            'golongan' => $print->user->golongan,
            'jabatan' => $print->user->jabatan,
            'durasi' => $print->durasi,
            'tgl_mulai' => $print->tgl_mulai,
            'tgl_sls' => $print->tgl_sls,
            'alamat' => $print->user->alamat,
            'keterangan' => $print->keterangan,
            'tgl_pgjn' => $print->tgl_pgjn = date('y-m-d')
        ]);
    }

    //CUTI TAHUNAN
    public function riwayatThn() {
        $srt = CtThn::all();
        return view ('pimpinan/ct-thn', ['srt' => $srt]);
    }

    public function setujuiThn ($id, Request $Request) {
        $acc= CtThn::find( $id);
        /* $sct = User::where('nip', $acc->nip);
        $sct->sisa_ct_thn = ((int)$sct->sisa_ct_thn - (int)$acc->durasi); */
        $acc->status = $Request->status;
        $acc->save();
        $hitungAlpen = CtAlpen::where('id_user', $acc->id_user)
        ->where('status', 'disetujui')
        ->sum('durasi');
        $hitungSkt = CtSkt::where('id_user', $acc->id_user)
        ->where('status', 'disetujui')
        ->sum('durasi');
        $hitungThn = CtThn::where('id_user', $acc->id_user)
        ->where('status', 'disetujui')
        ->sum('durasi');
        $sisa_ct = 12 - ($hitungAlpen + $hitungSkt + $hitungThn);
        $user = User::find($acc->id_user);
        $user->sisa_ct = $sisa_ct;
        $user->save();
        return redirect ('pimpinan/ctthn');
    }

    public function infoThn($id) {
        $srt = CtThn::find($id);
        return view('pimpinan/infothn', ['srt' => $srt]);
    }

    public function printThn($id) {
        $print = CtThn::find($id);
        return view ('pimpinan/printthn', [
            'nama' => $print->user->name,
            'nip' => $print->user->nip,
            'golongan' => $print->user->golongan,
            'jabatan' => $print->user->jabatan,
            'durasi' => $print->durasi,
            'tgl_mulai' => $print->tgl_mulai,
            'tgl_sls' => $print->tgl_sls,
            'tahun' => $print->tahun,
            'alamat' => $print->user->alamat,
            'tgl_pgjn' => $print->tgl_pgjn = date('y-m-d')
        ]);
    }

    //DILUAR TANGGUNGAN NEGARA
    public function riwayatDtn() {
        $srt = CtDtn::all();
        return view ('pimpinan/ct-dtn', ['srt' => $srt]);
    }

    public function setujuiDtn ($id, Request $Request) {
        $acc= CtDtn::find( $id);
        $acc->status = $Request->status;
        $acc->save();
        return redirect ('pimpinan/ctdtn');
    }

    public function infoDtn($id) {
        $srt = CtDtn::find($id);
        return view('pimpinan/infodtn', ['srt' => $srt]);
    }

    public function printDtn($id) {
        $print = CtDtn::find($id);
        return view ('pimpinan/printdtn', [
            'nama' => $print->user->name,
            'nip' => $print->user->nip,
            'golongan' => $print->user->golongan,
            'jabatan' => $print->user->jabatan,
            'durasi' => $print->durasi,
            'tgl_mulai' => $print->tgl_mulai,
            'tgl_sls' => $print->tgl_sls,
            'alamat' => $print->user->alamat,
            'keterangan' => $print->keterangan,
            'tgl_pgjn' => $print->tgl_pgjn = date('y-m-d')
        ]);
    }

    //CUTI SAKIT
    public function riwayatSkt() {
        $srt = CtSkt::all();
        return view ('pimpinan/ct-skt', ['srt' => $srt]);
    }


    public function setujuiSkt ($id, Request $Request) {
        $acc= CtSkt::find( $id);
        $acc->status = $Request->status;
        $acc->save();

        $hitungAlpen = CtAlpen::where('id_user', $acc->id_user)
        ->where('status', 'disetujui')
        ->sum('durasi');
        $hitungSkt = CtSkt::where('id_user', $acc->id_user)
        ->where('status', 'disetujui')
        ->sum('durasi');
        $hitungThn = CtThn::where('id_user', $acc->id_user)
        ->where('status', 'disetujui')
        ->sum('durasi');
        $sisa_ct = 12 - ($hitungAlpen + $hitungSkt + $hitungThn);
        $user = User::find($acc->id_user);
        $user->sisa_ct = $sisa_ct;
        $user->save();
        return redirect ('pimpinan/ctskt');
    }


    public function infoSkt($id) {
        $srt = CtSkt::find($id);
        return view('pimpinan/infoskt', ['srt' => $srt]);
    }

    public function printSkt($id) {
        $print = CtSkt::find($id);
        return view ('pimpinan/printskt', [
            'nama' => $print->user->name,
            'nip' => $print->user->nip,
            'golongan' => $print->user->golongan,
            'jabatan' => $print->user->jabatan,
            'durasi' => $print->durasi,
            'tgl_mulai' => $print->tgl_mulai,
            'tgl_sls' => $print->tgl_sls,
            'alamat' => $print->user->alamat,
            'keterangan' => $print->keterangan,
            'tgl_pgjn' => $print->tgl_pgjn = date('y-m-d')
        ]);
    }

    //CUTI BERSALIN
    public function riwayatSln() {
        $srt = CtSln::all();
        return view ('pimpinan/ct-sln', ['srt' => $srt]);
    }

    public function setujuiSln ($id, Request $Request) {
        $acc= CtSln::find( $id);
        $acc->status = $Request->status;
        $acc->save();
        return redirect ('pimpinan/ctsln');
    }

    public function infoSln($id) {
        $srt = CtSln::find($id);
        return view('pimpinan/infosln', ['srt' => $srt]);
    }

    public function printSln($id) {
        $print = CtSln::find($id);
        return view ('pimpinan/printbers', [
            'nama' => $print->user->name,
            'nip' => $print->user->nip,
            'golongan' => $print->user->golongan,
            'jabatan' => $print->user->jabatan,
            'durasi' => $print->durasi,
            'tgl_mulai' => $print->tgl_mulai,
            'alamat' => $print->user->alamat,
            'keterangan' => $print->keterangan,
            'tgl_pgjn' => $print->tgl_pgjn = date('y-m-d')
        ]);
    }
}
