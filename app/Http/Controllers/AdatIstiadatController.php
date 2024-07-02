<?php

namespace App\Http\Controllers;

use App\Models\AdatIstiadat;
use Illuminate\Http\Request;

class AdatIstiadatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AdatIstiadat::getDataTables();
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
            'nama_adat' => 'required|string|max:255',
            'ringkasan' => 'nullable|string|max:255',
            'foto' => 'required|string|max:255',
            'lokasi' => 'required|string',
            'id_kenegerian' => 'required|integer',
        ]);

        // Simpan data menggunakan method di model
        $create = AdatIstiadat::createData($validatedData);

        // Buat respon
        $response = [
            'status' => "Berhasil",
            'data' => $create,
            'message'=>'Data Has Created'
        ];

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdatIstiadat  $adatIstiadat
     * @return \Illuminate\Http\Response
     */
    public function show(AdatIstiadat $adatIstiadat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdatIstiadat  $adatIstiadat
     * @return \Illuminate\Http\Response
     */
    public function edit(AdatIstiadat $adatIstiadat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdatIstiadat  $adatIstiadat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdatIstiadat $adat_istiadat)
    {
        $adat_istiadat->updateData($request->post());

        $response = [
            'status' => 'Berhasil',
            'data' => $adat_istiadat,
            'message'=>"Data has ben Updated"
        ];

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdatIstiadat  $adatIstiadat
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdatIstiadat $adat_istiadat)
    {
        try {
            // Panggil metode delete untuk menghapus data
            $adat_istiadat->delete();

            // Berhasil menghapus, kembalikan respons JSON
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Data adat istiadat berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            // Tangkap pengecualian jika terjadi kesalahan saat menghapus
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Gagal menghapus data adat istiadat: ' . $e->getMessage()
            ], 500); // Kode status 500 untuk internal server error
        }
    }

    public function updatePersetujuan(Request $request, AdatIstiadat $adat_istiadat)
    {
        $adat_istiadat->updatePersetujuan($request->status, $request->message);

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Data Has '.($request->status === '1' ? 'Accepted' : 'Rejected')
        ], 200);
    }
}
