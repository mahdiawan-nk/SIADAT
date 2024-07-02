<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Pesan extends Model
{
    use HasFactory;

    protected $fillable = ['percakapan_id', 'id_user_sender', 'id_user_recieve', 'body', 'subject', 'is_read', 'is_stars', 'is_trash', 'attachment'];

    public function userSender()
    {
        return $this->belongsTo(User::class, 'id_user_sender');
    }

    public function userReceive()
    {
        return $this->belongsTo(User::class, 'id_user_recieve');
    }

    public static function getInbox($jenisPesan)
    {
        $dataPesan = self::with(['userSender:id,nama_lengkap,email', 'userReceive:id,nama_lengkap,email'])->whereNull('percakapan_id');
        if($jenisPesan == 'inbox'){
            $dataPesan->where('is_trash', 0)->where('id_user_recieve', Auth::id());
            $listPesan = $dataPesan->latest('id')->paginate(10);
        }
        if($jenisPesan == 'send'){
            $dataPesan->where('is_trash', 0)->where('id_user_sender', Auth::id());
            $listPesan = $dataPesan->latest('id')->paginate(10);
        }
        if($jenisPesan == 'trash'){
            $dataPesan->where('is_trash', 1)->where('id_user_recieve', Auth::id());
            $listPesan = $dataPesan->latest('id')->paginate(10);
        }
        if($jenisPesan == 'stars'){
            $dataPesan->where('is_stars', 1)->where('id_user_recieve', Auth::id());
            $listPesan = $dataPesan->latest('id')->paginate(10);
        }
        
        
        foreach ($listPesan as $item) {
            if ($item->created_at instanceof Carbon) {
                // Hitung perbedaan waktu dari created_at sampai sekarang
                $diff = $item->created_at->diffForHumans();

                // Tentukan format berdasarkan kondisi waktu yang diinginkan
                if ($item->created_at->diffInMonths() >= 1) {
                    $item->last_time = $item->created_at->format('d M Y');
                } elseif ($item->created_at->diffInHours() >= 24) {
                    // Lebih dari satu hari, tampilkan tanggal bulan
                    $item->last_time = $item->created_at->format('d M');
                } elseif ($item->created_at->diffInMinutes() >= 1) {
                    $item->last_time = $item->created_at->format('H:i');
                } else {
                    // Kurang dari 10 menit, gunakan diffForHumans() bawaan untuk format default
                    $item->last_time = $diff;
                }
            }
        }
        return $listPesan;
    }
}
