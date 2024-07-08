<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiKontak extends Model
{
    use HasFactory;
    protected $fillable = ['surel','telephone','alamat','catatan'];

    public static function getDataKontak(){

        return self::latest()->first();
    }

    public static function createData(array $data){
        return self::create($data);
    }

    public static function updateData(array $data,$id){
        
        return self::where('id',$id)->update($data);
    }

}
