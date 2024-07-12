<?php

namespace App\Http\Controllers;

use App\Models\DatoukNinikMamak;
use App\Models\BerkasPendukung;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DatoukNinikMamakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DatoukNinikMamak::getDataTables();
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
            'nama' => 'required|string|max:255',
            'gelar' => 'nullable|string|max:255',
            'suku' => 'required|string|max:255',
            'alamat' => 'required|string',
            'id_kenegerian' => 'required|integer',
            'file.*' => 'required',
            'nama_berkas.*' => 'required|string|max:255'
        ]);

        // Simpan data menggunakan method di model
        $ninikMamak = DatoukNinikMamak::createWithBerkas($validatedData);

        // Buat respon
        $response = [
            'status' => "Berhasil",
            'data' => $ninikMamak->load('berkasPendukung')
        ];

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DatoukNinikMamak  $datoukNinikMamak
     * @return \Illuminate\Http\Response
     */
    public function show(DatoukNinikMamak $datoukNinikMamak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DatoukNinikMamak  $datoukNinikMamak
     * @return \Illuminate\Http\Response
     */
    public function edit(DatoukNinikMamak $datoukNinikMamak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DatoukNinikMamak  $datoukNinikMamak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ninik_mamak)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'gelar' => 'nullable|string|max:255',
            'suku' => 'required|string|max:255',
            'alamat' => 'required|string',
            'id_kenegerian' => 'required|integer',
            'file.*' => 'required',
            'nama_berkas.*' => 'required|string|max:255',
        ]);
        $ninikMamak = DatoukNinikMamak::findOrFail($ninik_mamak);
        $ninikMamak->nama = $request->nama;
        $ninikMamak->gelar = $request->gelar;
        $ninikMamak->suku = $request->suku;
        $ninikMamak->alamat = $request->alamat;
        $ninikMamak->id_kenegerian = $request->id_kenegerian;
        $ninikMamak->save();
        $existingFileUser = BerkasPendukung::where('id_ninik_mamak', $ninik_mamak)->get();
        $listFiles = [];
        foreach ($existingFileUser as $item) {
            $listFiles[] = $item->id;
        }
        $status = [];
        foreach ($request->id_berkas as $key => $itemFile) {
            if (!in_array($itemFile, $listFiles)) {
                BerkasPendukung::create([
                    'id_ninik_mamak' => $ninik_mamak,
                    'nama_berkas' => $request->nama_berkas[$key],
                    'file' => $request->file[$key]
                ]);
            }
        }

        foreach ($listFiles as $itemData) {
            if (!in_array($itemData, $request->id_berkas)) {
                BerkasPendukung::where('id', $itemData)->where('id_ninik_mamak', $ninik_mamak)->delete();
            }
        }


        foreach ($request->id_berkas as $keyInput => $itemInput) {
            BerkasPendukung::where('id', $itemInput)->where('id_ninik_mamak', $ninik_mamak)->update([
                'nama_berkas' => $request->nama_berkas[$keyInput],
                'file' => $request->file[$keyInput]
            ]);
        }
        return response()->json([
            'status' => 'berhasil',
        ], 200);
    }



    public function destroy(DatoukNinikMamak $ninik_mamak)
    {
        try {
            // Panggil metode delete untuk menghapus data
            $ninik_mamak->delete();

            // Berhasil menghapus, kembalikan respons JSON
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Data berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            // Tangkap pengecualian jika terjadi kesalahan saat menghapus
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Gagal menghapus data kenegerian: ' . $e->getMessage()
            ], 500); // Kode status 500 untuk internal server error
        }
    }

    public function updatePersetujuan(Request $request, DatoukNinikMamak $ninik_mamak)
    {
        $ninik_mamak->updatePersetujuan($request->status, $request->message);

        return response()->json([
            'status' => 'berhasil',
            'message' => $ninik_mamak
        ], 200);
    }
}
