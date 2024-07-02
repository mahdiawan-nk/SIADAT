<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Kenegerian;
use App\Models\Pesan;
use Illuminate\Support\Facades\Auth;
function DateTimes($date, $format = 'l, d F Y H:i:s')
{

    return Carbon::parse($date)->format($format);
}

function UserKenegerian($idKenegerian) {
    if($idKenegerian != null){
        $data = Kenegerian::where('id',$idKenegerian)->first()->nama_kenegerian;
    }else{
        $data = '';
    }
    
    return $data;
}

function widgetRecentMessage(){
    $dataPesan = Pesan::with(['userSender:id,nama_lengkap,email,username', 'userReceive:id,nama_lengkap,email'])->whereNull('percakapan_id');
    $dataPesan->where('is_trash', 0)->where('id_user_recieve', Auth::id());
    $listPesan = $dataPesan->latest('id')->limit(5)->get();

    return $listPesan;
}
