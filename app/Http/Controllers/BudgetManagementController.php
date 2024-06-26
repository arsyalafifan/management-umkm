<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\enumVar as enum;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\sarpras\SarprasTersedia\DetailPagu\CreateRequest;
use App\Http\Requests\sarpras\SarprasTersedia\DetailPagu\UpdateRequest;
use App\Http\Requests\sarpras\SarprasTersedia\DetailSarpras\CreateRequest as DetailSarprasCreateRequest;
use App\Http\Requests\sarpras\SarprasTersedia\JenisSarpras\CreateRequest as JenisSarprasCreateRequest;
use App\Http\Requests\sarpras\SarprasTersedia\JenisSarpras\UpdateRequest as JenisSarprasUpdateRequest;
use App\Models\Budget;
use App\Models\AlokasiBudget;
use App\Models\master\Sekolah;
use App\Models\Rekening;
use App\Models\sarpras\DetailJumlahSarpras;
use App\Models\sarpras\DetailPaguSarprasTersedia;
use App\Models\sarpras\DetailSarprasTersedia;
use App\Models\sarpras\FileDetailJumlahSarpras;
use App\Models\sarpras\FileSarprasKebutuhan;
use App\Models\sarpras\KondisiSarprasTersedia;
use App\Models\sarpras\SarprasTersedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class BudgetManagementController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		$this->page = 'Budget Management';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Log::channel('management-umkm')->info('Halaman '.$this->page);

        if($request->ajax())
        {
            $search = $request->search;

            $data = [];
            $count = 0;
            $page = $request->get('start', 0);  
            $perpage = $request->get('length',50);

            try {
                $rekening = DB::table('tbrekening')
    
                        ->select('tbrekening.*')
                        ->where('tbrekening.dlt', '0')

                        ->where(function($query) use ($search)
                        {
                            
                            if (!is_null($search) && $search!='') {
                                $query->where(DB::raw('tbrekening.bank'), 'ilike', '%'.$search.'%');
                                $query->orWhere(DB::raw('tbrekening.koderekening'), 'ilike', '%'.$search.'%');
                                $query->orWhere(DB::raw('tbrekening.saldo'), 'ilike', '%'.$search.'%');
                            }
                        })
                        ->orderBy('tbrekening.rekeningid')
                ;

                $count = $rekening->count();
                $data = $rekening->skip($page)->take($perpage)->get();
            } catch (QueryException $e) {
                return $this->sendError('SQL Error', $this->getQueryError($e));
            }
            catch (Exception $e) {
                return $this->sendError('Error', $e->getMessage());
            }
            return $this->sendResponse([
                'data' => $data,
                'count' => $count
            ], 'Rekening retrieved successfully.');  
        }

        return view(
            'budgetmanagement.index', 
            [
                'page' => $this->page, 
                'createbutton' => false, 
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $this->authorize('add-12');
        if(Auth::user()->isSekolah() && $id != auth('sanctum')->user()->sekolahid && (!is_null($id))) return view('errors.403');

        if (is_null($id)) {
            return redirect()->route('sarprastersedia.index'); 
        }
        Log::channel('mibedil')->info('Halaman Tambah '.$this->page);

        $sekolah = Sekolah::where('sekolahid', $id)->firstOrFail();
 
        $namasarpras = DB::table('tbmnamasarpras')
         ->select('tbmnamasarpras.namasarprasid', 'tbmnamasarpras.namasarpras')
         ->where('tbmnamasarpras.dlt', 0)
         ->orderBy('tbmnamasarpras.namasarpras')
         ->get();
 
        return view(
            'sarpras.sarprastersedia.create', 
            [
                'page' => $this->page, 
                'child' => 'Tambah Data', 
                'masterurl' => route('sarprastersedia.index'), 
                'namasarpras' => $namasarpras,
                'sekolah' => $sekolah
            ]
        );
    }

    public function createdetailsarpras(Request $request, $id)
    {
        $this->authorize('add-12');

        if (is_null($id)) {
            return redirect()->route('sarprastersedia.index'); 
        }
        Log::channel('mibedil')->info('Halaman Tambah '.$this->page);

        $sarprastersedia = SarprasTersedia::where('sarprastersediaid', $id)->firstOrFail();

        $subkegiatan = DB::table('tbmsubkeg')
            ->join('tbmkeg', function ($join){
                $join->on('tbmkeg.kegid', '=', 'tbmsubkeg.kegid');
                $join->on('tbmkeg.dlt', '=', DB::raw("'0'"));
            })
            ->join('tbmprog', function ($join){
                $join->on('tbmprog.progid', '=', 'tbmkeg.progid');
                $join->on('tbmprog.dlt', '=', DB::raw("'0'"));
            })
            ->select('tbmsubkeg.*', 'tbmkeg.kegkode', 'tbmprog.progkode')
            ->where('tbmsubkeg.dlt', 0)
            ->get()
        ;

        $koderekening = DB::table('tbmjen')
            ->join('tbmkel', function ($join) {
                $join->on('tbmkel.kelid', '=', 'tbmjen.kelid');
                $join->on('tbmkel.dlt', '=', DB::raw("'0'"));
            })
            ->join('tbmstruk', function($join) {
                $join->on('tbmstruk.strukid', '=', 'tbmkel.strukid');
                $join->on('tbmstruk.dlt', '=', DB::raw("'0'"));
            })
            ->select(
                'tbmjen.jenid',
                'tbmkel.kelid',
                'tbmstruk.strukid',
                'tbmjen.jennama',
                DB::raw('tbmstruk.strukkode || tbmkel.kelkode || tbmjen.jenkode as jenkode')
            )
            ->where('tbmjen.dlt', 0)
            ->get()
        ;

        $perusahaan = DB::table('tbmperusahaan')
            ->select('tbmperusahaan.*')
            ->where('tbmperusahaan.dlt', 0)
            ->get()
        ;

        return view(
            'sarpras.sarprastersedia.detailsarpras.create1', 
            [
                'page' => $this->page, 
                'child' => 'Tambah Data', 
                'masterurl' => route('sarprastersedia.index'), 
                'sarprastersedia' => $sarprastersedia,
                'subkegiatan' => $subkegiatan,
                'koderekening' => $koderekening,
                'perusahaan' => $perusahaan
            ]
        );
    }
    public function createdetailjumlahsarpras(Request $request, $id)
    {
        $this->authorize('add-12');

        if (is_null($id)) {
            return redirect()->route('sarprastersedia.index'); 
        }
        Log::channel('mibedil')->info('Halaman Tambah '.$this->page);

        $detailsarpras = DetailSarprasTersedia::where('detailsarprasid', $id)->firstOrFail();

        if($request->ajax())
        {
            try {
                $data = [];
                $count = 0;
                $page = $request->get('start', 0);  
                $perpage = $request->get('length',50);
    
                $detailjumlahsarpras = DB::table('tbtransdetailjumlahsarpras')
                    // ->join('tbtransfiledetailjumlahsarpras', function($join){
                    //     $join->on('tbtransfiledetailjumlahsarpras.filedetailjumlahsarprasid', '=', 'tbtransdetailjumlahsarpras.detailjumlahsarprasid');
                    //     $join->on('tbtransfiledetailjumlahsarpras.dlt', '=', DB::raw("'0'"));
                    // })
                    ->select('tbtransdetailjumlahsarpras.*')
                    ->where('tbtransdetailjumlahsarpras.detailsarprasid', $id)
                    ->where('tbtransdetailjumlahsarpras.dlt', 0)
                    ->orderBy('tbtransdetailjumlahsarpras.kondisi')
                ;
    
                $count = $detailjumlahsarpras->count();
                $data = $detailjumlahsarpras->skip($page)->take($perpage)->get();
    
                return $this->sendResponse([
                    'data' => $data,
                    'count' => $count
                ], 'detail jumlah sarpras retrieved successfully.'); 
    
            } catch (QueryException $e) {
                return $this->sendError('SQL Error', $this->getQueryError($e));
            }
            catch (Exception $e) {
                return $this->sendError('Error', $e->getMessage());
            } 
        }

        return view(
            'sarpras.sarprastersedia.detailjumlahsarpras.create', 
            [
                'page' => $this->page, 
                'child' => 'Tambah Data', 
                'masterurl' => route('sarprastersedia.index'), 
                'detailsarpras' => $detailsarpras,
            ]
        );
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  $this->authorize('add-12');

         $user = auth('sanctum')->user();

         try{
             $model = new Rekening;
 
             DB::beginTransaction();
 
             $model->bank = $request->bank;
             $model->koderekening = $request->koderekening;
             $model->saldo = str_replace('.', '', $request->saldo);
 
             $model->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);
 
            //  dd($user->login);
            $model->save();
 
             DB::commit();
 
             return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'rekening added successfully.',
            ], 200);
         }catch (QueryException $e) {
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }
        catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }
    public function storeRekening(Request $request)
    {
        //  $this->authorize('add-12');

         $user = auth('sanctum')->user();

         try{
             $model = new Rekening;
 
             DB::beginTransaction();
 
             $model->bank = $request->bank;
             $model->koderekening = $request->koderekening;
             $model->saldo = str_replace('.', '', $request->saldo);
 
             $model->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);
 
            //  dd($user->login);
            $model->save();
 
             DB::commit();
 
             return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'rekening added successfully.',
            ], 200);
         }catch (QueryException $e) {
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }
        catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    public function storeBudget(Request $request, $rekeningid)
    {
        //  $this->authorize('add-12');

         $user = auth('sanctum')->user();

         try{
             $model = new Budget;
 
             DB::beginTransaction();
 
             $model->judul = $request->judul;
             $model->totalbudget = str_replace('.', '', $request->totalbudget);
             $model->terealisasikan = 0;
             $model->tglbudget = $request->tglbudget;
             $model->rekeningid = $rekeningid;
 
             $model->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);
 
            //  dd($user->login);
            $model->save();
 
             DB::commit();
 
             return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'budget added successfully.',
            ], 200);
         }catch (QueryException $e) {
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }
        catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    public function storeAlokasiBudget(Request $request, $budgetid)
    {
        //  $this->authorize('add-12');

         $user = auth('sanctum')->user();

         try{
             $model = new AlokasiBudget;

             $budget = Budget::find($budgetid)->where('dlt', 0)->first();
 
             DB::beginTransaction();
 
             $model->judul = $request->judul_alokasi;

            //  if($budget->totalbudget + $request->alokasibudget > )

             $model->alokasibudget = str_replace('.', '', $request->alokasibudget);
             $model->tglalokasibudget = $request->tglalokasibudget;
             $model->statusrealisasi = '1';
             $model->budgetid = $budgetid;
 
             $model->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);
 
            //  dd($user->login);
            $model->save();
 
             DB::commit();
 
             return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'alokasi budget added successfully.',
            ], 200);
         }catch (QueryException $e) {
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }
        catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    public function storejenissarpras(Request $request)
    {
         $this->authorize('add-12');

         $user = auth('sanctum')->user();

         try{
             $model = new SarprasTersedia;
 
             DB::beginTransaction();
 
             $model->jenissarpras = $request->jenissarpras;
             $model->namasarprasid = $request->namasarprasid;
             $model->jumlahunit = $request->jumlahunit;
             $model->satuan = $request->satuan;
             $model->thang = $request->thang;
             $model->sekolahid = $request->sekolahid;
             $model->jenisperalatanid = $request->jenisperalatanid;
 
             $model->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);
 
            //  dd($user->login);
            $model->save();
 
            DB::commit();
 
            return response([
                'success' => true,
                'data'    => 'success',
                'message' => 'jenis sarpras added successfully.',
            ], 200);
         }catch (QueryException $e) {
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }
        catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }
    

    // public function storedetailsarpras(DetailSarprasCreateRequest $request)
    // {
    //     $this->authorize('add-12');

    //     $user = auth('sanctum')->user();

    //     try {

    //         $model = new DetailSarprasTersedia;

    //         DB::beginTransaction();

    //         $model->subkegid = $request->subkegid;
    //         $model->sumberdana = $request->sumberdana;
    //         $model->sarprastersediaid = $request->sarprastersediaid;
    //         $model->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);

    //         $model->save();

    //         $listdetailpagu = $request->datadetailpagu;
    //         $filedetailpagu = $request->filedetailpagu;
    //         // dd($filedetailpagu);

    //         if(is_array($listdetailpagu) || is_object($listdetailpagu)) {
    //             foreach($listdetailpagu as $key => $dataDetailPagu) {
    //                 $modelDetailPagu = new DetailPaguSarprasTersedia;
    //                 $modelDetailPagu->detailsarprasid = $model->detailsarprasid;
    //                 $modelDetailPagu->jenispagu = $dataDetailPagu[$key]['jenispagu'];
    //                 $modelDetailPagu->nilaipagu = $dataDetailPagu[$key]['nilaipagu'];
    //                 $modelDetailPagu->nokontrak = $dataDetailPagu[$key]['nokontrak'];
    //                 $modelDetailPagu->nilaikontrak = $dataDetailPagu[$key]['nilaikontrak'];
    //                 $modelDetailPagu->perusahaanid = $dataDetailPagu[$key]['perusahaanid'];
    //                 $modelDetailPagu->tgldari = $dataDetailPagu[$key]['tgldari'];
    //                 $modelDetailPagu->tglsampai = $dataDetailPagu[$key]['tglsampai'];
    //                 $modelDetailPagu->file = $dataDetailPagu['file'];

    //                 $modelDetailPagu->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);

    //                 $tglnow = date('Y-m-d');

    //                 if ($request->hasFile('file')) {
    //                     $fileName = $tglnow.'_'.rand(1,1000).'_'.$request->file('file')[$key]->getClientOriginalName();   
    //                     $filePath = $request->file('file')[$key]->storeAs('public/uploaded/sarprastersedia/detailsarpras', $fileName);   
    //                     $modelDetailPagu->file = $fileName;
    //                 }

    //                 $modelDetailPagu->save();

    //             }
    //         }

    //         if($request->hasFile('file')) 
    //         {
    //             foreach ($request->file('file') as $key => $value) {

    //             }
    //         }

    //         DB::commit();

    //         return redirect()->route('sarprastersedia.index')
    //         ->with('success', 'Data detail sarpras berhasil ditambah.', ['page' => $this->page])
    //         ->with(
    //             'oldsekolahid', $request->sekolahid
    //         );

    //     } catch (QueryException $e) {
    //         return $this->sendError('SQL Error', $this->getQueryError($e));
    //     }
    //     catch (Exception $e) {
    //         return $this->sendError('Error', $e->getMessage());
    //     }
    // }
    public function storedetailsarpras(DetailSarprasCreateRequest $request)
    {
        $this->authorize('add-12');

        $user = auth('sanctum')->user();

        try {

            $model = new DetailSarprasTersedia;
 
            DB::beginTransaction();

            $model->thperolehan = $request->thperolehan;
            $model->jenid = $request->koderekening;
            $model->subkegid = $request->subkegid;
            $model->sumberdana = $request->sumberdana;
            $model->subdetailkegiatan = $request->subdetailkeg;
            $model->sarprastersediaid = $request->sarprastersediaid;
            $model->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);

            if($model->save())
            {
                // Save multiple and file 
                $tglnow = date('Y-m-d');

                foreach ($request->jenispagu as $key => $value) {

                    $modelDetailPaguSarpras = new DetailPaguSarprasTersedia;

                    $modelDetailPaguSarpras->jenispagu = $request->jenispagu[$key];
                    $modelDetailPaguSarpras->nilaipagu =str_replace(',', '', $request->nilaipagu[$key]);
                    $modelDetailPaguSarpras->perusahaanid = $request->perusahaanid[$key];
                    $modelDetailPaguSarpras->nokontrak = $request->nokontrak[$key];
                    $modelDetailPaguSarpras->nilaikontrak = str_replace(',', '', $request->nilaikontrak[$key]);
                    $modelDetailPaguSarpras->tgldari = $request->tgldari[$key];
                    $modelDetailPaguSarpras->tglsampai = $request->tglsampai[$key];
                    $modelDetailPaguSarpras->detailsarprasid = $model->detailsarprasid;


                    if ($request->hasFile('file')) {
                        $fileName = $tglnow.'_'.rand(1,1000).'_'.$request->file('file')[$key]->getClientOriginalName();   
                        $filePath = $request->file('file')[$key]->storeAs('public/uploaded/sarprastersedia/detailsarpras', $fileName);   
                        $modelDetailPaguSarpras->file = $fileName;
                    }
                    $modelDetailPaguSarpras->save();
                }
            }

            DB::commit();

            return redirect()->route('sarprastersedia.index')
            ->with('success', 'Data detail sarpras berhasil ditambah.', ['page' => $this->page]);

        } catch (QueryException $e) {
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }
        catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    // store detail pagu while edit detail sarpras tersedia
    public function storedetailpagu(CreateRequest $request)
    {
        $this->authorize('add-12');

        $user = auth('sanctum')->user();
        $tglnow = date('Y-m-d');

        try {
            $model = new DetailPaguSarprasTersedia;
 
            DB::beginTransaction();

            $model->jenispagu = $request->jenispagu;
            $model->nilaipagu = $request->nilaipagu;
            $model->nokontrak = $request->nokontrak;
            $model->nilaikontrak = $request->nilaikontrak;
            $model->perusahaanid = $request->perusahaanid;
            $model->tgldari = $request->tgldari;
            $model->tglsampai = $request->tglsampai;
            $model->detailsarprasid = $request->detailsarprasid;
            $model->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);

            if ($request->hasFile('file')) {
                $fileName = $tglnow.'_'.rand(1,1000).'_'.$request->file('file')->getClientOriginalName();   
                $filePath = $request->file('file')->storeAs('public/uploaded/sarprastersedia/detailsarpras', $fileName);   
                $model->file = $fileName;
            }

            $validation = Validator::make($request->all(), [
                'tgldari' => 'required|date|before:tomorrow'
            ]);

            if($validation->fails())
            {
                return response([
                    'errors' => $validation->errors()
                ]);
            };

            $model->save();

            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'detail pagu updated successfully.',
            ], 200);


        } catch (QueryException $e) {
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }
        catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    public function storedetailjumlahsarpras(Request $request)
    {

        $this->authorize('add-12');

        $user = auth('sanctum')->user();

        try {
            
            $model = new DetailJumlahSarpras;
            
            DB::beginTransaction();

            $model->kondisi = $request->kondisi;
            $model->jumlah = $request->jumlah;
            $model->detailsarprasid = $request->detailsarprasid;
            $model->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);
            // dd($request->all());
            // $model->save();
            if($model->save())
            {
                $tglnow = date('Y-m-d');
                
                if($request->hasFile('file'))
                {
                    foreach ($request->file('file') as $key => $value) {
                    
                        $modelFileDetailJumlahSarpras = new FileDetailJumlahSarpras;
                        $modelFileDetailJumlahSarpras->detailjumlahsarprasid = $model->detailjumlahsarprasid;
                        
                        $fileName = $tglnow.'_'.rand(1,1000).'_'.$request->file('file')[$key]->getClientOriginalName();   
                        $filePath = $request->file('file')[$key]->storeAs('public/uploaded/sarprastersedia/detailjumlahsarpras', $fileName);   
                        $modelFileDetailJumlahSarpras->file = $fileName;
                        $modelFileDetailJumlahSarpras->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);
                        $modelFileDetailJumlahSarpras->save();
                    }

                }
            }

            // dd($request->all());
        
            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'detail jumlah sarpras added successfully.',
                
            ], 200);

        } catch (QueryException $e) {
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }
        catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
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
        //
    }

    public function showdetailpagusarpras(Request $request, $id)
    {

        $this->authorize('view-12');

        $user = auth('sanctum')->user();
        Log::channel('mibedil')->info('Halaman '.$this->page);

        if ($request->ajax()) {

            $data = [];
            $count = 0;
            $page = $request->get('start', 0);  
            $perpage = $request->get('length',50);

            try {
                $detailpagusarprastersedia = DB::table('tbtransdetailpagusarpras')
                    ->join('tbmperusahaan', function($join){
                        $join->on('tbmperusahaan.perusahaanid', '=', 'tbtransdetailpagusarpras.perusahaanid');
                        $join->on('tbmperusahaan.dlt', '=', DB::raw("'0'"));
                    })
                    ->select('tbtransdetailpagusarpras.*', 'tbmperusahaan.nama')
                    ->where('tbtransdetailpagusarpras.detailsarprasid', $id)
                    ->where('tbtransdetailpagusarpras.dlt', 0)
                    ->orderBy('tbtransdetailpagusarpras.jenispagu')
                ;

                $querySum = DB::table('tbtransdetailpagusarpras')
                    ->select(DB::raw('SUM(nilaipagu) as countpagu'), DB::raw('SUM(nilaikontrak) as countkontrak'))
                    ->where('tbtransdetailpagusarpras.detailsarprasid', $id)
                    ->where('tbtransdetailpagusarpras.dlt', 0)
                ;

                $count = $detailpagusarprastersedia->count();
                $data = $detailpagusarprastersedia->skip($page)->take($perpage)->get();
                $sumRupiah = $querySum->get();

            } catch (QueryException $e) {
                return $this->sendError('SQL Error', $this->getQueryError($e));
            }
            catch (Exception $e) {
                return $this->sendError('Error', $e->getMessage());
            }

            return $this->sendResponse([
                'data' => $data,
                'count' => $count,
                'sumPagu' => $sumRupiah,
                'terbilangNilaiPagu' => $this->bacaTerbilang($sumRupiah[0]->countpagu),
                'terbilangNilaiKontrak' => $this->bacaTerbilang($sumRupiah[0]->countkontrak)
            ], 'Data retrieved successfully.'); 

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $this->authorize('edit-12');

        Log::channel('mibedil')->info('Halaman Ubah '.$this->page, ['id' => $id]);

        $sarprastersedia = SarprasTersedia::where('sarprastersediaid', $id)->firstOrFail();

        $kondisisarprastersedia = DB::table('tbtranssarprastersediakondisi')
        ->select('tbtranssarprastersediakondisi.*')
        ->where('tbtranssarprastersediakondisi.sarprastersediaid', $id)
        ->where('tbtranssarprastersediakondisi.dlt', 0)
        ->orderBy('tbtranssarprastersediakondisi.kondisi')
        ->get();

        $namasarpras = DB::table('tbmnamasarpras')
         ->select('tbmnamasarpras.namasarprasid', 'tbmnamasarpras.namasarpras')
         ->where('tbmnamasarpras.dlt', 0)
         ->orderBy('tbmnamasarpras.namasarpras')
         ->get();

         if ($request->ajax()) {
            $data = [];
            $count = 0;
            $page = $request->get('start', 0);  
            $perpage = $request->get('length',50);

            // data table kondisi sarpras
            try {
                $kondisisarprastersedia = KondisiSarprasTersedia::where('sarprastersediaid', $id)
                    ->where('dlt', '0')
                    ->orderBy('kondisi')
                ;
                $countSarprasTersedia = $kondisisarprastersedia->count();
                $kondisisarprastersedia = $kondisisarprastersedia->skip($page)->take($perpage)->get();
            }catch (QueryException $e) {
                return $this->sendError('SQL Error', $this->getQueryError($e));
            }
            catch (Exception $e) {
                return $this->sendError('Error', $e->getMessage());
            }

            return $this->sendResponse([
                'kondisisarprastersedia' => $kondisisarprastersedia,
                'countSarprasTersedia' => $countSarprasTersedia,
            ], 'Data retrieved successfully.'); 
         }

        return view(
            'sarpras.sarprastersedia.edit', 
            [
                'page' => $this->page, 
                'child' => 'Tambah Data', 
                'masterurl' => route('sarprastersedia.index'), 
                'sarprastersedia' => $sarprastersedia,
                'kondisisarprastersedia' => $kondisisarprastersedia,
                'namasarpras' => $namasarpras
            ]
        );
    }

    public function editdetailsarpras(Request $request, $id)
    {

        $this->authorize('edit-12');

        Log::channel('mibedil')->info('Halaman Ubah '.$this->page, ['id' => $id]);

        $detailsarpras = DetailSarprasTersedia::where('detailsarprasid', $id)->firstOrFail();

        $subkegiatan = DB::table('tbmsubkeg')
            ->join('tbmkeg', function ($join){
                $join->on('tbmkeg.kegid', '=', 'tbmsubkeg.kegid');
                $join->on('tbmkeg.dlt', '=', DB::raw("'0'"));
            })
            ->join('tbmprog', function ($join){
                $join->on('tbmprog.progid', '=', 'tbmkeg.progid');
                $join->on('tbmprog.dlt', '=', DB::raw("'0'"));
            })
            ->select('tbmsubkeg.*', 'tbmkeg.kegkode', 'tbmprog.progkode')
            ->where('tbmsubkeg.dlt', 0)
            ->get()
        ;

        $koderekening = DB::table('tbmjen')
            ->join('tbmkel', function ($join) {
                $join->on('tbmkel.kelid', '=', 'tbmjen.kelid');
                $join->on('tbmkel.dlt', '=', DB::raw("'0'"));
            })
            ->join('tbmstruk', function($join) {
                $join->on('tbmstruk.strukid', '=', 'tbmkel.strukid');
                $join->on('tbmstruk.dlt', '=', DB::raw("'0'"));
            })
            ->select(
                'tbmjen.jenid',
                'tbmkel.kelid',
                'tbmstruk.strukid',
                'tbmjen.jennama',
                DB::raw('tbmstruk.strukkode || tbmkel.kelkode || tbmjen.jenkode as jenkode')
            )
            ->where('tbmjen.dlt', 0)
            ->get()
        ;

        $perusahaan = DB::table('tbmperusahaan')
            ->select('tbmperusahaan.*')
            ->where('tbmperusahaan.dlt', 0)
            ->get()
        ;

        if ($request->ajax()) {
            $data = [];
            $count = 0;
            $page = $request->get('start', 0);  
            $perpage = $request->get('length',50);

            // data table kondisi sarpras
            try {
                $detailpagusarprastersedia = DB::table('tbtransdetailpagusarpras')
                    ->join('tbmperusahaan', function($join){
                        $join->on('tbmperusahaan.perusahaanid', '=', 'tbtransdetailpagusarpras.perusahaanid');
                        $join->on('tbmperusahaan.dlt', '=', DB::raw("'0'"));
                    })
                    ->select('tbtransdetailpagusarpras.*', 'tbmperusahaan.nama')
                    ->where('tbtransdetailpagusarpras.detailsarprasid', $id)
                    ->where('tbtransdetailpagusarpras.dlt', 0)
                    ->orderBy('tbtransdetailpagusarpras.jenispagu')
                ;
                $count = $detailpagusarprastersedia->count();
                $data = $detailpagusarprastersedia->skip($page)->take($perpage)->get();
            }catch (QueryException $e) {
                return $this->sendError('SQL Error', $this->getQueryError($e));
            }
            catch (Exception $e) {
                return $this->sendError('Error', $e->getMessage());
            }

            return $this->sendResponse([
                'data' => $data,
                'count' => $count,
            ], 'Data retrieved successfully.'); 
         }

        return view(
            'sarpras.sarprastersedia.detailsarpras.edit', 
            [
                'page' => $this->page, 
                'child' => 'Tambah Data', 
                'masterurl' => route('sarprastersedia.index'), 
                'detailsarpras' => $detailsarpras,
                'subkegiatan' => $subkegiatan,
                'koderekening' => $koderekening,
                'perusahaan' => $perusahaan
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
        // $this->authorize('edit-12');

        $user = auth('sanctum')->user();

        try {
            $modelRekening = Rekening::find($id);
            
            DB::beginTransaction();

            $modelRekening->bank = $request->bank;
            $modelRekening->koderekening = $request->koderekening;
            $modelRekening->saldo = $request->saldo;

            $modelRekening->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $modelRekening->save();

            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'rekening updated successfully.',
            ], 200);

        }catch(QueryException $e){
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
        // return redirect()
        //         ->route('sarprastersedia.index')
        //         ->with('success', 'Data sarpras tersedia berhasil diubah.', ['page' => $this->page])
        // ;
    }
    public function updateRekening(Request $request, $id)
    {
        // $this->authorize('edit-12');

        $user = auth('sanctum')->user();

        try {
            $modelRekening = Rekening::find($id);
            
            DB::beginTransaction();

            $modelRekening->bank = $request->bank;
            $modelRekening->koderekening = $request->koderekening;
            $modelRekening->saldo = $request->saldo;

            $modelRekening->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $modelRekening->save();

            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'rekening updated successfully.',
            ], 200);

        }catch(QueryException $e){
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    public function updateBudget(Request $request, $id)
    {
        // $this->authorize('edit-12');

        $user = auth('sanctum')->user();

        try {
            $modelBudget = Budget::find($id);
            
            DB::beginTransaction();

            $modelBudget->judul = $request->judul;
            $modelBudget->totalbudget = $request->totalbudget;
            $modelBudget->tglbudget = $request->tglbudget;

            $modelBudget->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $modelBudget->save();

            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'budget updated successfully.',
            ], 200);

        }catch(QueryException $e){
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    public function updatejenissarpras(Request $request, $id)
    {
        $this->authorize('edit-12');

        $user = auth('sanctum')->user();

        try {
            $modelSarprasTersedia = SarprasTersedia::find($id);

            DB::beginTransaction();

            $modelSarprasTersedia->jenissarpras = $request->jenissarpras;
            $modelSarprasTersedia->namasarprasid = $request->namasarprasid;
            $modelSarprasTersedia->jumlahunit = $request->jumlahunit;
            $modelSarprasTersedia->thang = $request->thang;
            $modelSarprasTersedia->satuan = $request->satuan;
            $modelSarprasTersedia->jenisperalatanid = $request->jenisperalatanid;

            $modelSarprasTersedia->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $modelSarprasTersedia->save();

            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'jenis sarpras updated successfully.',
            ], 200);

        }catch(QueryException $e){
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
        // return redirect()
        //         ->route('sarprastersedia.index')
        //         ->with('success', 'Data sarpras tersedia berhasil diubah.', ['page' => $this->page])
        // ;
    }

    public function updatedetailsarpras(Request $request, $id)
    {
        $this->authorize('edit-12');

        $user = auth('sanctum')->user();

        try {
            DB::beginTransaction();

            $model = DetailSarprasTersedia::find($id);

            $model->thperolehan = $request->thperolehan;
            $model->jenid = $request->koderekening;
            $model->subkegid = $request->subkegid;
            $model->sumberdana = $request->sumberdana;
            $model->subdetailkegiatan = $request->subdetailkeg;
            $model->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $model->save();

            DB::commit();

        } catch(QueryException $e){
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }

        return redirect()
                ->route('sarprastersedia.index')
                ->with('success', 'Data detail sarpras berhasil diubah.', ['page' => $this->page])
                ->with(
                        'oldsekolahid', $model->sekolahid
                    )
        ;
    }

    public function updatedetailpagu(UpdateRequest $request, $id)
    {
        $this->authorize('edit-12');

        $user = auth('sanctum')->user();

        $tglnow = date('Y-m-d');

        try {
            $model = DetailPaguSarprasTersedia::find($id);
 
            DB::beginTransaction();

            $model->jenispagu = $request->jenispagu;
            $model->nilaipagu = $request->nilaipagu;
            $model->nokontrak = $request->nokontrak;
            $model->nilaikontrak = $request->nilaikontrak;
            $model->perusahaanid = $request->perusahaanid;
            $model->tgldari = $request->tgldari;
            $model->tglsampai = $request->tglsampai;
            $model->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            if ($request->hasFile('file')) {
                if($model->file != ''  && $model->file != null){
                    $file_old = public_path().'/storage/uploaded/sarprastersedia/detailsarpras/'.$model->file;
                    unlink($file_old);
                }  
                $fileName = $tglnow.'_'.rand(1,1000).'_'.$request->file('file')->getClientOriginalName();   
                $filePath = $request->file('file')->storeAs('public/uploaded/sarprastersedia/detailsarpras', $fileName);   
                $model->file = $fileName;
            }

            $validation = Validator::make($request->all(), [
                'tgldari' => 'required|date|before:tomorrow'
            ]);

            if($validation->fails())
            {
                return response([
                    'errors' => $validation->errors()
                ]);
            };

            $model->save();

            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'detail pagu updated successfully.',
            ], 200);


        } catch (QueryException $e) {
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }
        catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    public function updatedetailjumlahsarpras(Request $request, $id)
    {

        $this->authorize('edit-12');

        $user = auth('sanctum')->user();

        try {
            
            $model = DetailJumlahSarpras::find($id);
            
            DB::beginTransaction();

            $model->kondisi = $request->kondisi;
            $model->jumlah = $request->jumlah;
            $model->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);
            $model->save();

            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'detail jumlah sarpras updated successfully.',
                
            ], 200);

        } catch (QueryException $e) {
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }
        catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    public function storekondisisarprastersedia(Request $request)
    {

        $this->authorize('add-12');

        $user = auth('sanctum')->user();
        try {
            DB::beginTransaction();
            $modelKondisiSarprasTersedia = new KondisiSarprasTersedia;
            $modelKondisiSarprasTersedia->kondisi = $request->kondisi;
            $modelKondisiSarprasTersedia->jumlahunit = $request->jumlahunit;

            if ($request->hasFile('filesarprastersedia')) {
                $filePath = $request->file('filesarprastersedia')->store('public/uploaded/filesarprastersedia');      
                $modelKondisiSarprasTersedia->filesarprastersedia = $filePath;
            }

            $modelKondisiSarprasTersedia->sarprastersediaid = $request->sarprastersediaid;
            $modelKondisiSarprasTersedia->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);

            $modelKondisiSarprasTersedia->save();
            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'akreditasi added successfully.',
                'kondisisarprastersedia' => $modelKondisiSarprasTersedia,
            ], 200);
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
        // $this->authorize('delete-12');

        $user = auth('sanctum')->user();

        try {
            DB::beginTransaction();

            $model = Rekening::find($id);

            $model->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $model->dlt = '1';

            $model->save();

            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'rekening deleted successfully.',
            ], 200);

        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }
    }

    public function destroybudget(Request $request, $id)
    {

        // $this->authorize('delete-12');

        $user = auth('sanctum')->user();

        try {
            DB::beginTransaction();

            $model = Budget::find($id);

            $model->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $model->dlt = '1';

            $model->save();

            $model->save();

            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'budget deleted successfully.',
            ], 200);

        //     return redirect()
        //         ->route('sarprastersedia.index')
        //         ->with('success1', 'Data detail sarpras berhasil dihapus.', ['page' => $this->page])
        // ;

        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }

    }

    public function destroyalokasibudget(Request $request, $id)
    {
        // $this->authorize('delete-12');

        $user = auth('sanctum')->user();

        try {
            DB::beginTransaction();

            $model = AlokasiBudget::find($id);

            $model->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $model->dlt = '1';
            // $model->file = null;

            $model->save();
            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'alokasi budget deleted successfully.',
            ], 200);
        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }
    }

    public function destroydetailjumlahsarpras(Request $request, $id)
    {
        $this->authorize('delete-12');

        $user = auth('sanctum')->user();

        try {
            DB::beginTransaction();

            $model = DetailJumlahSarpras::find($id);

            $model->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $model->dlt = '1';

            $model->save();
            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'detail jumlah sarpras deleted successfully.',
            ], 200);
        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }
    }

    public function getSekolah($kotaid, $jenis, $jenjang, $kecamatanid)
    {
        try {
            $sekolah = DB::table('tbmsekolah')
                    ->select('tbmsekolah.sekolahid', 'tbmsekolah.namasekolah')
                    ->where('tbmsekolah.dlt', 0)
                    ->where('tbmsekolah.kotaid', $kotaid)
                    ->where(function($query) use ($kotaid, $jenis, $jenjang, $kecamatanid)
                        {
                            // if (!is_null($provid) && $provid!='') $query->where('tbmkota.provid', $provid);
                            if (!is_null($kotaid) && $kotaid!='') $query->where('tbmsekolah.kotaid', $kotaid);
                            if (!is_null($jenis) && $jenis!='') $query->where('tbmsekolah.sekolahid', $jenis);
                            if (!is_null($jenjang) && $jenjang!='') $query->where('tbmsekolah.jenjang', $jenjang);
                            if (!is_null($kecamatanid) && $kecamatanid!='') $query->where('tbmsekolah.kecamatanid', $kecamatanid);
                        })
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

    public function loadBudget(Request $request, $id)
    {
        // $this->authorize('view-10');
        $user = auth('sanctum')->user();
        Log::channel('mibedil')->info('Halaman '.$this->page);

        if ($request->ajax()) {

            $data = [];
            $count = 0;
            $page = $request->get('start', 0);  
            $perpage = $request->get('length',50);

            try {
                $budget = DB::table('tbbudget')
                    ->select('tbbudget.*')
                    ->where('tbbudget.rekeningid', $id)
                    ->where('tbbudget.dlt', '0')
                    ->orderBy('tbbudget.budgetid')
                ;
                $count = $budget->count();
                $data = $budget->skip($page)->take($perpage)->get();
            } catch (QueryException $e) {
                return $this->sendError('SQL Error', $this->getQueryError($e));
            }
            catch (Exception $e) {
                return $this->sendError('Error', $e->getMessage());
            }

            return $this->sendResponse([
                'data' => $data,
                'count' => $count
            ], 'Budget retrieved successfully.'); 
        }
    }

    public function loadAlokasiBudget(Request $request, $id) 
    {
        // $this->authorize('view-10');
        $user = auth('sanctum')->user();
        Log::channel('mibedil')->info('Halaman '.$this->page);

        if ($request->ajax()) {

            $data = [];
            $count = 0;
            $page = $request->get('start', 0);  
            $perpage = $request->get('length',50);

            try {
                $alokasibudget = DB::table('tbalokasibudget')
                    ->select('tbalokasibudget.*')
                    ->where('tbalokasibudget.budgetid', $id)
                    ->where('tbalokasibudget.dlt', '0')
                    ->orderBy('tbalokasibudget.alokasibudgetid')
                ;
                $count = $alokasibudget->count();
                $data = $alokasibudget->skip($page)->take($perpage)->get();
            } catch (QueryException $e) {
                return $this->sendError('SQL Error', $this->getQueryError($e));
            }
            catch (Exception $e) {
                return $this->sendError('Error', $e->getMessage());
            }

            return $this->sendResponse([
                'data' => $data,
                'count' => $count
            ], 'Alokasi budget retrieved successfully.'); 
        }
    }

    public function loadDetailJumlahSarpras(Request $request, $id)
    {
        // $this->authorize('view-10');
        $user = auth('sanctum')->user();
        Log::channel('mibedil')->info('Halaman '.$this->page);

        if ($request->ajax()) {

            $data = [];
            $count = 0;
            $page = $request->get('start', 0);  
            $perpage = $request->get('length',50);

            try {
                $detailjumlahsarprastersedia = DB::table('tbtransdetailjumlahsarpras')
                    // ->join('tbtransdetailpagusarpras', function($join) {
                    //     $join->on('tbtransdetailpagusarpras.detailsarprasid', '=', 'tbtransdetailsarpras.detailsarprasid');
                    //     $join->on('tbtransdetailpagusarpras.dlt','=',DB::raw("'0'"));
                    // })
                    // ->join('tbmsubkeg', function() {
                    //     $join->on('tbmsubkeg.subkegid', '=', 'tbtransdetailsarpras.subkegid');
                    //     $join->on('tbmsubkeg.dlt','=',DB::raw("'0'"));
                    // })
                    ->select('tbtransdetailjumlahsarpras.*')
                    ->where('tbtransdetailjumlahsarpras.detailsarprasid', $id)
                    ->where('tbtransdetailjumlahsarpras.dlt', '0')
                    ->orderBy('tbtransdetailjumlahsarpras.detailjumlahsarprasid')
                ;
                $count = $detailjumlahsarprastersedia->count();
                $data = $detailjumlahsarprastersedia->skip($page)->take($perpage)->get();
            } catch (QueryException $e) {
                return $this->sendError('SQL Error', $this->getQueryError($e));
            }
            catch (Exception $e) {
                return $this->sendError('Error', $e->getMessage());
            }

            return $this->sendResponse([
                'data' => $data,
                'count' => $count
            ], 'detail jumlah sarpras tersedia retrieved successfully.'); 
        }
    }

    public function showfotojumlahsarpras(Request $request, $id)
    {
        $this->authorize('view-12');
        $user = auth('sanctum')->user();
        Log::channel('mibedil')->info('Halaman '.$this->page);

        if($request->ajax())
        {
            $data = [];
            $count = 0;
            $page = $request->get('start', 0);  
            $perpage = $request->get('length',50);

            try {
                $fotodetailjumlahsarpras = DB::table('tbtransfiledetailjumlahsarpras')
                    // ->join('tbtransdetailpagusarpras', function($join) {
                    //     $join->on('tbtransdetailpagusarpras.detailsarprasid', '=', 'tbtransdetailsarpras.detailsarprasid');
                    //     $join->on('tbtransdetailpagusarpras.dlt','=',DB::raw("'0'"));
                    // })
                    // ->join('tbmsubkeg', function() {
                    //     $join->on('tbmsubkeg.subkegid', '=', 'tbtransdetailsarpras.subkegid');
                    //     $join->on('tbmsubkeg.dlt','=',DB::raw("'0'"));
                    // })
                    ->select('tbtransfiledetailjumlahsarpras.*')
                    ->where('tbtransfiledetailjumlahsarpras.detailjumlahsarprasid', $id)
                    ->where('tbtransfiledetailjumlahsarpras.dlt', '0')
                    ->orderBy('tbtransfiledetailjumlahsarpras.filedetailjumlahsarprasid')
                ;
                $count = $fotodetailjumlahsarpras->count();
                $data = $fotodetailjumlahsarpras->skip($page)->take($perpage)->get();
            } catch (QueryException $e) {
                return $this->sendError('SQL Error', $this->getQueryError($e));
            }
            catch (Exception $e) {
                return $this->sendError('Error', $e->getMessage());
            }

            return $this->sendResponse([
                'data' => $data,
                'count' => $count,
            ], 'foto detail jumlah sarpras tersedia retrieved successfully.'); 
        }
    }

    public function downloadfiledetailpagu($id)
    {
         $this->authorize('print-12');
         $detailPaguSarpras = DetailPaguSarprasTersedia::find($id);
         $filename = $detailPaguSarpras->file;
 
         $file = public_path().'/storage/uploaded/sarprastersedia/detailsarpras/'.$filename;
 
         return response()->download($file);
    }

    public function downloadfiledetailjumlahsarpras($id)
    {
        $this->authorize('print-12');
        $fileDetailJumlahSarpras = FileDetailJumlahSarpras::find($id);
        $filename = $fileDetailJumlahSarpras->file;

        $file = public_path().'/storage/uploaded/sarprastersedia/detailjumlahsarpras/'.$filename;

        return response()->download($file);
    }

    public function storefiledetailjumlahsarpras(Request $request, $detailjumlahsarprasid)
    {

        $this->authorize('add-12');

        $tglnow = date('Y-m-d');
        $user = auth('sanctum')->user();
        try {

            DB::beginTransaction();
            $model = new FileDetailJumlahSarpras;

            if ($request->hasFile('file')) {
                $fileName = $tglnow.'_'.rand(1,1000).'_'.$request->file('file')->getClientOriginalName();   
                $filePath = $request->file('file')->storeAs('public/uploaded/sarprastersedia/detailjumlahsarpras', $fileName);   
                $model->file = $fileName;
            }

            $model->detailjumlahsarprasid = $detailjumlahsarprasid;
            $model->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);

            $model->save();
            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'file detail jumlah sarpras added successfully.',
                'file' => $model,
            ], 200);
        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }
    }

    public function updatefiledetailjumlahsarpras(Request $request, $id)
    {

        $this->authorize('edit-12');

        $tglnow = date('Y-m-d');
        $user = auth('sanctum')->user();
        try {

            DB::beginTransaction();
            $model = FileDetailJumlahSarpras::find($id);

            if ($request->hasFile('file')) {
                if($model->file != ''  && $model->file != null){
                    $file_old = public_path().'/storage/uploaded/sarprastersedia/detailjumlahsarpras/'.$model->file;
                    unlink($file_old);
                }  
                $fileName = $tglnow.'_'.rand(1,1000).'_'.$request->file('file')->getClientOriginalName();   
                $filePath = $request->file('file')->storeAs('public/uploaded/sarprastersedia/detailjumlahsarpras', $fileName);   
                $model->file = $fileName;
            }

            $model->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $model->save();
            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'file detail jumlah sarpras updated successfully.',
                'file' => $model,
            ], 200);
        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }
    }

    public function destroyfiledetailjumlahsarpras(Request $request, $id)
    {

        $this->authorize('delete-12');

        $user = auth('sanctum')->user();
        try {

            DB::beginTransaction();
            $model = FileDetailJumlahSarpras::find($id);

            if ($request->hasFile('file')) {
                if($model->file != ''  && $model->file != null){
                    $file_old = public_path().'/storage/uploaded/sarprastersedia/detailjumlahsarpras/'.$model->file;
                    unlink($file_old);
                }
            }
            $model->dlt = '1';
            $model->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $model->save();
            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'file detail jumlah sarpras deleted successfully.',
                'file' => $model,
            ], 200);
        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }
    }

    public function statusrealisasi(Request $request, $alokasibudgetid)
    {
        // $this->authorize('delete-12');

        $user = auth('sanctum')->user();
        try {

            DB::beginTransaction();
            $model = AlokasiBudget::find($alokasibudgetid);

            $budget = Budget::where('budgetid', $model->budgetid)->where('dlt', 0)->first();
            $rekening = Rekening::where('rekeningid', $budget->rekeningid)->where('dlt', 0)->first();

            $model->statusrealisasi = '2';
            $budget->terealisasikan = $model->alokasibudget + $budget->terealisasikan;
            $model->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $model->save();
            $budget->save();

            // if($model->save() && $budget->save())
            // {
                $rekening->saldo = $rekening->saldo - $model->alokasibudget;
                $rekening->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

                $rekening->save();
            // }

            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'statusrealisasi has changed.',
                'file' => $model,
            ], 200);
        } catch (\Throwable $th) {
            return response(['error' => $th->getMessage()], 500);
        }
    }
}
