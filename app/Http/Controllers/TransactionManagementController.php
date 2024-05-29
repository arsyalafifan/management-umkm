<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Rekening;
use App\Models\StockManagement;
use App\Models\TransactionManagement;

class TransactionManagementController extends BaseController
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

        Log::channel('mibedil')->info('Halaman '.$this->page);

        $rekening = [];

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

        $rekening = DB::table('tbrekening')
            ->select('tbrekening.rekeningid', 'tbrekening.koderekening', 'tbrekening.bank', 'tbrekening.saldo')
            ->where('tbrekening.dlt', 0)
            ->orderBy('tbrekening.bank')
            ->get()
        ;

        return view(
            'transactionmanagement.index', 
            [
                'page' => $this->page, 
                'rekening' => $rekening,
                'createbutton' => true, 
                'createurl' => route('transactionmanagement.create'), 
            ]
        );
    }

    public function transaction(Request $request, $stockid)
    {
        // $this->authorize('view-18');

        if($request->ajax())
        {
            $data = [];
            $count = 0;
            $page = $request->get('start', 0);  
            $perpage = $request->get('length',50);

            try {
                $transaction = DB::table('tbtransactionmanagement')
                    ->select('tbtransactionmanagement.*')
                    ->where('tbtransactionmanagement.stockid', $stockid)
                ;

                $count = $transaction->count();
                $data = $transaction->skip($page)->take($perpage)->get();

            } catch (QueryException $e) {
                return $this->sendError('SQL Error', $this->getQueryError($e));
            }
            catch (Exception $e) {
                return $this->sendError('Error', $e->getMessage());
            }
            return $this->sendResponse([
                'data' => $data,
                'count' => $count,
            ], 'Transaction data retrieved successfully.');  
        }
    }

    public function savesetting(Request $request, $id)
    {
        // $this->authorize('edit-18');
        $user = auth('sanctum')->user();

        try {
            DB::beginTransaction();

            $stock = StockManagement::where('stockid', $id)
                ->where('dlt', 0)
                ->firstOrFail()
            ;

            // $stock->status = enum::STATUS_KEBUTUHAN_SARPRAS_DISETUJUI;
            // $stock->jumlahsetuju = $request->jumlahsetuju;
            $stock->rekeningid = $request->rekeningid;
            // $stock->keterangan = $request->keterangan;
            $stock->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $stock->save();

            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'Berhasil setting rekening stock.',
            ], 200);
        } catch (QueryException $e) {
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }
        catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    public function addtransaction(Request $request, $id)
    {
        // $this->authorize('edit-18');
        $user = auth('sanctum')->user();

        try {
            DB::beginTransaction();

            $transaction = new TransactionManagement;

            // $stock->status = enum::STATUS_KEBUTUHAN_SARPRAS_DISETUJUI;
            // $stock->jumlahsetuju = $request->jumlahsetuju;
            $transaction->stockid = $request->stockid;
            $transaction->tgltransaksi = $request->tgltransaksi;
            $transaction->jumlah = $request->jumlah;
            $transaction->total = $request->total;
            $transaction->keterangan = $request->keterangan;
            // $transaction->status = $request->status;
            // $stock->keterangan = $request->keterangan;
            $transaction->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            if ($transaction->save()) {
                $stock = StockManagement::where('stockid', $request->stockid)
                    ->where('dlt', 0)
                    ->firstOrFail()
                ;
                if ($stock->jumlah - $request->jumlah <= 0) {
                    return response([
                        'success' => false,
                        'data'    => 'failed',
                        'message' => 'Stock tidak mencukupi untuk jumlah order.',
                    ], 200);
                }else {
                    if (is_null($stock->rekeningid)) {
                        return response([
                            'success' => false,
                            'data'    => 'failed',
                            'message' => 'Anda belum melakukan setting rekening untuk stock ini.',
                        ], 200);
                    }
                    else
                    {
                        $stock->jumlah = $stock->jumlah - $request->jumlah;
                        $stock->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);
                        $stock->save();
                    }
                }

                $rekening = Rekening::where('rekeningid', $stock->rekeningid)
                    ->where('dlt', 0)
                    ->firstOrFail()
                ;

                $rekening->saldo = $rekening->saldo + $request->total;
                $rekening->save();

            }

            DB::commit();

            return response([
                'success' => true,
                'data'    => 'Success',
                'message' => 'Berhasil menambah transaksi.',
            ], 200);
        } catch (QueryException $e) {
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }
        catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
