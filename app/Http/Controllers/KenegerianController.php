<?php

namespace App\Http\Controllers;

use App\Models\Kenegerian;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KenegerianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Kenegerian::orderBy('id', 'desc');

        $data = $query->get();
        $dataTable = DataTables::of($data);
        $dataTable->addIndexColumn()
            ->addColumn('contents', function ($row) {
                return $row->sejarah;
            })
            ->addColumn('thumbnail', function ($row) {
                return '<img src="' . asset($row->foto) . '" class="img-thumbnail w-50"/>';
            })
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-secondary me-1 edit">Edit</button><button class="btn btn-sm btn-danger hapus">Hapus</button>';
            })
            ->rawColumns(['action', 'contents', 'thumbnail']);

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
        Kenegerian::create($request->post());
        $response = [
            'status' => "Berhasil",
            'data' => $request->all()
        ];
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kenegerian  $kenegerian
     * @return \Illuminate\Http\Response
     */
    public function show(Kenegerian $kenegerian)
    {
        $response = [
            'status' => "Berhasil",
            'data' => $kenegerian
        ];
        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kenegerian  $kenegerian
     * @return \Illuminate\Http\Response
     */
    public function edit(Kenegerian $kenegerian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kenegerian  $kenegerian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kenegerian $kenegerian)
    {
        $kenegerian->fill($request->post())->save();
        $response = [
            'status' => "Berhasil",
            'data' => $kenegerian
        ];
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kenegerian  $kenegerian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kenegerian $kenegerian)
    {
        try {
            // Panggil metode delete untuk menghapus data
            $kenegerian->delete();

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
