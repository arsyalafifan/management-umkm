<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

Use Session;
Use Config;
use App\enumVar as enum;

class LoginController extends Controller
{

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
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    //     // $this->page = '';
    //     //$this->middleware('guest:executive')->except('logout');
    // }

    public function username(){
        return 'login';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        //$this->middleware('guest:executive')->except('logout');
    }

    public function showLoginForm()
    {
        $tahun = [];
        return view('auth.login', ['tahun' => $tahun]);
    }

    protected function validateLogin(Request $request)
    {
        // Get the user details from database and check if user is exist and active.
        $users = DB::table('tbmuser')->where('login', $request->login)->where('dlt', 0)->get();
        foreach($users as $user) {
            if(!$user->isaktif){
                Log::channel('mibedil')->error('MIBEDIL - Username tidak aktif');
                throw ValidationException::withMessages([$this->username() => __('Username yang anda masukkan tidak aktif untuk saat ini.')]);
            }
        }
        
        return $request->validate(
            [
                $this->username() => 'required|string',
                'password' => 'required|string',
            ]
        );
            
            
        // dd($users);
        // $credentials = $request->validate([
        //     'login' => 'required|string',
        //     'password' => 'required',
        // ]);

        // // $credentials = $request->only($this->username(), 'password');
        // if (Auth::attempt($credentials)) {
        //     // $this->sendLoginResponse($request);
        //     // return redirect()->intended('sarpras-dashboard')->withSuccess('Signed in');
        //     Log::channel('mibedil')->info('Login Berhasil');
        //     return redirect()->route('sarpras-dashboard');
        // }

        // return redirect()->route('sarpras-dashboard');

        // return redirect("login")->withSuccess('Login details are not valid');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */

    protected function sendLoginResponse(Request $request)
    {
        Log::channel('mibedil')->info('Login berhasil', ['userid' => Auth::user()->userid, 'username' => Auth::user()->login]);
        // $this->removeAttemptLogin();
        // $wilayahid = Cookie::get('wilayahid');
        
        $request->session()->regenerate();

        // $request->session()->put('thang', $request->thang);

        $userdata = DB::table('tbmuser')
                ->select('tbmuser.userid', 'tbmakses.aksesid', 'tbmakses.grup')
                ->join('tbmakses', function($join){
                    $join->on('tbmakses.aksesid', '=', 'tbmuser.aksesid');
                })
                // ->leftJoin('tbmgrupakses', function($join){
                //     $join->on('tbmgrupakses.grupaksesid', '=', 'tbmakses.grup');
                // })
                ->where('tbmuser.userid', '=', DB::raw("'".Auth::user()->userid."'"))
                ->first()
        ;

        if ($userdata !== null && $userdata->grup == enum::USER_SUPERADMIN) {
            $akses = DB::table('tbmmenu')
                    ->select(DB::raw("(case(tbmmenu.jenis) 
                                when ".Config::get('constants.jenismenu.jenismenu_master')." then '".Config::get('constants.jenismenunama.jenismenunama_master')."'
                                when ".Config::get('constants.jenismenu.jenismenu_sarpras')." then '".Config::get('constants.jenismenunama.jenismenunama_sarpras')."'
                                when ".Config::get('constants.jenismenu.jenismenu_utilitas')." then '".Config::get('constants.jenismenunama.jenismenunama_utilitas')."'
                                when ".Config::get('constants.jenismenu.jenismenu_verifikasi')." then '".Config::get('constants.jenismenunama.jenismenunama_verifikasi')."'
                                when ".Config::get('constants.jenismenu.jenismenu_perencanaan_sarpras')." then '".Config::get('constants.jenismenunama.jenismenunama_perencanaan_sarpras')."'
                                when ".Config::get('constants.jenismenu.jenismenu_transaksi')." then '".Config::get('constants.jenismenunama.jenismenunama_transaksi')."'
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
        else
        {
            $akses = DB::table('tbmmenu')
                    ->select(DB::raw("(case(tbmmenu.jenis) 
                                when ".Config::get('constants.jenismenu.jenismenu_master')." then '".Config::get('constants.jenismenunama.jenismenunama_master')."'
                                when ".Config::get('constants.jenismenu.jenismenu_sarpras')." then '".Config::get('constants.jenismenunama.jenismenunama_sarpras')."'
                                when ".Config::get('constants.jenismenu.jenismenu_utilitas')." then '".Config::get('constants.jenismenunama.jenismenunama_utilitas')."'
                                when ".Config::get('constants.jenismenu.jenismenu_verifikasi')." then '".Config::get('constants.jenismenunama.jenismenunama_verifikasi')."'
                                when ".Config::get('constants.jenismenu.jenismenu_perencanaan_sarpras')." then '".Config::get('constants.jenismenunama.jenismenunama_perencanaan_sarpras')."'
                                when ".Config::get('constants.jenismenu.jenismenu_transaksi')." then '".Config::get('constants.jenismenunama.jenismenunama_transaksi')."'
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

        $request->session()->put('akses', $akses);

        $user = Auth::user();
        $token = $user->createToken('mibedil')->plainTextToken;
        Session::put('tokenLogin', $token);
        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson() ? new JsonResponse([], 204) : redirect()->intended($this->redirectPath());

    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages(
            [
                'Username dan atau password yang anda masukkan tidak valid.'
            ]
        );
        // return response([
        //     'success' => false,
        //     'data'    => 'Login Failed',
        //     'message' => 'Username dan atau password yang anda masukkan tidak valid!',
        // ], 404);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        //$request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect('/login');
        // Auth::logout();
        // return redirect('/login');
    }

    // protected function setAttemptLogin($option = 0) {
    //     $attemptslogin = 1;
    //     if ($option == 0) {
    //         if (Session::has('attempts-login') && intval(Session::get('attempts-login')) < 6) {
    //             $attemptslogin = intval(Session::get('attempts-login')) + 1;
    //             if ($attemptslogin >= 6) {
    //                 $this->setNextLogin();
    //             }
    //         }
    //         Session::put('attempts-login', $attemptslogin);
    //     }
    //     elseif ($option == 1) {
    //         if (Session::has('attempts-login-executive') && intval(Session::get('attempts-login-executive')) < 6) {
    //             $attemptslogin = intval(Session::get('attempts-login-executive')) + 1;
    //             if ($attemptslogin >= 6) {
    //                 $this->setNextLogin();
    //             }
    //         }
    //         Session::put('attempts-login-executive', $attemptslogin);
    //     }
    // }

    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['dlt' => '0']);
    }

}
