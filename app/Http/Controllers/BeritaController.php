<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Berita::with('user:id,username')->orderBy('id', 'desc');
        if(auth()->user()->role == 2){
            $query->where('created_by',Auth::id());
        }
        $data = $query->get();
        $dataTable = DataTables::of($data);
        $dataTable->addIndexColumn()
            ->addColumn('contents', function ($row) {
                return html_entity_decode($row->isi);
            })
            ->addColumn('thumbnails', function ($row) {
                return '<img src="' . asset($row->thumbnail). '" class="img-thumbnail w-75"/>';
            })
            ->addColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->locale('id')->translatedFormat('d-m-Y H:i');
            })
            ->addColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->locale('id')->translatedFormat('d-m-Y H:i');
            })
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-secondary me-1 edit">Edit</button><button class="btn btn-sm btn-danger hapus">Hapus</button>';
            })
            ->rawColumns(['contents', 'thumbnails', 'created_at', 'updated_at', 'action']);

        return $dataTable->make(true);
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

        Berita::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'slug' => 'berita-' . time() . '-' . date('d-m-y'),
            'thumbnail' => $request->thumbnail,
            'status' => 0,
            'created_by' => auth()->id()
        ]);
        $response = [
            'status' => "Berhasil",
            'data' => $request->all()
        ];
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\Response
     */
    public function show(Berita $berita)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\Response
     */
    public function edit(Berita $berita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Berita $beritum)
    {
        $beritum->fill($request->post())->save();
        $response = [
            'status' => "Berhasil",
            'data' => $beritum
        ];
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\Response
     */
    public function destroy(Berita $beritum)
    {
        try {
            // Panggil metode delete untuk menghapus data
            $beritum->delete();

            // Berhasil menghapus, kembalikan respons JSON
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Data adat istiadat berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            // Tangkap pengecualian jika terjadi kesalahan saat menghapus
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Gagal menghapus data kenegerian: ' . $e->getMessage()
            ], 500); // Kode status 500 untuk internal server error
        }
    } 

}
