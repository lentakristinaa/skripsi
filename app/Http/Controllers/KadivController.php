<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\CtAlpen;
use App\Models\CtBsr;
use App\Models\CtDtn;
use App\Models\CtSkt;
use App\Models\CtSln;
use App\Models\CtThn;
use App\Models\CutiSm;
use Carbon\Carbon;

class KadivController extends Controller
{
    public function kadivDashboard() {
        return view('kadiv/dashboard');
    }

    public function detilpgKadiv($id) {
        $user = User::find($id);
        $tanggalMasuk = Carbon::parse($user->tgl_msk);
        $tanggalSekarang = Carbon::now();
        $selisihTahun = $tanggalMasuk->diffInYears($tanggalSekarang);
        $user->lama_krja = (int) $selisihTahun;
        $user->save();

        return view('kadiv/detil-pg', ['user' => $user]);
    }

    public function daftarpgKadiv() {
        $user = User::where('role', 'pegawai')->get();
        return view('kadiv/daftar-pg', ['user' => $user]);
    }

    /* public function saveLamaKerja($id, Request $request)
    {
        $employee = User::find($id);
        $employee->lama_krja = $request->input('lama_krja');
        $employee->save();

        return redirect()->back()->with('success', 'Lama kerja berhasil dihitung dan disimpan.');
    } */

    public function userNonaktif($id, Request $Request) {
        $sts = User::find($id);
        $sts->status = $Request->status;
        $sts->save();
        return redirect ('kadiv/daftarpg');
    }

    public function buatAkunKadiv() {
        return view('kadiv/buat-pg');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function registrasiKadiv(Request $Request)
    {
        $tasks = CutiSm::all(); // Ganti Task dengan model Eloquent Anda

        $totalDurationInSeconds = 0;
        foreach ($tasks as $task) {
            $totalDurationInSeconds += $this->durationToSeconds($task->durasi);
        }
        User::create([
            'name' => $Request->name,
            'nip' => $Request->nip,
            'email' => $Request->email,
            'jns_kelamin' => $Request->jns_kelamin,
            'golongan' => $Request->golongan,
            'tgl_lahir' => $Request->tgl_lahir,
            'jabatan' => $Request->jabatan,
            'sisa_ct' => 12,
            'alamat' => $Request->alamat,
            'tgl_msk' => Carbon::now(),
            'password' => Hash::make($Request->password)
        ]);
        return redirect('kadiv/daftarpg');
    }

    //ALASAN PENTING
    public function riwayatAlpen() {
        $srt = CtAlpen::with('user:id,name') // Load related user data including the name
        ->get();
        return view ('kadiv/ct-alpen', ['srt' => $srt]);
    }

    /* public function simpanAlpen(Request $Request) {
        CtAlpen::create([
            'nip' => Auth::user()->nip,
            'nama' => Auth::user()->name,
            'tgl_mul' => $Request->tgl_mul,
            'tgl_sls' => $Request->tgl_sls,
            'alamat' => Auth::user()->alamat,
            'keterangan' => $Request->keterangan
        ]);
        return redirect('kadiv/ctalpen');
    } */

    public function teruskanAlpen ($id, Request $Request) {
        $konf = CtAlpen::find( $id);
        $konf->status = $Request->status;
        $konf->save();
        return redirect ('kadiv/ctalpen');
    }

    public function infoAlpen($id) {
        $srt = CtAlpen::find($id);
        return view('kadiv/infoalpen', ['srt' => $srt]);
    }

    public function printAlpen($id) {
        $print = CtAlpen::find($id);
        return view ('kadiv/printalpen', [
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
        return view ('kadiv/ct-bsr', ['srt' => $srt]);
    }

     /* public function simpanBsr(Request $Request) {
        CtBsr::create([
            'nip' => Auth::user()->nip,
            'nama' => Auth::user()->name,
            'tgl_mul' => $Request->tgl_mul,
            'tgl_sls' => $Request->tgl_sls,
            'alamat' => Auth::user()->alamat,
            'keterangan' => $Request->keterangan
        ]);
        return redirect('kadiv/ctbsr');
    } */

    public function teruskanBsr ($id, Request $Request) {
        $konf = CtBsr::find( $id);
        $konf->status = $Request->status;
        $konf->save();
        return redirect ('kadiv/ctbsr');
    }

    public function infoBsr($id) {
        $srt = CtBsr::find($id);
        return view('kadiv/infobsr', ['srt' => $srt]);
    }

    public function printBsr($id) {
        $print = CtBsr::find($id);
        return view ('kadiv/printbsr', [
            'nama' => $print->user->nama,
            'nip' => $print->user->nip,
            'golongan' => $print->user->golongan,
            'jabatan' => $print->user->jabatan,
            'durasi' => $print->durasi,
            'tgl_mulai' => $print->tgl_mulai,
            'tgl_sls' => $print->tgl_sls,
            'alamat' => $print->alamat,
            'keterangan' => $print->keterangan,
            'tgl_pgjn' => $print->tgl_pgjn = date('y-m-d')
        ]);
    }

    //CUTI TAHUNAN
    public function riwayatThn() {
        $srt = CtThn::all();
        return view ('kadiv/ct-thn', ['srt' => $srt]);
    }

    /* public function simpanThn(Request $Request) {
        CtThn::create([
            'nip' => Auth::user()->nip,
            'nama' => Auth::user()->name,
            'tgl_mul' => $Request->tgl_mul,
            'tgl_sls' => $Request->tgl_sls,
            'tahun' => $Request->tahun,
            'alamat' => Auth::user()->alamat,
            'keterangan' => $Request->keterangan
        ]);
        return redirect('kadiv/ctthn');
    } */

    public function teruskanThn ($id, Request $Request) {
        $konf = CtThn::find( $id);
        $konf->status = $Request->status;
        $konf->save();
        return redirect ('kadiv/ctthn');
    }

    public function infoThn($id) {
        $srt = CtThn::find($id);
        return view('kadiv/infothn', ['srt' => $srt]);
    }

    public function printThn($id) {
        $print = CtThn::find($id);
        return view ('kadiv/printthn', [
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
        return view ('kadiv/ct-dtn', ['srt' => $srt]);
    }

    /* public function simpanDtn(Request $Request) {
        CtDtn::create([
            'nip' => Auth::user()->nip,
            'nama' => Auth::user()->name,
            'tgl_mul' => $Request->tgl_mul,
            'tgl_sls' => $Request->tgl_sls,
            'tahun' => $Request->tahun,
            'alamat' => Auth::user()->alamat,
            'keterangan' => $Request->keterangan
        ]);
        return redirect('kadiv/ctdtn');
    } */

    public function teruskanDtn ($id, Request $Request) {
        $konf = CtDtn::find( $id);
        $konf->status = $Request->status;
        $konf->save();
        return redirect ('kadiv/ctdtn');
    }

    public function infoDtn($id) {
        $srt = CtDtn::find($id);
        return view('kadiv/infodtn', ['srt' => $srt]);
    }

    public function printDtn($id) {
        $print = CtDtn::find($id);
        return view ('kadiv/printdtn', [
            'nama' => $print->user->nama,
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
        return view ('kadiv/ct-skt', ['srt' => $srt]);
    }

    /* public function simpanSkt(Request $Request) {
        CtSkt::create([
            'nip' => Auth::user()->nip,
            'nama' => Auth::user()->name,
            'tgl_mul' => $Request->tgl_mul,
            'tgl_sls' => $Request->tgl_sls,
            'tahun' => $Request->tahun,
            'alamat' => Auth::user()->alamat,
            'bukti_srt' => $Request->img,
            'keterangan' => $Request->keterangan
        ]);
        return redirect('kadiv/ctskt');
    } */

    public function teruskanSkt ($id, Request $Request) {
        $konf = CtSkt::find( $id);
        $konf->status = $Request->status;
        $konf->save();
        return redirect ('kadiv/ctskt');
    }

    public function infoSkt($id) {
        $srt = CtSkt::find($id);
        return view('kadiv/infoskt', ['srt' => $srt]);
    }

    public function printSkt($id) {
        $print = CtSkt::find($id);
        return view ('kadiv/printskt', [
            'nama' => $print->user->nama,
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
        return view ('kadiv/ct-sln', ['srt' => $srt]);
    }

    /* public function simpanSln(Request $Request) {
        CtSln::create([
            'nip' => Auth::user()->nip,
            'nama' => Auth::user()->name,
            'tgl_mul' => $Request->tgl_mul,
            'tahun' => $Request->tahun,
            'alamat' => Auth::user()->alamat,
            'bukti_srt' => $Request->img,
            'keterangan' => $Request->keterangan
        ]);
        return redirect('kadiv/ctsln');
    } */

    public function teruskanSln ($id, Request $Request) {
        $konf = CtSln::find( $id);
        $konf->status = $Request->status;
        $konf->save();
        return redirect ('kadiv/ctsln');
    }

    public function infoSln($id) {
        $srt = CtSln::find($id);
        return view('kadiv/infosln', ['srt' => $srt]);
    }

    public function printSln($id) {
        $print = CtSln::find($id);
        return view ('kadiv/printsln', [
            'nama' => $print->user->nama,
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
