<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\master\Kecamatan;
use App\Models\master\Sekolah;
use App\Models\Kelurahan;
use App\Models\master\Perusahaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController as BaseController;

class HelperController extends BaseController
{
    public function getKecamatan($kotaId)
    {
        $data = Kecamatan::where(['dlt' => 0, 'kotaid' => $kotaId])->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function getSekolah($kecamatanId)
    {
        $data = Sekolah::where(['dlt' => 0, 'kecamatanid' => $kecamatanId])->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function getSekolahJenjang($kecamatanId, $jenjang)
    {
        $data = Sekolah::where(['dlt' => 0, 'kecamatanid' => $kecamatanId, 'jenjang' => $jenjang])->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function getSekolahKotaJenjang1($kotaId, $jenjang)
    {
        $data = DB::table('tbmsekolah')
        ->where('kotaid', $kotaId)
        ->where('jenjang', $jenjang)
        ->where('dlt', 0)
        ->get();

        // dd($data);
        // $data = DB::select(DB::raw("select * from tbmsekolah where kotaid = '$kotaId' and jenjang = '$jenjang'"));
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function getSekolahJenjang2($jenjang)
    {
        $data = Sekolah::where(['dlt' => 0, 'jenjang' => $jenjang])->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function getSekolahJenis($jenis, $jenjang, $kecamatanId)
    {
        $data = Sekolah::where(['dlt' => 0, 'jenjang' => $jenjang, 'kecamatanid' => $kecamatanId,'jenis' => $jenis ])->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function getSekolahKotaJenjangJenis($kotaId, $jenjang, $jenis)
    {
        $data = Sekolah::where(['dlt' => 0, 'jenjang' => $jenjang, 'kotaid' => $kotaId,'jenis' => $jenis ])->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function getSekolahJenis2($jenis)
    {
        $data = Sekolah::where(['dlt' => 0,'jenis' => $jenis ])->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function getSekolahJenisJenjang($jenis, $jenjang)
    {
        $data = Sekolah::where(['dlt' => 0, 'jenjang' => $jenjang,'jenis' => $jenis ])->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function getSekolahJenisKota($jenis,$kotaId)
    {
        $data = Sekolah::where(['dlt' => 0, 'kotaid' => $kotaId, 'jenis' => $jenis ])->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function getSekolahJenisKecamatan($jenis,$kecamatanId)
    {
        $data = Sekolah::where(['dlt' => 0, 'kecamatanid' => $kecamatanId,'jenis' => $jenis ])->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function getSekolahKota($kotaid)
    {
        $data = Sekolah::where(['dlt' => 0,'kotaid' => $kotaid ])->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // public function getSekolahByKotaJenisJenjangKecamatan($kotaid, $jenis, $jenjang, $kecamatanid)
    // {
    //     $data = Sekolah::where(function($query) use($kotaid, $jenis, $jenjang, $kecamatanid){
    //         if(!is_null($kotaid) && $kotaid != '') $query->where('kotaid', $kotaid);
    //         if(!is_null($jenis) && $jenis != '') $query->where('jenis', $jenis);
    //         if(!is_null($jenjang) && $jenjang != '') $query->where('jenjang', $jenjang);
    //         if(!is_null($kecamatanid) && $kecamatanid != '') $query->where('kecamatanid', $kecamatanid);
    //     })->get();

    //     $data = DB::table('tbmsekolah')->select('tbmsekolah.*')
    //                                     ->where(function($query) use($kotaid, $jenis, $jenjang, $kecamatanid){
    //                                         if(!is_null($kotaid) && $kotaid != '') $query->where('kotaid', $kotaid);
    //                                         if(!is_null($jenis) && $jenis != '') $query->where('jenis', $jenis);
    //                                         if(!is_null($jenjang) && $jenjang != '') $query->where('jenjang', $jenjang);
    //                                         if(!is_null($kecamatanid) && $kecamatanid != '') $query->where('kecamatanid', $kecamatanid);
    //                                     })->get();

    //     // dd($data);
                                

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $data
    //     ]);
    // }

    public function getSekolahByKotaJenisJenjangKecamatan(Request $request)
    {

        if ($request->ajax()) {

            $kotaid = $request->kotaid;
            $jenis = $request->jenis;
            $jenjang = $request->jenjang;
            $kecamatanid = $request->kecamatanid;

            try 
            {
                $data = DB::table('tbmsekolah')->select('tbmsekolah.*')
                    ->where(function($query) use($kotaid, $kecamatanid, $jenis, $jenjang){
                        if(!is_null($kotaid) && $kotaid != '') $query->where('tbmsekolah.kotaid', $kotaid);
                        if(!is_null($kecamatanid) && $kecamatanid != '') $query->where('tbmsekolah.kecamatanid', $kecamatanid);
                        if(!is_null($jenis) && $jenis != '') $query->where('tbmsekolah.jenis', $jenis);
                        if(!is_null($jenjang) && $jenjang != '') $query->where('tbmsekolah.jenjang', $jenjang);
                    })
                    ->get()
                ;

                // dd($data);               

                return $this->sendResponse([
                    'status' => 'success',
                    'data' => $data
                ], 200);

            } catch (QueryException $e) {
                return $this->sendError('SQL Error', $this->getQueryError($e));
            }
            catch (Exception $e) {
                return $this->sendError('Error', $e->getMessage());
            }
        }
    }

    public function getAllPerusahaan()
    {
        $data = Perusahaan::where('dlt', 0)->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function bacaTerbilang($x, $style=4) {
        if($x<0) {
            $hasil = "minus ". trim($this->kata($x));
        }elseif($x===0) {
            $hasil="nol";
        }else {
            $hasil = trim($this->kata($x));
        }      
        switch ($style) {
            case 1:
                $hasil = strtoupper($hasil);
                break;
            case 2:
                $hasil = strtolower($hasil);
                break;
            case 3:
                $hasil = ucwords($hasil);
                break;
            default:
                $hasil = ucfirst($hasil);
                break;
        }    
        return ($hasil==""?"":$hasil." Rupiah");
    }

}
