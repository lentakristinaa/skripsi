<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function login(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(auth()->attempt(['email'=>$input["email"], 'password'=>$input["password"]]))
        {
            if(Auth()->user()->role == 'pegawai')
            {
                return redirect()->route('pegawai.dashboard');
            }
            elseif (Auth()->user()->role == 'kadiv')
            {
                return redirect()->route('kadiv.dashboard');
            }
            elseif (Auth()->user()->role == 'pimpinan')
            {
                return redirect()->route('pimpinan.dashboard');
            }
        }
        else {
            return redirect()
            ->route('login')->with('error', 'email atau password anda salah');
        }
    }
}
