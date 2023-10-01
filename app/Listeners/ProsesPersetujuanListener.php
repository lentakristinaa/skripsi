<?php

namespace App\Listeners;

use App\Events\ProsesPersetujuanEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\CtAlpen;
use App\Models\CtBsr;
use App\Models\CtThn;
use App\Models\User;

class ProsesPersetujuanListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ProsesPersetujuanEvent $event)
    {
        $userId = $event->userId;

        $ctAlpenTotalDuration = CtAlpen::where('status', 'disetujui')->sum('durasi');
        $ctBsrTotalDuration = CtBsr::where('status', 'disetujui')->sum('durasi');
        $ctHanTotalDuration = CtThn::where('status', 'disetujui')->sum('durasi');

        $totalDurasi = $ctAlpenTotalDuration + $ctBsrTotalDuration + $ctHanTotalDuration;

        $user = User::findOrFail($userId);

        $sisaCuti = $user->sisa_cuti;

        $hasilAkhir = $totalDurasi - $sisaCuti;

        // Simpan hasil akhir ke database atau lakukan tindakan yang diperlukan
        // Misalnya, simpan ke tabel lain atau lakukan update pada user
        $user->update(['sisa_ct' => $hasilAkhir]);
    }
}
