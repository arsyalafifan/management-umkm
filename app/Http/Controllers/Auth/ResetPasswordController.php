<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
Use Session;
Use Config;
use App\enumVar as enum;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'max:100',
                'regex:/[a-z]/',
                'regex:/[A-Z]/', 
                'regex:/[0-9]/',
            ],
        ];
    }

    public function validationErrorMessages()
    {
        return [
            'password.regex' => 'Sandi baru Anda kurang aman, tambahkan huruf kapital dan angka (0-9) pada sandi Anda',
       ];
    }

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);

        request()->session()->regenerate();

        Session::put('thang', "");

        $userdata = DB::table('tbmuser')
            ->select('tbmuser.userid', 'tbmakses.aksesid', 'tbmakses.grup')
            ->join('tbmakses', function($join){
                $join->on('tbmakses.aksesid', '=', 'tbmuser.aksesid');
            })
            ->where('tbmuser.userid', '=', DB::raw("'".Auth::user()->userid."'"))
            ->first();

        $akses = [];
        if ($userdata !== null && $userdata->grup == enum::USER_SUPERADMIN) {
            $akses = DB::table('tbmmenu')
                    ->select(DB::raw("(case(tbmmenu.jenis) 
                                when ".Config::get('constants.jenismenu.jenismenu_master')." then '".Config::get('constants.jenismenunama.jenismenunama_master')."'
                                when ".Config::get('constants.jenismenu.jenismenu_informasi_pekerjaan')." then '".Config::get('constants.jenismenunama.jenismenunama_informasi_pekerjaan')."'
                                when ".Config::get('constants.jenismenu.jenismenu_utilitas')." then '".Config::get('constants.jenismenunama.jenismenunama_utilitas')."'
                                when ".Config::get('constants.jenismenu.jenismenu_verifikasi')." then '".Config::get('constants.jenismenunama.jenismenunama_verifikasi')."'
                                when ".Config::get('constants.jenismenu.jenismenu_laporan')." then '".Config::get('constants.jenismenunama.jenismenunama_laporan')."'
                                else '' END) AS ketjenis"), 
                            'tbmmenu.menuid', 'tbmmenu.parent', 'tbmmenu.menu', 'tbmmenu.url', 'tbmmenu.urutan', 'tbmmenu.jenis', 'tbmmenu.ishide'
                            )
                    ->leftJoin('tbmuser', function($join){
                        $join->on('tbmuser.userid', '=', DB::raw("'".Auth::user()->userid."'"));
                    })
                    ->leftJoin('tbmaksesmenu', function($join){
                        $join->on('tbmaksesmenu.menuid', '=', 'tbmmenu.menuid');
                        $join->on('tbmaksesmenu.aksesid', '=', 'tbmuser.aksesid');
                        $join->on('tbmaksesmenu.dlt', '=', DB::raw("'0'"));
                    })
                    ->where('tbmmenu.ishide', '=', DB::raw("'0'"))
                    ->orderBy('tbmmenu.jenis')
                    ->orderBy('tbmmenu.urutan')
                    ->get();
        }
        else {
            $akses = DB::table('tbmmenu')
                    ->select(DB::raw("(case(tbmmenu.jenis) 
                                when ".Config::get('constants.jenismenu.jenismenu_master')." then '".Config::get('constants.jenismenunama.jenismenunama_master')."'
                                when ".Config::get('constants.jenismenu.jenismenu_informasi_pekerjaan')." then '".Config::get('constants.jenismenunama.jenismenunama_informasi_pekerjaan')."'
                                when ".Config::get('constants.jenismenu.jenismenu_utilitas')." then '".Config::get('constants.jenismenunama.jenismenunama_utilitas')."'
                                when ".Config::get('constants.jenismenu.jenismenu_verifikasi')." then '".Config::get('constants.jenismenunama.jenismenunama_verifikasi')."'
                                when ".Config::get('constants.jenismenu.jenismenu_laporan')." then '".Config::get('constants.jenismenunama.jenismenunama_laporan')."'
                                else '' END) AS ketjenis"), 
                            'tbmmenu.menuid', 'tbmmenu.parent', 'tbmmenu.menu', 'tbmmenu.url', 'tbmmenu.urutan', 'tbmmenu.jenis', 'tbmmenu.ishide'
                            )
                    ->join('tbmaksesmenu', function($join){
                        $join->on('tbmaksesmenu.menuid', '=', 'tbmmenu.menuid');
                        $join->on('tbmaksesmenu.dlt', '=', DB::raw("'0'"));
                    })
                    ->join('tbmuser', function($join){
                        $join->on('tbmuser.aksesid', '=', 'tbmaksesmenu.aksesid');
                        $join->on('tbmuser.userid', '=', DB::raw("'".Auth::user()->userid."'"));
                    })
                    ->where('tbmmenu.ishide', '=', DB::raw("'0'"))
                    ->where('tbmaksesmenu.lihat', '=', DB::raw("'1'"))
                    ->orderBy('tbmmenu.jenis')
                    ->orderBy('tbmmenu.urutan')
                    ->get();
        }
        Session::put('akses', $akses);
        Session::put('provid', Auth::user()->provid);
        Session::put('kabkotaid', Auth::user()->kabkotaid);

        $token = $user->createToken('disnaker')->plainTextToken;
        Session::put('tokenLogin', $token);
    }
}
