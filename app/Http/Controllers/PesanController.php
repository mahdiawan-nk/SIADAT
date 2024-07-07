<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $pesanData = Pesan::getInbox($request->input('jenis_pesan'));
        $response = [
            'status' => "Berhasil",
            'message' => 'Informasi Kontak Has Created',
            'data' => [
                'current_page' => $pesanData->currentPage(),
                'to' => $pesanData->lastItem(),
                'total' => $pesanData->total(),
                'last_page' => $pesanData->lastPage(),
                'pesan' => $pesanData->items(),
                'pagination' => (string) $pesanData->links()
            ]
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
        if (is_array($request->id_user_recieve)) {
            foreach ($request->id_user_recieve as $item) {
                $dataInsert = new Pesan();
                $dataInsert->percakapan_id = $request->percakapan_id;
                $dataInsert->id_user_sender = Auth::id();
                $dataInsert->id_user_recieve = $item;
                $dataInsert->subject = $request->subject;
                $dataInsert->body = $request->body;
                $dataInsert->attachment = $request->attachment;
                $dataInsert->save();
            }
        } else {
            $dataInsert = new Pesan();
            $dataInsert->percakapan_id = $request->percakapan_id;
            $dataInsert->id_user_sender = Auth::id();
            $dataInsert->id_user_recieve = $request->id_user_recieve;
            $dataInsert->subject = $request->subject;
            $dataInsert->body = $request->body;
            $dataInsert->attachment = $request->attachment;
            $dataInsert->save();
        }


        $response = [
            'status' => "Berhasil",
            'message' => 'PesaN Berhasil Dikirim',
            'data' => $request->all()
        ];

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pesan  $pesan
     * @return \Illuminate\Http\Response
     */
    public function show($pesan)
    {
        $pesanData = Pesan::with(['userSender:id,nama_lengkap,email', 'userReceive:id,nama_lengkap,email'])->where('id', $pesan)->first();
        $pesanData->file = $pesanData->attachment ? asset($pesanData->attachment) : '';
        $percakapanPesan = Pesan::where('percakapan_id', $pesan)->get();
        foreach ($percakapanPesan as $item) {
            $item->file = $item->attachment ? asset($item->attachment) : '';
            $item->name_file = $item->attachment ? basename($item->attachment) : '';
        }
        $response = [
            'status' => "Berhasil",
            'message' => 'PesaN Berhasil Dikirim',
            'data' => [
                'dataPesan' => $pesanData,
                'percakapan' => $percakapanPesan
            ]
        ];

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pesan  $pesan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pesan $pesan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pesan  $pesan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pesan $pesan)
    {
        if ($request->is_stars_click == 'true') {
            $pesan->is_stars = $pesan->is_stars == 1 ? 0 : 1;
            $pesan->save();
        }
        if ($request->is_read_click == 'true') {
            $pesan->is_read = 1;
            $pesan->save();
        }
        $response = [
            'status' => "Berhasil",
            'message' => 'Update Berhasil',
            'data' => $request->all()
        ];

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pesan  $pesan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pesan $pesan)
    {
        //
    }

    public function deleteBatch(Request $request)
    {
        Pesan::whereIn('id', $request->data)->update([
            'is_trash' => 1
        ]);
        $response = [
            'status' => "Berhasil",
            'message' => 'Delete Berhasil',
            'data' => $request->all()
        ];

        return response()->json($response);
    }
}
