<?php

namespace App\Http\Controllers;

use DateTime;
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
use App\Events\ProsesPersetujuanEvent;
use Illuminate\Support\Facades\Session;

class PegawaiController extends Controller
{
    public function pegawaiDashboard()
    {
        $hitungAlpen = CtAlpen::where('id_user', Auth::user()->id)
        ->where('status', 'disetujui')
        ->sum('durasi');
        $hitungSkt = CtSkt::where('id_user', Auth::user()->id)
        ->where('status', 'disetujui')
        ->sum('durasi');
        $hitungThn = CtThn::where('id_user', Auth::user()->id)
        ->where('status', 'disetujui')
        ->sum('durasi');

        $sisa_ct = 12 - ($hitungAlpen + $hitungSkt + $hitungThn);


       return view('pegawai/dashboard', ['sisa_ct' => $sisa_ct]);
    }

    public function calculateRemainingLeave(Request $request)
    {
        $userId = $request->user()->id; // Get the authenticated user's ID

        // Retrieve the sum of duration from the three tables where status is approved
        $sumDuration = User::where('id', $userId)
            ->with([
                'CtAlpen' => function ($query) {
                    $query->where('status', 'disetujui');
                },
                'CtThn' => function ($query) {
                    $query->where('status', 'disetujui');
                },
                'CtSkt' => function ($query) {
                    $query->where('status', 'disetujui');
                }
            ])
            ->get()
            ->map(function ($user) {
                $sum = 0;
                foreach ($user->CtAlpen as $row) {
                    $sum += $row->durasi;
                }
                foreach ($user->CtThn as $row) {
                    $sum += $row->durasi;
                }
                foreach ($user->CtSkt as $row) {
                    $sum += $row->durasi;
                }
                return $sum;
            })
            ->first();

        // Get the user's remaining leave
        $user = User::find($userId);
        $remainingLeave = $user->sisa_ct;

        // Subtract the sum of duration from remaining leave
        $remainingLeave -= $sumDuration;

        // Update the user's remaining leave
        $user->sisa_ct = $remainingLeave;
        $user->save();
        $sisa_ct = $user->sisa_ct;

        $this->updateStatusForCtAlpen($userId);
        $this->updateStatusForCtThn($userId);
        $this->updateStatusForCtSkt($userId);

        // Redirect back to the page with the updated result
        return redirect()->route('calculate.remaining.leave')->with('sumDuration', $sumDuration)->with('remainingLeave', $remainingLeave);
    }


    private function updateStatusForCtAlpen($userId)
    {
        // Update the status of table1 for the user with ID $userId
        // For example:
        \App\Models\CtAlpen::where('id_user', $userId)->update(['status' => 'selesai']);
    }

    private function updateStatusForCtThn($userId)
    {
        // Update the status of CtThn for the user with ID $userId
        // For example:
        \App\Models\CtThn::where('id_user', $userId)->update(['status' => 'selesai']);
    }

    private function updateStatusForCtSkt($userId)
    {
        // Update the status of CtSkt for the user with ID $userId
        // For example:
        \App\Models\CtSkt::where('id_user', $userId)->update(['status' => 'selesai']);
    }

    public function showCalculationResult(Request $request)
    {
        $sumDuration = $request->session()->get('sumDuration');
        $remainingLeave = $request->session()->get('remainingLeave');


        return view('pegawai/dashboard', compact('sumDuration', 'remainingLeave'));
    }


    //ALASAN PENTING
    public function riwayatAlpen() {
        $srt = CtAlpen::where('id_user', Auth::user()->id)->get();
        return view('pegawai/ct-alpen', ['srt' => $srt
        ]);
    }

    public function simpanAlpen( Request $Request)
    {
        CtAlpen::create([
            'id_user' => Auth::user()->id,
            'tgl_mulai' => $Request->tgl_mulai,
            'tgl_sls' => $Request->tgl_sls,
            'alamat' => $Request->alamat,
            'keterangan' => $Request->keterangan,
            'tgl_pgjn' => date('Y-m-d'),
            'status' => 'pending',
            //menghitung durasi
            $startDate = Carbon::parse($Request->tgl_mulai),
            $endDate = Carbon::parse($Request->tgl_sls),
            $diffInDays = $startDate->diffInDays($endDate)+1,
            'durasi' => $diffInDays
        ]);

        return redirect('pegawai/ctalpen');
    }

    public function infoAlpen($id) {
        $srt = CtAlpen::find($id);
        return view('pegawai/infoalpen', ['srt' => $srt]);
    }

    public function printAlpen($id) {
        $print = CtAlpen::find($id);
        return view ('pegawai/printalpen', [
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
        $srt = CtBsr::where('id_user', Auth::user()->id)->get();
        return view('pegawai/ct-bsr', ['srt' => $srt]);
    }

    public function simpanBsr(Request $Request) {
        CtBsr::create([
            'id_user' => Auth::user()->id,
            'tgl_mulai' => $Request->tgl_mulai,
            'tgl_sls' => $Request->tgl_sls,
            'alamat' => $Request->alamat,
            'keterangan' => $Request->keterangan,
            'tgl_pgjn' => date('y-m-d'),
            'status' => 'pending',
            //menghitung durasi
            $startDate = Carbon::parse($Request->tgl_mulai),
            $endDate = Carbon::parse($Request->tgl_sls),
            $diffInDays = $startDate->diffInDays($endDate),
            'durasi' => $diffInDays
        ]);
        return redirect('pegawai/ctbsr');
    }

    public function printBsr($id) {
        $print = CtBsr::find($id);
        return view ('pegawai/printbsr', [
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

    public function infoBsr($id) {
        $srt = CtBsr::find($id);
        return view('pegawai/infobsr', ['srt' => $srt]);
    }

    //CUTI TAHUNAN
    public function riwayatThn() {
        $srt = CtThn::where('id_user', Auth::user()->id)->get();
        return view('pegawai/ct-thn', ['srt' => $srt]);
    }

    public function simpanThn(Request $Request) {
        CtThn::create([
            'id_user' => Auth::user()->id,
            'tgl_mulai' => $Request->tgl_mulai,
            'tgl_sls' => $Request->tgl_sls,
            'tahun' => $Request->tahun,
            'alamat' => $Request->alamat,
            'tgl_pgjn' => date('y-m-d'),
            'status' => 'pending',
            //menghitung durasi
            $startDate = Carbon::parse($Request->tgl_mulai),
            $endDate = Carbon::parse($Request->tgl_sls),
            $diffInDays = $startDate->diffInDays($endDate),
            'durasi' => $diffInDays
        ]);
        return redirect('pegawai/ctthn');
    }

    public function printThn($id) {
        $print = CtThn::find($id);
        return view ('pegawai/printthn', [
            'nama' => $print->user->nama,
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

    public function infoThn($id) {
        $srt = CtThn::find($id);
        return view('pegawai/infothn', ['srt' => $srt]);
    }

    //DILUAR TANGGUNGAN NEGARA
    public function riwayatDtn() {
        $srt = CtDtn::where('id_user', Auth::user()->id)->get();
        return view('pegawai/ct-dtn', ['srt' => $srt]);
    }

    public function simpanDtn(Request $Request) {
        CtDtn::create([
            'id_user' => Auth::user()->id,
            'tgl_mulai' => $Request->tgl_mulai,
            'tgl_sls' => $Request->tgl_sls,
            'alamat' => $Request->alamat,
            'keterangan' => $Request->keterangan,
            'tgl_pgjn' => date('y-m-d'),
            'status' => 'pending',
            //menghitung durasi
            $startDate = Carbon::parse($Request->tgl_mulai),
            $endDate = Carbon::parse($Request->tgl_sls),
            $diffInDays = $startDate->diffInDays($endDate),
            'durasi' => $diffInDays
        ]);
        return redirect('pegawai/ctdtn');
    }

    public function printDtn($id) {
        $print = CtDtn::find($id);
        return view ('pegawai/printdtn', [
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

    public function infoDtn($id) {
        $srt = CtDtn::find($id);
        return view('pegawai/infodtn', ['srt' => $srt]);
    }

    //CUTI SAKIT
    public function riwayatSkt() {
        $srt = CtSkt::where('id_user', Auth::user()->id)->get();
        return view('pegawai/ct-skt', ['srt' => $srt]);
    }

    public function simpanSkt(Request $Request) {
        CtSkt::create([
            'id_user' => Auth::user()->id,
            'tgl_mulai' => $Request->tgl_mulai,
            'tgl_sls' => $Request->tgl_sls,
            'alamat' => $Request->alamat,
            'foto' => $Request->img,
            'keterangan' => $Request->keterangan,
            'tgl_pgjn' => date('y-m-d'),
            'status' => 'pending',
            //menghitung durasi
            $startDate = Carbon::parse($Request->tgl_mulai),
            $endDate = Carbon::parse($Request->tgl_sls),
            $diffInDays = $startDate->diffInDays($endDate),
            'durasi' => $diffInDays
        ]);
        return redirect('pegawai/ctskt');
    }

    public function printSkt($id) {
        $print = CtSkt::find($id);
        return view ('pegawai/printskt', [
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

    public function infoSkt($id) {
        $srt = CtSkt::find($id);
        return view('pegawai/infoskt', ['srt' => $srt]);
    }

    //CUTI BERSALIN
    public function riwayatSln() {
        $srt = CtSln::where('id_user', Auth::user()->id)->get();
        return view('pegawai/ct-sln', ['srt' => $srt]);
    }

    public function simpanSln(Request $Request) {
        CtSln::create([
            'id_user' => Auth::user()->id,
            'tgl_mulai' => $Request->tgl_mulai,
            'alamat' => $Request->alamat,
            'foto' => $Request->img,
            'keterangan' => $Request->keterangan,
            'tgl_pgjn' => date('y-m-d'),
            'status' => 'pending',
        ]);
        return redirect('pegawai/ctsln');
    }

    public function printSln($id) {
        $print = CtSln::find($id);
        return view ('pegawai/printsln', [
            'nama' => $print->user->namE,
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

    public function infoSlns($id) {
        $srt = CtSln::find($id);
        return view('pegawai/infosln', ['srt' => $srt]);
    }
}
