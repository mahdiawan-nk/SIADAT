<?php

namespace App\Http\Controllers;

use App\Models\InformasiBudaya;
use Illuminate\Http\Request;

class InformasiBudayaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   

        return InformasiBudaya::getDataTables($request->input('jenis'));
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
        // Validasi data
        $validatedData = $request->validate([
            'jenis' => 'required|string|max:255',
            'nama' => 'nullable|string|max:255',
            'jenis_peninggalan' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string',
            'ringkasan' => 'required',
            'foto' => 'required|string',
        ]);

        // Simpan data menggunakan method di model
        $create = InformasiBudaya::createData($request->post());

        // Buat respon
        $response = [
            'status' => "Berhasil",
            'data' => $request->all(),
            'message'=>'Data Has Created'
        ];

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InformasiBudaya  $informasiBudaya
     * @return \Illuminate\Http\Response
     */
    public function show(InformasiBudaya $informasi_budaya)
    {
        $response = [
            'status' => "Berhasil",
            'data' => $informasi_budaya,
        ];

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InformasiBudaya  $informasiBudaya
     * @return \Illuminate\Http\Response
     */
    public function edit(InformasiBudaya $informasiBudaya)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InformasiBudaya  $informasiBudaya
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InformasiBudaya $informasi_budaya)
    {
        $informasi_budaya->updateData($request->post());

        $response = [
            'status' => 'Berhasil',
            'data' => $informasi_budaya,
            'message'=>"Data has ben Updated"
        ];

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InformasiBudaya  $informasiBudaya
     * @return \Illuminate\Http\Response
     */
    public function destroy(InformasiBudaya $informasi_budaya)
    {
        try {
            // Panggil metode delete untuk menghapus data
            $informasi_budaya->delete();

            // Berhasil menghapus, kembalikan respons JSON
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Data berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            // Tangkap pengecualian jika terjadi kesalahan saat menghapus
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500); // Kode status 500 untuk internal server error
        }
    }
}
