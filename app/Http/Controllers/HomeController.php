<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function pegawaiHome()
    {
        return view('home', ['psn' => 'saya pegawai']);
    }

    public function kadivHome()
    {
        return view('home', ['psn' => 'saya kadiv']);
    }

    public function pimpinanHome()
    {
        return view('home', ['psn' => 'saya pimpinan']);
    }
}
