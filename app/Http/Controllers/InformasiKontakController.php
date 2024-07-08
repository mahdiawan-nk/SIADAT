<?php

namespace App\Http\Controllers;

use App\Models\InformasiKontak;
use Illuminate\Http\Request;

class InformasiKontakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = InformasiKontak::getDataKontak();
        $response = [
            'status' => "Berhasil",
            'data' => $data,
            'message' => 'Data Has Found'
        ];

        return response()->json($response);
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
        $validatedData = $request->validate([
            'surel' => 'required|string',
            'telephone' => 'required|string',
            'alamat' => 'required|string',
            'catatan' => 'required|string',
        ]);
        $isExistData = InformasiKontak::latest()->first();
        if ($isExistData) {
            // If data exists, update it
            InformasiKontak::updateData($validatedData,$isExistData->id);
            $response = [
                'status' => "Berhasil",
                'message' => 'Informasi Kontak Has Updated'
            ];
        } else {
            // If no data exists, create new data
            InformasiKontak::createData($validatedData);
            $response = [
                'status' => "Berhasil",
                'message' => 'Informasi Kontak Has Created'
            ];
        }
        return response()->json($response);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InformasiKontak  $informasiKontak
     * @return \Illuminate\Http\Response
     */
    public function show(InformasiKontak $informasiKontak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InformasiKontak  $informasiKontak
     * @return \Illuminate\Http\Response
     */
    public function edit(InformasiKontak $informasiKontak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InformasiKontak  $informasiKontak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InformasiKontak $informasiKontak)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InformasiKontak  $informasiKontak
     * @return \Illuminate\Http\Response
     */
    public function destroy(InformasiKontak $informasiKontak)
    {
        //
    }
}
