<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Profil::where('type_profil', $request->type)->first();
        $response = [
            'status' => 'OK',
            'data' => [
                'id' => $data ? $data->id : null,
                'type_profil' => $data ? $data->type_profil : '',
                'content' => html_entity_decode($data ? $data->content : '')
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
        $profil = Profil::where('id', $request->id);
        if ($profil->exists()) {
            Profil::where('id',$request->id)->update([
                'content'=>$request->content,
                'slug' => $request->type_profil == 1 ? 'visi-misi-'.time() : 'sejarah-'.time(),
                'type_profil'=>$request->type_profil
            ]);
            $response = [
                'status' => 'OK',
                'message' => 'Profile updated'
            ];
        } else {
            Profil::create([
                'content'=>$request->content,
                'slug' => $request->type_profil == 1 ? 'visi-misi-'.time() : 'sejarah-'.time(),
                'type_profil'=>$request->type_profil
            ]);
            $response = [
                'status' => 'OK',
                'message' => 'Profile inserted'
            ];
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function show(Profil $profil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function edit(Profil $profil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profil $profil)
    {
        if ($profil->exists()) {
            $response = [
                'status' => 'OK',
                'message' => 'Profile updated'
            ];
        } else {
            $response = [
                'status' => 'OK',
                'message' => 'Profile inserted'
            ];
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profil $profil)
    {
        //
    }
}
