<?php

namespace App\Http\Controllers\master;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Hash;
use App\enumVar as enum;
use App\Models\User;

class UserController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->page = 'Pengguna';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->authorize('view-16');

        Log::channel('disnaker')->info('Halaman '.$this->page);
        $user = [];
        $sekolah = [];
        $kotaid = [];
        $kecamatan = [];


        if($request->ajax())
        {    
            $search = $request->search;
            $data = [];
            $count = 0;
            $page = $request->get('start', 0);  
            $perpage = $request->get('length',50);        
            try {
                $user = DB::table('tbuser')
                        ->leftJoin('tbmakses', function($join)
                        {
                            $join->on('tbmakses.aksesid', '=', 'tbuser.aksesid');
                            $join->on('tbmakses.dlt','=',DB::raw("'0'"));
                        })
                        ->select('tbuser.*', 'tbmakses.aksesnama')
                        ->where('tbuser.dlt', '0')
                        ->where(function($query) use ($search)
                        {
                            if (!is_null($search) && $search!='') {
                                $query->where(DB::raw('tbuser.nama'), 'ilike', '%'.$search.'%');
                            }
                        })
                        ->orderBy('tbuser.grup');

                $count = $user->count();
                $data = $user->skip($page)->take($perpage)->get();
            }
            catch (QueryException $e) {
                return $this->sendError('SQL Error', $this->getQueryError($e));
            }
            catch (Exception $e) {
                return $this->sendError('Error', $e->getMessage());
            }

            return $this->sendResponse([
                'data' => $data,
                'count' => $count
            ], 'User retrieved successfully.');  
        }

        $akses = DB::table('tbmakses')
        ->select('tbmakses.aksesid', 'tbmakses.akseskode', 'tbmakses.aksesnama', 'tbmakses.grup')
        ->where('tbmakses.dlt', DB::raw("'0'"))
        ->where('tbmakses.status', DB::raw("'1'"))
        ->orderBy('tbmakses.aksesnama')
        ->get();

        // $kota = DB::table('tbmkota')
        // ->select('tbmkota.kotaid', 'tbmkota.kodekota', 'tbmkota.namakota')
        // ->where('tbmkota.dlt', 0)
        // ->orderBy('tbmkota.kodekota')
        // ->get();

        // $kecamatan = DB::table('tbmkecamatan')
        // ->select('tbmkecamatan.kecamatanid', 'tbmkecamatan.kodekec', 'tbmkecamatan.namakec')
        // ->where('tbmkecamatan.dlt', 0)
        // ->orderBy('tbmkecamatan.kodekec')
        // ->get();



        return view(
            'utility.user.index', 
            [
                'page' => $this->page, 
                'createbutton' => true, 
                'createurl' => route('user.create'), 
                'user' => $user, 
                // 'kota' => $kota, 
                // 'kecamatan' => $kecamatan,
                'akses' => $akses
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('add-16');

        Log::channel('disnaker')->info('Halaman Tambah '.$this->page);

        $sekolah = DB::table('tbmsekolah')
        ->select('tbmsekolah.sekolahid', 'tbmsekolah.npsn', 'tbmsekolah.namasekolah')
        ->where('tbmsekolah.dlt', 0)
        ->orderBy('tbmsekolah.npsn')
        ->get();

        $perusahaan = DB::table('tbmperusahaan')
        ->select('tbmperusahaan.perusahaanid', 'tbmperusahaan.nama')
        ->where('tbmperusahaan.dlt', 0)
        ->orderBy('tbmperusahaan.nama')
        ->get();

        $akses = DB::table('tbmakses')
        ->select('tbmakses.aksesid', 'tbmakses.akseskode', 'tbmakses.aksesnama', 'tbmakses.grup')
        ->where('tbmakses.dlt', DB::raw("'0'"))
        ->where('tbmakses.status', DB::raw("'1'"))
        ->orderBy('tbmakses.aksesnama')
        ->get();

        $aksesmenu = DB::table('tbmaksesmenu')
        ->join('tbmakses', function($join)
        {
            $join->on('tbmakses.aksesid', '=', 'tbmaksesmenu.aksesid');
            $join->on('tbmakses.dlt','=',DB::raw("'0'"));
        })
        ->join('tbmmenu', function($join)
        {
            $join->on('tbmmenu.menuid', '=', 'tbmaksesmenu.menuid');
        })
        ->select('tbmaksesmenu.aksesmenuid', 'tbmaksesmenu.aksesid', 'tbmaksesmenu.menuid', 'tbmaksesmenu.lihat', 'tbmaksesmenu.tambah', 'tbmaksesmenu.ubah', 'tbmaksesmenu.hapus', 'tbmaksesmenu.cetak')
        ->addSelect('tbmmenu.parent', 'tbmmenu.menu')
        ->addSelect(DB::raw('CASE WHEN tbmmenu.jenis='.enum::JENISMENU_MASTER.' THEN \''.enum::JENISMENUNAMA_MASTER.'\' WHEN tbmmenu.jenis='.enum::JENISMENU_SARPRAS.' THEN \''.enum::JENISMENUNAMA_SARPRAS.'\' WHEN tbmmenu.jenis='.enum::JENISMENU_UTILITAS.' THEN \''.enum::JENISMENUNAMA_UTILITAS.'\' WHEN tbmmenu.jenis='.enum::JENISMENU_VERIFIKASI.' THEN \''.enum::JENISMENUNAMA_VERIFIKASI.'\' ELSE \'\' END AS jenis'))
        ->where('tbmakses.dlt', DB::raw("'0'"))
        ->where('tbmakses.status', DB::raw("'1'"))
        ->where('tbmmenu.ishide', DB::raw("'0'"))
        ->orderBy('tbmakses.aksesnama')
        ->orderBy('tbmmenu.jenis')
        ->orderBy('tbmmenu.urutan')
        ->get();

        $user = new User;

        return view(
            'utility.user.form',             
            [
                'page' => $this->page, 
                'child' => 'Tambah Data', 
                'masterurl' => route('user.index'), 
                'sekolah' => $sekolah,
                'perusahaan' => $perusahaan, 
                'user' => $user, 
                'akses' => $akses, 
                'aksesmenu' => $aksesmenu, 
                'isshow' => false
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('add-16');

        $input = $request->all();

        try {
            $user = auth('sanctum')->user();

            $model = new User;

            DB::beginTransaction();

            $model->aksesid = $request->aksesid;
            $model->grup = $request->grup;
            $model->sekolahid = ($request->grup==enum::USER_SEKOLAH ? $request->sekolahid : null);
            $model->perusahaanid = ($request->grup==enum::USER_PERUSAHAAN ? $request->perusahaanid : null);
            $model->nama = $request->nama;
            $model->login = $request->login;
            $model->password = Hash::make($request->password);
            $model->isaktif = $request->isaktif;
            // $model->createdby = 1;//inputed enum

            $model->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);

            $model->save();

            DB::commit();

            return redirect()->route('user.index')
            ->with('success', 'Data berhasil ditambah.', ['page' => $this->page]);
        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view-16');

        Log::channel('mibedil')->info('Halaman Lihat '.$this->page, ['id' => $id]);

        $user = User::where('userid', $id)->firstOrFail();

        $sekolah = DB::table('tbmsekolah')
        ->select('tbmsekolah.sekolahid', 'tbmsekolah.npsn', 'tbmsekolah.namasekolah')
        ->where('tbmsekolah.dlt', 0)
        ->orderBy('tbmsekolah.npsn')
        ->get();

        $perusahaan = DB::table('tbmperusahaan')
        ->select('tbmperusahaan.perusahaanid', 'tbmperusahaan.nama')
        ->where('tbmperusahaan.dlt', 0)
        ->orderBy('tbmperusahaan.nama')
        ->get();

        $akses = DB::table('tbmakses')
        ->select('tbmakses.aksesid', 'tbmakses.akseskode', 'tbmakses.aksesnama', 'tbmakses.grup')
        ->where('tbmakses.dlt', DB::raw("'0'"))
        ->where('tbmakses.status', DB::raw("'1'"))
        ->orderBy('tbmakses.aksesnama')
        ->get();

        $aksesmenu = DB::table('tbmaksesmenu')
        ->join('tbmakses', function($join)
        {
            $join->on('tbmakses.aksesid', '=', 'tbmaksesmenu.aksesid');
            $join->on('tbmakses.dlt','=',DB::raw("'0'"));
        })
        ->join('tbmmenu', function($join)
        {
            $join->on('tbmmenu.menuid', '=', 'tbmaksesmenu.menuid');
        })
        ->select('tbmaksesmenu.aksesmenuid', 'tbmaksesmenu.aksesid', 'tbmaksesmenu.menuid', 'tbmaksesmenu.lihat', 'tbmaksesmenu.tambah', 'tbmaksesmenu.ubah', 'tbmaksesmenu.hapus', 'tbmaksesmenu.cetak')
        ->addSelect('tbmmenu.parent', 'tbmmenu.menu')
        ->addSelect(DB::raw('CASE WHEN tbmmenu.jenis='.enum::JENISMENU_MASTER.' THEN \''.enum::JENISMENUNAMA_MASTER.'\' WHEN tbmmenu.jenis='.enum::JENISMENU_SARPRAS.' THEN \''.enum::JENISMENUNAMA_SARPRAS.'\' WHEN tbmmenu.jenis='.enum::JENISMENU_UTILITAS.' THEN \''.enum::JENISMENUNAMA_UTILITAS.'\' WHEN tbmmenu.jenis='.enum::JENISMENU_VERIFIKASI.' THEN \''.enum::JENISMENUNAMA_VERIFIKASI.'\' WHEN tbmmenu.jenis='.enum::JENISMENU_LAPORAN.' THEN \''.enum::JENISMENUNAMA_LAPORAN.'\' ELSE \'\' END AS jenis'))
        ->where('tbmakses.dlt', DB::raw("'0'"))
        ->where('tbmakses.status', DB::raw("'1'"))
        ->where('tbmmenu.ishide', DB::raw("'0'"))
        ->orderBy('tbmakses.aksesnama')
        ->orderBy('tbmmenu.jenis')
        ->orderBy('tbmmenu.urutan')
        ->get();

        return view(
            'utility.user.form', 
            [
                'page' => $this->page, 
                'child' => 'Lihat Data', 
                'masterurl' => route('user.index'), 
                'sekolah' => $sekolah,
                'perusahaan' => $perusahaan,
                'user' => $user, 
                'akses' => $akses, 
                'aksesmenu' => $aksesmenu, 
                'isshow' => true
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('edit-16');

        Log::channel('mibedil')->info('Halaman Ubah '.$this->page, ['id' => $id]);

        $user = User::where('userid', $id)->firstOrFail();

        $sekolah = DB::table('tbmsekolah')
        ->select('tbmsekolah.sekolahid', 'tbmsekolah.npsn', 'tbmsekolah.namasekolah')
        ->where('tbmsekolah.dlt', 0)
        ->orderBy('tbmsekolah.npsn')
        ->get();

        $perusahaan = DB::table('tbmperusahaan')
        ->select('tbmperusahaan.perusahaanid', 'tbmperusahaan.nama')
        ->where('tbmperusahaan.dlt', 0)
        ->orderBy('tbmperusahaan.nama')
        ->get();
        
        $akses = DB::table('tbmakses')
        ->select('tbmakses.aksesid', 'tbmakses.akseskode', 'tbmakses.aksesnama', 'tbmakses.grup')
        ->where('tbmakses.dlt', DB::raw("'0'"))
        ->where('tbmakses.status', DB::raw("'1'"))
        ->orderBy('tbmakses.aksesnama')
        ->get();

        $aksesmenu = DB::table('tbmaksesmenu')
        ->join('tbmakses', function($join)
        {
            $join->on('tbmakses.aksesid', '=', 'tbmaksesmenu.aksesid');
            $join->on('tbmakses.dlt','=',DB::raw("'0'"));
        })
        ->join('tbmmenu', function($join)
        {
            $join->on('tbmmenu.menuid', '=', 'tbmaksesmenu.menuid');
        })
        ->select('tbmaksesmenu.aksesmenuid', 'tbmaksesmenu.aksesid', 'tbmaksesmenu.menuid', 'tbmaksesmenu.lihat', 'tbmaksesmenu.tambah', 'tbmaksesmenu.ubah', 'tbmaksesmenu.hapus', 'tbmaksesmenu.cetak')
        ->addSelect('tbmmenu.parent', 'tbmmenu.menu')
        ->addSelect(DB::raw('CASE WHEN tbmmenu.jenis='.enum::JENISMENU_MASTER.' THEN \''.enum::JENISMENUNAMA_MASTER.'\' WHEN tbmmenu.jenis='.enum::JENISMENU_SARPRAS.' THEN \''.enum::JENISMENUNAMA_SARPRAS.'\' WHEN tbmmenu.jenis='.enum::JENISMENU_UTILITAS.' THEN \''.enum::JENISMENUNAMA_UTILITAS.'\' WHEN tbmmenu.jenis='.enum::JENISMENU_VERIFIKASI.' THEN \''.enum::JENISMENUNAMA_VERIFIKASI.'\' WHEN tbmmenu.jenis='.enum::JENISMENU_LAPORAN.' THEN \''.enum::JENISMENUNAMA_LAPORAN.'\' ELSE \'\' END AS jenis'))
        ->where('tbmakses.dlt', DB::raw("'0'"))
        ->where('tbmakses.status', DB::raw("'1'"))
        ->where('tbmmenu.ishide', DB::raw("'0'"))
        ->orderBy('tbmakses.aksesnama')
        ->orderBy('tbmmenu.jenis')
        ->orderBy('tbmmenu.urutan')
        ->get();

        return view(
            'utility.user.form', 
            [
                'page' => $this->page, 
                'createbutton' => false, 
                'createurl' => route('user.create'), 
                'child' => 'Ubah Data', 
                'masterurl' => route('user.index'), 
                'user' => $user, 
                'sekolah' => $sekolah,
                'perusahaan' => $perusahaan,
                'akses' => $akses, 
                'aksesmenu' => $aksesmenu, 
                'isshow' => false
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit-16');

        $input = $request->all();

        try {
            $user = auth('sanctum')->user();

            $model = User::find($id);

            DB::beginTransaction();

            $model->aksesid = $request->aksesid;
            $model->grup = $request->grup;
            $model->sekolahid = ($request->grup==enum::USER_SEKOLAH ? $request->sekolahid : null);
            $model->nama = $request->nama;
            $model->login = $request->login;
            // $model->password = Hash::make($request->password);
            $model->isaktif = $request->isaktif;
            // $model->createdby = 1;//inputed enum

            $model->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);

            $model->save();

            DB::commit();

            return redirect()->route('user.index')
            ->with('success', 'Data berhasil ditambah.', ['page' => $this->page]);
        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('delete-16');

        $user = auth('sanctum')->user();

        $userModel = User::find($id);

        if ($userModel->isaktif=="1") 
            return response([
                'success' => false,
                'data'    => 'Data tidak bisa dihapus, Non Aktif-kan user terlebih dahulu!'
            ], 200);

        $userModel->dlt = '1';

        $userModel->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

        $userModel->save();

        // Userperusahaan::where('tbuserperusahaan.dlt', '0')
        //         ->where('tbuserperusahaan.userid', $id)
        //         ->update(
        //             ['dlt' => '1', 'opedit' => $user->login, 'pcedit' => $request->ip()]
        //         );

        return response([
            'success' => true,
            'data'    => 'Success',
            'message' => 'User deleted successfully.',
        ], 200);
    }

    public function storeubahpassword(Request $request)
    {
        Log::channel('disnaker')->info('Halaman '.$this->page);

        $user = auth('sanctum')->user();

        $modelUser = User::find($user->userid);

        if(!is_null($modelUser)) {
            $modelUser->password = Hash::make($request->newpassword);
            $modelUser->changepasswordafterlogin = '0';

            $modelUser->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);
            $modelUser->save();

            return redirect()->route('sarpras-dashboard')->with('success', 'Sandi Anda berhasil diubah.');
        }else{
            return redirect()->route('sarpras-dashboard')->with('error', 'User tidak ditemukan !.');
        }
    }

    /**
     * Display Change Password Form
     *
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request)
    {
        $this->page = 'Ubah Password';
        $user = auth('sanctum')->user();

        return view(
            'utility.user.ubahpassword.password', 
            [
                'page' => $this->page, 
                'user' => $user
            ]
        );
    }
}
