<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;
class InformasiBudaya extends Model
{
    use HasFactory;
    protected $fillable = ['jenis','nama','jenis_peninggalan','lokasi','ringkasan','foto'];

    public static function getDataTables($jenisData)
    {
        $query = self::latest('id');
        $query->where('jenis',$jenisData);
        $data = $query->get();
        $dataTable = DataTables::of($data);
        $dataTable->addIndexColumn()
            ->addColumn('contents', function ($row) {
                return html_entity_decode($row->ringkasan);
            })
            ->addColumn('thumbnails', function ($row) {
                return '<img src="' . asset($row->foto) . '" class="img-thumbnail w-75"/>';
            })
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-secondary me-1 edit">Edit</button><button class="btn btn-sm btn-danger hapus">Hapus</button>';

            })
            ->rawColumns(['contents', 'thumbnails', 'action']);

        return $dataTable->make(true);
    }

    public static function createData(array $data)
    {
        $informasiBudaya = self::create($data);
        return $data;
    }

    public function updateData(array $requestData)
    {
        $this->fill($requestData)->save();

        return $this;
    }
}
