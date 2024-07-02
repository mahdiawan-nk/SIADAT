<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DatoukNinikMamak;
class BerkasPendukung extends Model
{
    use HasFactory;
    protected $fillable = ['id_ninik_mamak','nama_berkas','file'];

    public function ninikMamak(){
        
        return $this->belongsTo(DatoukNinikMamak::class,'id_ninik_mamak');
    }
}
