<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kenegerian;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdatIstiadat extends Model
{
    use HasFactory;
    protected $fillable = ['nama_adat', 'id_kenegerian', 'ringkasan', 'catatan', 'foto', 'lokasi', 'status', 'id_user'];

    public function kenegerian()
    {
        return $this->hasOne(Kenegerian::class, 'id', 'id_kenegerian');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }


    public static function getDataTables()
    {
        $query = self::with(['kenegerian:id,nama_kenegerian', 'user:id,username'])->latest('id');
        if(auth()->user()->role == 2){
            $query->where('id_user',Auth::id());
        }
        $data = $query->get();
        $dataTable = DataTables::of($data);
        $dataTable->addIndexColumn()
            ->addColumn('contents', function ($row) {
                return html_entity_decode($row->ringkasan);
            })
            ->addColumn('catatans', function ($row) {
                $notes = json_decode($row->catatan);
                foreach ($notes as $item) {
                    $item->last_time = Carbon::parse($item->created_at)->diffForHumans();
                }
                return $notes;
            })
            ->addColumn('thumbnails', function ($row) {
                return '<img src="' . asset($row->foto) . '" class="img-thumbnail w-75"/>';
            })
            ->addColumn('action', function ($row) {
                // if (auth()->user()->role == 2) {
                return '<button class="btn btn-sm btn-secondary me-1 edit">Edit</button><button class="btn btn-sm btn-danger hapus">Hapus</button>';
                // } else {
                //     return '<button class="btn btn-sm btn-secondary me-1 persetujuan">Persetujuan</button>';
                // }
            })
            ->rawColumns(['contents', 'thumbnails', 'action']);

        return $dataTable->make(true);
    }

    public static function createData(array $data)
    {
        $catatan = [
            'user' => auth()->user()->username,
            'status' => 'Prosess',
            'pesan' => 'User ' . auth()->user()->username . ' Membuat Pengajuan',
            'created_at' => now(),
        ];
        $currentCatatan[] = $catatan;
        $adatIstiadat = new self();
        $adatIstiadat->nama_adat = $data['nama_adat'];
        $adatIstiadat->id_kenegerian = $data['id_kenegerian'];
        $adatIstiadat->ringkasan = $data['ringkasan'];
        $adatIstiadat->catatan = json_encode($currentCatatan);
        $adatIstiadat->foto = $data['foto'];
        $adatIstiadat->lokasi = $data['lokasi'];
        $adatIstiadat->status = 0;
        $adatIstiadat->id_user = Auth::id();
        $adatIstiadat->save();

        return $adatIstiadat;
    }

    public function updateData(array $requestData)
    {
        $status = $this->status;

        $catatanPenolakan = [
            'user' => auth()->user()->username,
            'status' => $status,
            'pesan' => 'User ' . auth()->user()->username . ' Melakukan Perubahan',
            'created_at' => now(),
        ];

        // Ambil data catatan saat ini
        $currentCatatan = $this->catatan ? json_decode($this->catatan, true) : [];

        // Tambahkan catatan baru
        $currentCatatan[] = $catatanPenolakan;

        // Simpan kembali dalam format JSON
        $requestData['catatan'] = json_encode($currentCatatan);

        $this->fill($requestData)->save();

        return $this;
    }
    public function updatePersetujuan($status, $message)
    {
        $this->status = $status;

        $catatanPenolakan = [
            'user' => auth()->user()->username,
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
