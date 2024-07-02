<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AdatIstiadat;
use App\Models\DatoukNinikMamak;
use Exception;

class Kenegerian extends Model
{
    use HasFactory;
    protected $fillable = ['nama_kenegerian', 'sejarah', 'alamat', 'foto', 'catatan'];

    public function adatIstiadats()
    {
        return $this->hasMany(AdatIstiadat::class, 'id_kenegerian');
    }

    public function datoukNinikMamaks()
    {
        return $this->hasMany(DatoukNinikMamak::class, 'id_kenegerian');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($kenegerian) {
            $errorMessages = [];

            // Cek apakah ada adat istiadat terkait
            if ($kenegerian->adatIstiadats()->count() > 0) {
                $errorMessages[] = 'data adat istiadat terkait.';
            }

            // Cek apakah ada datouk ninik mamak terkait
            if ($kenegerian->datoukNinikMamaks()->count() > 0) {
                $errorMessages[] = 'data datouk ninik mamak terkait.';
            }

            // Lempar pengecualian jika terdapat pesan kesalahan
            if (!empty($errorMessages)) {
                throw new Exception(implode(' ', $errorMessages));
            }
        });
    }
}
