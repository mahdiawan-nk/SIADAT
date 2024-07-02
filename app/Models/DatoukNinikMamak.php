<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kenegerian;
use App\Models\User;
use App\Models\BerkasPendukung;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DatoukNinikMamak extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'gelar', 'alamat', 'id_kenegerian', 'suku', 'id_user', 'status', 'catatan'];

    public function kenegerian()
    {
        return $this->hasOne(Kenegerian::class, 'id', 'id_kenegerian');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function berkasPendukung()
    {
        return $this->hasMany(BerkasPendukung::class, 'id_ninik_mamak');
    }

    /**
     * Create DatoukNinikMamak with BerkasPendukung.
     *
     * @param array $data
     * @return DatoukNinikMamak
     */
    public static function createWithBerkas(array $data)
    {
        $catatan = [
            'user'=>auth()->user()->username,
            'status' => 'Prosess',
            'pesan' => 'User ' . auth()->user()->username . ' Membuat Pengajuan',
            'created_at' => now(),
        ];
        $currentCatatan[] = $catatan;
        $ninikMamak = new self();
        $ninikMamak->nama = $data['nama'];
        $ninikMamak->gelar = $data['gelar'] ?? null;
        $ninikMamak->suku = $data['suku'];
        $ninikMamak->alamat = $data['alamat'];
        $ninikMamak->id_kenegerian = $data['id_kenegerian'];
        $ninikMamak->status = 0;
        $ninikMamak->catatan = json_encode($currentCatatan);
        $ninikMamak->id_user = Auth::id();
        $ninikMamak->save();

        foreach ($data['file'] as $index => $file) {

            $insertBerkas = new BerkasPendukung();
            $insertBerkas->id_ninik_mamak = $ninikMamak->id;
            $insertBerkas->nama_berkas = $data['nama_berkas'][$index];
            $insertBerkas->file = $file;
            $insertBerkas->save();
        }

        return $ninikMamak;
    }

    public static function getDataTables()
    {
        $query = self::with(['kenegerian:id,nama_kenegerian', 'user:id,username', 'berkasPendukung'])->latest('id');
        if(auth()->user()->role == 2){
            $query->where('id_user',Auth::id());
        }
        $data = $query->get();
        $dataTable = DataTables::of($data);
        $dataTable->addIndexColumn()
            ->addColumn('catatans', function ($row) {
                $notes= json_decode($row->catatan);
                foreach ($notes as $item) {
                    $item->last_time = Carbon::parse($item->created_at)->diffForHumans();
                }
                return $notes;
            })
            ->addColumn('action', function ($row) {
                if (auth()->user()->role == 2) {
                    return '<button class="btn btn-sm btn-secondary me-1 edit">Edit</button><button class="btn btn-sm btn-danger hapus">Hapus</button>';
                } else {
                    return '<button class="btn btn-sm btn-secondary me-1 persetujuan">Persetujuan</button><button class="btn btn-sm btn-secondary me-1 edit">Edit</button><button class="btn btn-sm btn-danger hapus">Hapus</button>';
                }
            })
            ->rawColumns(['action']);

        return $dataTable->make(true);
    }

    /**
     * Update approval status and add rejection note.
     *
     * @param int $status
     * @param string $message
     * @return bool
     */
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
