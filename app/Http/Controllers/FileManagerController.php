<?php

namespace App\Http\Controllers;

use App\Models\FileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $idUser = auth()->id();
        $data = FileManager::where('id_user', $idUser);
        if($request->input('type')){
            $data->where('jenis_file',$request->input('type'));
        }
        $result = $data->orderBy('di','desc')->get();
        foreach ($result as $item) {
            $item->url = Storage::url($item->path);
            $item->url_thumbnail = Storage::url($item->thumbnail_path);
        }
        $response = [
            'status' => "Berhasil",
            'data' => $result
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
        $uploadFile = new FileManager();
        $files = $request->file('file');
        $fileName = $files->getClientOriginalName();
        $filePath = $files->storeAs('public/file-manager', $fileName);

        // Buat thumbnail image
        $thumbnailPath = 'public/file-manager/thumbnails/' . $fileName;
        $thumbnailImage = Image::make($files)->resize(150, 150, function ($constraint) {
            $constraint->upsize();
        });
        Storage::put($thumbnailPath, (string) $thumbnailImage->encode());

        $uploadFile->path = $filePath;
        $uploadFile->file = $fileName;
        $uploadFile->thumbnail_path = $thumbnailPath; // Tambahkan field thumbnail_path pada model
        $uploadFile->id_user = auth()->id();
        $uploadFile->save();

        $data = FileManager::latest()->first();
        $response = [
            'status' => "Berhasil",
            'data' => $data,
            'url_images' => Storage::url($data->path),
            'url_thumbnail' => Storage::url($data->thumbnail_path) // Tambahkan URL thumbnail
        ];
        return response()->json($response);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileManager  $fileManager
     * @return \Illuminate\Http\Response
     */
    public function show(FileManager $fileManager)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileManager  $fileManager
     * @return \Illuminate\Http\Response
     */
    public function edit(FileManager $fileManager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FileManager  $fileManager
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FileManager $fileManager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileManager  $fileManager
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileManager $fileManager)
    {
        //
    }
}
