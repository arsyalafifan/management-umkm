<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\enumVar as enum;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\FileStock;
// use App\Http\Requests\sarpras\SarprasKebutuhan\CreateRequest;
// use App\Http\Requests\sarpras\SarprasKebutuhan\UpdateRequest;
// use App\Models\master\Sekolah;
use App\Models\sarpras\FileSarprasKebutuhan;
use App\Models\sarpras\SarprasKebutuhan;
use App\Models\StockManagement;
// use App\Models\verifikasi\StatusKebutuhanSarpras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StockManagementController extends BaseController
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		$this->page = 'Stock Management';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->authorize('view-13');

        Log::channel('mibedil')->info('Halaman '.$this->page);

        // $sekolahid = null;
        $sekolah = [];
        $kota = [];
        $kecamatan = [];

        if($request->ajax()){
            $search = $request->search;
            // $kotaid = $request->kotaid;
            // $jenis = $request->jenis;
            // $jenjang = $request->jenjang;
            // $kecamatanid = $request->kecamatanid;
            // $sekolahid = Auth::user()->isSekolah() ? auth('sanctum')->user()->sekolahid : $request->sekolahid;

            $data = [];
            $count = 0;
            $page = $request->get('start', 0);  
            $perpage = $request->get('length',50);
            try {
                
                $stok = DB::table('tbstockmanagement')
                    // ->join('tbmsekolah', function($join)
                    // {
                    //     $join->on('tbmsekolah.sekolahid', '=', 'tbstockmanagement.sekolahid');
                    //     $join->on('tbmsekolah.dlt','=',DB::raw("'0'"));
                    // })
                    // ->join('tbmnamasarpras', function($join)
                    // {
                    //     $join->on('tbmnamasarpras.namasarprasid', '=', 'tbstockmanagement.namasarprasid');
                    //     $join->on('tbmnamasarpras.dlt', '=', DB::raw("'0'"));
                    // })
                    ->select('tbstockmanagement.*')
                    ->where('tbstockmanagement.dlt', 0)
                    // ->where(function($query){
                    //     if(Auth::user()->isSekolah()) $query->where('tbmsekolah.sekolahid', auth('sanctum')->user()->sekolahid);
                    // })
                    ->where(function($query) use ($search)
                        {

                            if (!is_null($search) && $search!='') {
                                // $query->where(DB::raw('CONCAT(tbmkota.kodekota, tbmkota.namakota)'), 'ilike', '%'.$search.'%');
                                $query->where(DB::raw('tbstockmanagement.kodestock'), 'ilike', '%'.$search.'%');
                                $query->orWhere(DB::raw('tbstockmanagement.namastock'), 'ilike', '%'.$search.'%');
                                $query->orWhere(DB::raw('tbstockmanagement.jumlah'), 'ilike', '%'.$search.'%');
                                $query->orWhere(DB::raw('tbstockmanagement.harga'), 'ilike', '%'.$search.'%');
                            }
                        })
                    ->orderBy('tbstockmanagement.stockid')
                ;
                $count = $stok->count();
                $data = $stok->skip($page)->take($perpage)->get();

            } catch (QueryException $e) {
                return $this->sendError('SQL Error', $this->getQueryError($e));
            }
            catch (Exception $e) {
                return $this->sendError('Error', $e->getMessage());
            }
            return $this->sendResponse([
                'data' => $data,
                'count' => $count,
            ], 'data retrieved successfully.');  
        }

        return view(
            'stockmanagement.index', 
            [
                'page' => $this->page, 
                'createbutton' => true, 
                'createurl' => route('stockmanagement.create'), 
            ]
        );
    }

    public function getSekolah($kotaid)
    {
        try {
            $sekolah = DB::table('tbmsekolah')
                    ->select('tbmsekolah.sekolahid', 'tbmsekolah.namasekolah')
                    ->where('tbmsekolah.dlt', 0)
                    ->where('tbmsekolah.kotaid', $kotaid)
                    ->orderBy('tbmsekolah.namasekolah')
                    ->get()
                ;
        } catch (QueryException $e) {
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }
        catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }

        return $this->sendResponse($sekolah, 'Sekolah retrieved successfully.');
    }

    public function getNamaSarpras($kategorisarpras)
    {
        try {
            $namasarpras = DB::table('tbmnamasarpras')
                    ->select('tbmnamasarpras.namasarprasid', 'tbmnamasarpras.namasarpras', 'tbmnamasarpras.kategorisarpras')
                    ->where('tbmnamasarpras.dlt', 0)
                    ->where('tbmnamasarpras.kategorisarpras', $kategorisarpras)
                    ->orderBy('tbmnamasarpras.namasarpras')
                    ->get()
                ;
        } catch (QueryException $e) {
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }
        catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }

        return $this->sendResponse($namasarpras, 'Nama sarpras retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // $this->authorize('add-13');
        // if(Auth::user()->isSekolah() && $id != auth('sanctum')->user()->sekolahid && (!is_null($id))) return view('errors.403');


        // if (is_null($id)) {
        //     return redirect()->route('sarpraskebutuhan.index'); 
        // }
        Log::channel('mibedil')->info('Halaman Tambah '.$this->page);

        // $sekolah = Sekolah::where('sekolahid', $id)->firstOrFail();

        return view(
            'stockmanagement.create', 
            [
                'page' => $this->page, 
                'child' => 'Tambah Data', 
                'masterurl' => route('stockmanagement.index'), 
            ]
        );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->authorize('add-13');

        $user = auth('sanctum')->user();

        try{
            // $user = auth('sanctum')->user();
            $model = new StockManagement;

            DB::beginTransaction();

            $model->kodestock = $request->kodestock;
            $model->namastock = $request->namastock;
            $model->jumlah = $request->jumlah;
            $model->harga = $request->harga;

            $model->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);

           //  dd($user->login);
            if ($model->save()) {
                // Save multiple akreditasi data and image
                $files = [];
                $tglnow = date('Y-m-d');

                foreach ($request->file('file') as $key => $value) {

                    $fileName = $tglnow.'_'.rand(1,1000).'_'.$request->file('file')[$key]->getClientOriginalName();   
                    $filePath = $request->file('file')[$key]->storeAs('public/uploaded/stockmanagement', $fileName);  
                    $files = $fileName; 
                    
                    $modelFileStock = new FileStock;
                    $modelFileStock->file = $files;

                    $modelFileStock->stockid = $model->stockid;
                    $modelFileStock->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);
                    $modelFileStock->save();
                }
            }

            // dd($request->all());

            DB::commit();

            return redirect()
               ->route('stockmanagement.index')
               ->with(
                'success', 
                'Data stock berhasil ditambah.', 
                    [
                        'page' => $this->page, 
                    ]
                    );
        }catch(\Throwable $th)
        {
            return response(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // $this->authorize('view-13');

        Log::channel('mibedil')->info('Halaman Ubah '.$this->page, ['id' => $id]);

        $stock = StockManagement::where('stockid', $id)->firstOrFail();

        if ($request->ajax()) {
            $data = [];
            $count = 0;
            $page = $request->get('start', 0);  
            $perpage = $request->get('length',50);

            // data table kondisi sarpras
            try {
                $filestock = FileStock::where('stockid', $id)
                    ->where('dlt', '0')
                    ->orderBy('filestockid')
                ;
                $countFileStock = $filestock->count();
                $filestock = $filestock->skip($page)->take($perpage)->get();
            }catch (QueryException $e) {
                return $this->sendError('SQL Error', $this->getQueryError($e));
            }
            catch (Exception $e) {
                return $this->sendError('Error', $e->getMessage());
            }

            return $this->sendResponse([
                'filestock' => $filestock,
                'countFileStock' => $countFileStock,
            ], 'Data retrieved successfully.'); 
        }

        return view(
            'stockmanagement.show', 
            [
                'page' => $this->page, 
                'child' => 'Tambah Data', 
                'masterurl' => route('stockmanagement.index'), 
                'stock' => $stock,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        Log::channel('mibedil')->info('Halaman Ubah '.$this->page, ['id' => $id]);

        $stock = StockManagement::where('stockid', $id)->firstOrFail();

        return view('stockmanagement.edit', 
                    [
                        'page' => $this->page, 'createbutton' => true, 'createurl' => route('stockmanagement.create'), 'child' => 'Ubah Data', 'masterurl' => route('stockmanagement.index'), 'stock' => $stock
                    ]);
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
        $user = auth('sanctum')->user();

        try{
            // $user = auth('sanctum')->user();
            $model = StockManagement::find($id);

            DB::beginTransaction();

            $model->kodestock = $request->kodestock;
            $model->namastock = $request->namastock;
            $model->jumlah = $request->jumlah;
            $model->harga = $request->harga;

            $model->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);

            $model->save();

           //  dd($user->login);
            // if ($model->save()) {
            //     // Save multiple akreditasi data and image
            //     $files = [];
            //     $tglnow = date('Y-m-d');

            //     foreach ($request->file('file') as $key => $value) {

            //         $fileName = $tglnow.'_'.rand(1,1000).'_'.$request->file('file')[$key]->getClientOriginalName();   
            //         $filePath = $request->file('file')[$key]->storeAs('public/uploaded/stockmanagement', $fileName);  
            //         $files = $fileName; 
                    
            //         $modelFileStock = new FileStock;
            //         $modelFileStock->file = $files;

            //         $modelFileStock->stockid = $model->stockid;
            //         $modelFileStock->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);
            //         $modelFileStock->save();
            //     }
            // }

            // dd($request->all());

            DB::commit();

            return redirect()
               ->route('stockmanagement.index')
               ->with(
                'success', 
                'Data stock berhasil ditambah.', 
                    [
                        'page' => $this->page, 
                    ]
                    );
        }catch(\Throwable $th)
        {
            return response(['error' => $th->getMessage()], 500);
        }
    }

    public function storedetailsarpraskebutuhan(Request $request)
    {
        // $this->authorize('edit-13');

        $user = auth('sanctum')->user();
        $tglnow = date("Y-m-d");

        try {
            DB::beginTransaction();
            $detailSarprasKebutuhan = new FileSarprasKebutuhan;

            $detailSarprasKebutuhan->sarpraskebutuhanid = $request->sarpraskebutuhanid;
            $detailSarprasKebutuhan->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);

            if ($request->hasFile('filesarpraskebutuhan')) {
                $fileName = $tglnow.'_'.rand(1,1000).'_'.$request->file('filesarpraskebutuhan')->getClientOriginalName();   
                $filePath = $request->file('filesarpraskebutuhan')->storeAs('public/uploaded/sarpraskebutuhan', $fileName);   
                $detailSarprasKebutuhan->filesarpraskebutuhan = $fileName;
            }

            $validation = Validator::make($request->all(), [
                'filesarpraskebutuhan' => 'mimes:pdf,jpg,jpeg,png|max:2048'
            ],
            [
                'filesarpraskebutuhan.mimes' => 'Ekstensi file tidak sesuai, silakan upload file dengan ekstensi: JPEG, JPG, PNG',
                'filesarpraskebutuhan.max' => 'Ukuran file maksimal 2MB'
            ]);

            if($validation->fails())
            {
                return response([
                    'errors' => $validation->errors()
                ]);
            };

            $detailSarprasKebutuhan->save();
            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'detail sarpras tersedia added successfully.',
                'detailSarprasTersedia' => $detailSarprasKebutuhan,
            ], 200);

        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }
    }

    public function updatedetailsarpraskebutuhan(Request $request, $id)
    {
        // $this->authorize('edit-13');

        $user = auth('sanctum')->user();
        $tglnow = date("Y-m-d");

        try {
            DB::beginTransaction();
            $detailSarprasKebutuhan = FileSarprasKebutuhan::find($id);

            $detailSarprasKebutuhan->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            if ($request->hasFile('filesarpraskebutuhan')) {

                $fileName = $tglnow.'_'.rand(1,1000).'_'.$request->file('filesarpraskebutuhan')->getClientOriginalName();   
                $filePath = $request->file('filesarpraskebutuhan')->storeAs('public/uploaded/sarpraskebutuhan', $fileName);   
                if($detailSarprasKebutuhan->filesarpraskebutuhan != ''  && $detailSarprasKebutuhan->filesarpraskebutuhan != null){
                    $file_old = public_path().'/storage/uploaded/sarpraskebutuhan/'.$detailSarprasKebutuhan->filesarpraskebutuhan;
                    unlink($file_old);
                }
                $detailSarprasKebutuhan->filesarpraskebutuhan = $fileName;
            }

            $detailSarprasKebutuhan->save();
            DB::commit();

            $validation = Validator::make($request->all(), [
                'filesarpraskebutuhan' => 'mimes:pdf,jpg,jpeg,png|max:2048'
            ],
            [
                'filesarpraskebutuhan.mimes' => 'Ekstensi file tidak sesuai, silakan upload file dengan ekstensi: JPEG, JPG, PNG',
                'filesarpraskebutuhan.max' => 'Ukuran file maksimal 2MB'
            ]);

            if($validation->fails())
            {
                return response([
                    'errors' => $validation->errors()
                ]);
            }
            else
            {
                return response([
                    'success' => true,
                    'data'    => 'Success',
                    'message' => 'detail sarpras tersedia updated successfully.',
                    'detailSarprasTersedia' => $detailSarprasKebutuhan,
                ], 200);
            };

        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }
    }

    public function hapusdetailsarpraskebutuhan(Request $request, $id)
    {
        // $this->authorize('edit-13');

        $user = auth('sanctum')->user();

        try {
            DB::beginTransaction();

            $detailSarprasKebutuhan = FileSarprasKebutuhan::find($id);

            $detailSarprasKebutuhan->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $detailSarprasKebutuhan->dlt = '1';

            if($detailSarprasKebutuhan->filesarpraskebutuhan != ''  && $detailSarprasKebutuhan->filesarpraskebutuhan != null){
                $file_old = public_path().'/storage/uploaded/sarpraskebutuhan/'.$detailSarprasKebutuhan->filesarpraskebutuhan;
                unlink($file_old);
            }
            $detailSarprasKebutuhan->filesarpraskebutuhan = null;

            $detailSarprasKebutuhan->save();
            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'Akreditasi deleted successfully.',
            ], 200);
        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }
    }

    public function downloadfilesarpraskebutuhan($id)
    {
        //  $this->authorize('print-13');

         $detailSarprasKebutuhan = FileSarprasKebutuhan::find($id);
         $filename = $detailSarprasKebutuhan->filesarpraskebutuhan;
 
         $file = public_path().'/storage/uploaded/sarpraskebutuhan/'.$filename;
 
         return response()->download($file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // $this->authorize('delete-13');

        $user = auth('sanctum')->user();

         try {
            DB::beginTransaction();
            
            $stock = StockManagement::find($id);

            $stock->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $stock->dlt = '1';

            $stock->save();

            // if($sarpraskebutuhan->save())
            // {
            //     $detailSarprasKebutuhan = FileSarprasKebutuhan::where('sarpraskebutuhanid', $id);
            //     foreach ($detailSarprasKebutuhan as $detail) {
            //         $detail->dlt = '1';
            //         $detail->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);
            //         $detail->save();
            //     }
            // }

            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'Stock berhasil dihapus.',
            ], 200);

         } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }
    }

    public function getnextno()
    {
        $data = DB::table('tbtranssarpraskebutuhan')
        ->select(DB::raw('max(cast(replace(tbtranssarpraskebutuhan.nopengajuan, \'.\', \'\') as int)) + 1 as nopengajuan'))
        ->where('tbtranssarpraskebutuhan.dlt', '0')
        // ->where('tbmkota.provid', $parentid)
        ->get();
        
        $nopengajuan = 1;
        if ($data[0]->nopengajuan != null) $nopengajuan = $data[0]->nopengajuan;

        $nextno = '1';
        if (isset($nopengajuan)) {
            $nextno = $nopengajuan;
        }
        $nextno = str_pad($nextno, 4, '0', STR_PAD_LEFT);
        $nextno = $nextno . '.';

        return $nextno;
    }

    public function showDetailKebutuhanSarpras(Request $request, $id)
    {
        $this->authorize('view-13');

        $user = auth('sanctum')->user();
        Log::channel('mibedil')->info('Halaman '.$this->page);

        // if ($request->ajax()) {

            $data = [];
            $count = 0;
            $page = $request->get('start', 0);  
            $perpage = $request->get('length',50);

            try {
                $detailsarpraskebutuhan = DB::table('tbtranssarpraskebutuhan')
                    ->join('tbmpegawai', function($join)
                    {
                        $join->on('tbmpegawai.pegawaiid', '=', 'tbtranssarpraskebutuhan.pegawaiid');
                        $join->on('tbmpegawai.dlt','=',DB::raw("'0'"));
                    })
                    ->join('tbmnamasarpras', function($join)
                    {
                        $join->on('tbmnamasarpras.namasarprasid', '=', 'tbtranssarpraskebutuhan.namasarprasid');
                        $join->on('tbmnamasarpras.dlt','=',DB::raw("'0'"));
                    })
                    ->join('tbtransfilesarpraskebutuhan', function($join)
                    {
                        $join->on('tbtransfilesarpraskebutuhan.sarpraskebutuhanid', '=', 'tbtranssarpraskebutuhan.sarpraskebutuhanid');
                        $join->on('tbtransfilesarpraskebutuhan.dlt','=',DB::raw("'0'"));
                    })
                    ->select('tbtranssarpraskebutuhan.*', 'tbtransfilesarpraskebutuhan.*')
                    ->where('tbtranssarpraskebutuhan.sarpraskebutuhanid', $id)
                    ->where('tbtranssarpraskebutuhan.dlt', 0)
                    ->orderBy('tbtranssarpraskebutuhan.sarpraskebutuhanid')
                ;

                // $count = $detailsarpraskebutuhan->count();
                $data = $detailsarpraskebutuhan->get();

            } catch (QueryException $e) {
                return $this->sendError('SQL Error', $this->getQueryError($e));
            }
            catch (Exception $e) {
                return $this->sendError('Error', $e->getMessage());
            }

            return $this->sendResponse([
                'data' => $data,
                'count' => $count,
            ], 'Data retrieved successfully.'); 

        // }
    }

    public function pengajuan(Request $request, $id)
    {
        $this->authorize('edit-13');

        $user = auth('sanctum')->user();

         try {
            DB::beginTransaction();
            
            $sarpraskebutuhan = SarprasKebutuhan::find($id);

            $sarpraskebutuhan->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $sarpraskebutuhan->status = enum::STATUS_KEBUTUHAN_SARPRAS_PENGAJUAN;

            if($sarpraskebutuhan->save())
            {
                $statuskebutuhansarpras = new StatusKebutuhanSarpras;
                $statuskebutuhansarpras->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);
                $statuskebutuhansarpras->sarpraskebutuhanid = $sarpraskebutuhan->sarpraskebutuhanid;
                $statuskebutuhansarpras->status = enum::STATUS_KEBUTUHAN_SARPRAS_PENGAJUAN;
                $statuskebutuhansarpras->tgl = date('Y-m-d');

                $statuskebutuhansarpras->save();
            };

            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'Status data Sarpras Kebutuhan berhasil diubah ke pengajuan.',
            ], 200);

         } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }
    }
}
