<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController as BaseController;
use App\enumVar as enum;
use App\Models\master\Akses;
use App\Models\master\AksesMenu;

class AksesController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		$this->page = 'Hak Akses';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->authorize('view-15');

        Log::channel('mibedil')->info('Halaman '.$this->page);
        $akses = [];

        if($request->ajax())
        {    
            $search = $request->search;
            $data = [];
            $count = 0;
            $page = $request->get('start', 0);  
            $perpage = $request->get('length',50);        
            try {
                $akses = DB::table('tbmakses')
                        ->select('tbmakses.*')
                        ->where('tbmakses.dlt', '0')
                        ->where(function($query) use ($search)
                        {
                            if (!is_null($search) && $search!='') {
                                // $query->where(DB::raw('CONCAT(tbmakses.akseskode, tbmakses.aksesnama)'), 'ilike', '%'.$search.'%');
                                // $query->where(DB::raw('tbmakses.akseskode'), 'ilike', '%'.$search.'%');
                                $query->orWhere(DB::raw('tbmakses.aksesnama'), 'ilike', '%'.$search.'%');
                            }
                        })
                        ->orderBy('tbmakses.aksesid');
                        

                $count = $akses->count();
                $data = $akses->skip($page)->take($perpage)->get();
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
            ], 'Hak Akses retrieved successfully.');  
        }

        return view(
            'utility.akses.index', 
            [
                'page' => $this->page, 
                'createbutton' => false, 
                'createurl' => route('akses.create'), 
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
        $this->authorize('add-15');

        Log::channel('mibedil')->info('Halaman Tambah '.$this->page);

        $akses = new Akses;

        $aksesmenu = DB::table('tbmmenu as b')
            ->leftJoin('tbmaksesmenu', function($join)
            {
                $join->on('tbmaksesmenu.menuid', '=', 'b.menuid');
                $join->on('tbmaksesmenu.dlt', DB::raw("'0'"));
                $join->where(function($query)
                {
                    $query->whereNull('tbmaksesmenu.aksesid');
                });
            })
            ->leftJoin('tbmakses', function($join)
            {
                $join->on('tbmakses.aksesid', '=', 'tbmaksesmenu.aksesid');
                $join->on('tbmakses.dlt', DB::raw("'0'"));
            })
            ->select('b.menuid', 'b.parent', 'b.menu', 'tbmaksesmenu.aksesid', 'tbmaksesmenu.aksesmenuid', DB::raw('COALESCE(tbmaksesmenu.tambah, \'0\') as tambah'), DB::raw('COALESCE(tbmaksesmenu.ubah, \'0\') as ubah'), DB::raw('COALESCE(tbmaksesmenu.hapus, \'0\') as hapus'), DB::raw('COALESCE(tbmaksesmenu.lihat, \'0\') as lihat'), DB::raw('COALESCE(tbmaksesmenu.cetak, \'0\') as cetak'))
            ->addSelect(DB::raw('\'0\' AS semua'))
            ->addSelect(DB::raw('CASE WHEN b.jenis='.enum::JENISMENU_MASTER.' THEN \''.enum::JENISMENUNAMA_MASTER.'\' WHEN b.jenis='.enum::JENISMENU_UTILITAS.' THEN \''.enum::JENISMENUNAMA_UTILITAS.'\' WHEN b.jenis='.enum::JENISMENU_VERIFIKASI.' THEN \''.enum::JENISMENUNAMA_VERIFIKASI.'\' WHEN b.jenis='.enum::JENISMENU_SARPRAS.' THEN \''.enum::JENISMENUNAMA_SARPRAS.'\' ELSE \'\' END AS jenis'))
            ->where('b.ishide', DB::raw("'0'"))
            ->where(function($query)
            {
                $query->whereNull('tbmaksesmenu.aksesid');
            })
            ->orderBy('b.jenis')->orderBy('b.urutan')->get();

        return view('utility.akses.form', 
                    [
                        'page' => $this->page, 
                        'child' => 'Tambah Data', 
                        'masterurl' => route('akses.index'), 
                        'akses' => $akses, 
                        'aksesmenu' => $aksesmenu,
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
        $this->authorize('add-15');

        $input = $request->all();
        try {
            $user = auth('sanctum')->user();

            $model = new Akses;

            DB::beginTransaction();

            $model->grup = $request->grup;
            $model->aksesnama = $request->aksesnama;

            $model->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);

            $model->save();

            $listAksesMenu = $request->aksesmenu;

            if (is_array($listAksesMenu) || is_object($listAksesMenu)){
                foreach ($listAksesMenu as $dataAksesMenu){
                    $modelAksesMenu = new AksesMenu;
                    $modelAksesMenu->aksesid = $model->aksesid;
                    $modelAksesMenu->menuid = $dataAksesMenu["menuid"];
                    $modelAksesMenu->tambah = $dataAksesMenu["tambah"];
                    $modelAksesMenu->ubah = $dataAksesMenu["ubah"];
                    $modelAksesMenu->hapus = $dataAksesMenu["hapus"];
                    $modelAksesMenu->lihat = $dataAksesMenu["lihat"];
                    $modelAksesMenu->cetak = $dataAksesMenu["cetak"];

                    $modelAksesMenu->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);
                    
                    $modelAksesMenu->save();
                    
                }
            }

            DB::commit();

            return redirect()->route('akses.index')
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
        $this->authorize('edit-15');

        Log::channel('disnaker')->info('Halaman Ubah '.$this->page, ['id' => $id]);

        $akses = Akses::where('aksesid', $id)->firstOrFail();

        $aksesmenu = DB::table('tbmmenu as b')
            ->leftJoin('tbmaksesmenu', function($join) use ($id)
            {
                $join->on('tbmaksesmenu.menuid', '=', 'b.menuid');
                $join->on('tbmaksesmenu.dlt', DB::raw("'0'"));
                $join->on('tbmaksesmenu.aksesid', DB::raw("$id"));
            })
            ->leftJoin('tbmakses', function($join)
            {
                $join->on('tbmakses.aksesid', '=', 'tbmaksesmenu.aksesid');
                $join->on('tbmakses.dlt', DB::raw("'0'"));
            })
            ->select('b.menuid', 'b.parent', 'b.menu', 'tbmaksesmenu.aksesid', 'tbmaksesmenu.aksesmenuid', DB::raw('COALESCE(tbmaksesmenu.tambah, \'0\') as tambah'), DB::raw('COALESCE(tbmaksesmenu.ubah, \'0\') as ubah'), DB::raw('COALESCE(tbmaksesmenu.hapus, \'0\') as hapus'), DB::raw('COALESCE(tbmaksesmenu.lihat, \'0\') as lihat'), DB::raw('COALESCE(tbmaksesmenu.cetak, \'0\') as cetak'))
            ->addSelect(DB::raw('CASE WHEN tbmaksesmenu.tambah=\'1\' and tbmaksesmenu.ubah=\'1\' and tbmaksesmenu.hapus=\'1\' and tbmaksesmenu.lihat=\'1\' and tbmaksesmenu.cetak=\'1\' THEN \'1\' ELSE \'0\' END AS semua'))
            ->addSelect(DB::raw('CASE WHEN b.jenis='.enum::JENISMENU_MASTER.' THEN \''.enum::JENISMENUNAMA_MASTER.'\' WHEN b.jenis='.enum::JENISMENU_SARPRAS.' THEN \''.enum::JENISMENUNAMA_SARPRAS.'\' WHEN b.jenis='.enum::JENISMENU_UTILITAS.' THEN \''.enum::JENISMENUNAMA_UTILITAS.'\' WHEN b.jenis='.enum::JENISMENU_VERIFIKASI.' THEN \''.enum::JENISMENUNAMA_VERIFIKASI.'\' ELSE \'\' END AS jenis'))
            ->where('b.ishide', DB::raw("'0'"))
            ->orderBy('b.jenis')->orderBy('b.urutan')->get();

        return view(
                'utility.akses.form', 
                [
                    'page' => $this->page, 
                    'createbutton' => false, 
                    'child' => 'Ubah Data', 
                    'masterurl' => route('akses.index'), 
                    'akses' => $akses, 
                    'aksesmenu' => $aksesmenu
                ]
            )
        ;
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
        $this->authorize('edit-15');

        $user = auth('sanctum')->user();

        try {
            DB::beginTransaction();

            $akses = Akses::find($id);
            // $akses->grup = $request->grup;
            $akses->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

            $akses->save();

            $listAksesMenu = $request->aksesmenu;

            if (is_array($listAksesMenu) || is_object($listAksesMenu)){
                foreach ($listAksesMenu as $dataAksesMenu){
                    if(isset($dataAksesMenu["aksesmenuid"]) && $dataAksesMenu["aksesmenuid"]!=="" && $dataAksesMenu["aksesmenuid"]!==null){
                        $modelAksesMenu = AksesMenu::find($dataAksesMenu["aksesmenuid"]);
                        $modelAksesMenu->menuid = $dataAksesMenu["menuid"];
                        $modelAksesMenu->tambah = $dataAksesMenu["tambah"];
                        $modelAksesMenu->ubah = $dataAksesMenu["ubah"];
                        $modelAksesMenu->hapus = $dataAksesMenu["hapus"];
                        $modelAksesMenu->lihat = $dataAksesMenu["lihat"];
                        $modelAksesMenu->cetak = $dataAksesMenu["cetak"];

                        $modelAksesMenu->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);
                    }else{
                        $modelAksesMenu = new AksesMenu;
                        $modelAksesMenu->aksesid = $akses->aksesid;
                        $modelAksesMenu->menuid = $dataAksesMenu["menuid"];
                        $modelAksesMenu->tambah = $dataAksesMenu["tambah"];
                        $modelAksesMenu->ubah = $dataAksesMenu["ubah"];
                        $modelAksesMenu->hapus = $dataAksesMenu["hapus"];
                        $modelAksesMenu->lihat = $dataAksesMenu["lihat"];
                        $modelAksesMenu->cetak = $dataAksesMenu["cetak"];

                        $modelAksesMenu->fill(['opadd' => $user->login, 'pcadd' => $request->ip()]);
                    }

                    $modelAksesMenu->save();
                    
                }
            }

            DB::commit();
        }
        catch (QueryException $e) {
            return $this->sendError('SQL Error', $this->getQueryError($e));
        }
        catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }

        return redirect()->route('akses.index')
                ->with('success', 'Data berhasil diubah.', ['page' => $this->page]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('delete-15');

        $user = auth('sanctum')->user();
        
        $akses = Akses::find($id);

        if (count($akses->user)>0) 
            return response([
                'success' => false,
                'data'    => 'Data tidak bisa dihapus karena sudah digunakan pada menu User Manajemen'
            ], 200);

        $akses->dlt = '1';

        $akses->fill(['opedit' => $user->login, 'pcedit' => $request->ip()]);

        $akses->save();

        Aksesmenu::where('tbmaksesmenu.dlt', '0')
                    ->where('tbmaksesmenu.aksesid', $id)
                    ->update(
                        ['dlt' => '1', 'opedit' => $user->login, 'pcedit' => $request->ip()]
                    );

        return response([
            'success' => true,
            'data'    => 'Success',
            'message' => 'Hak Akses deleted successfully.',
        ], 200);
    }

    public function getnextno()
    {
        $data = DB::table('tbmakses')
        ->select(DB::raw('max(cast(replace(tbmakses.akseskode, \'.\', \'\') as int)) + 1 as kode'))
        ->where('tbmakses.dlt', '0')
        // ->where('tbmkota.provid', $parentid)
        ->get();

        // dd($data);
        
        $kode = 1;
        if ($data[0]->kode != null) $kode = $data[0]->kode;

        $nextno = '1';
        if (isset($kode)) {
            $nextno = $kode;
        }
        $nextno = str_pad($nextno, 4, '0', STR_PAD_LEFT);
        $nextno = $nextno . '.';

        // dd($nextno);

        return response([
            'data' => $nextno,
            'success' => true,
            'message' => 'successfully get next no'
        ]);
    }
}
