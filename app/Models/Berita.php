<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Berita extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul', 'slug','isi','thumbnail', 'catatan','status','created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatePersetujuan($status, $message)
    {
        $this->status = $status;

        $catatanPenolakan = [
            'user'=>auth()->user()->username,
            'status' => $status == 1 ? 'Setujui' : 'Tolak',
            'pesan' => $message,
            'created_at' => now(),
        ];

        // Ambil data catatan saat ini
        $currentCatatan = $this->catatan ? json_decode($this->catatan, true) : [];

        // Tambahkan catatan baru
        $currentCatatan[] = $catatanPenolakan;

        // Simpan kembali dalam format JSON
        $this->catatan = json_encode($currentCatatan);

        return $this->save();
    }
}
