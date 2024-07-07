<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Profil;
use App\Models\DatoukNinikMamak as NinikMamaks;
use App\Models\Kenegerian;
use App\Models\AdatIstiadat;
use App\Models\InformasiBudaya;
use App\Models\InformasiKontak;
class FrontEndSiteController extends Controller
{
    protected $data;
    public function index()
    {
        $this->data = [
            'berita' => Berita::with('user:id,nama_lengkap')->where('status',1)->limit(6)->latest('id')->get()
        ];
        return view('pages_site.index', $this->data);
    }

    public function visiMisi()
    {
        $this->data = [
            'title' => 'Visi Misi',
            'data' => Profil::where('type_profil', 1)->first()
        ];
        return view('pages_site.profile', $this->data);
    }

    public function Sejarah()
    {
        $this->data = [
            'title' => 'Sejarah',
            'data' => Profil::where('type_profil', 2)->first()
        ];
        return view('pages_site.profile', $this->data);
    }

    public function ninikMamak()
    {
        $this->data = [
            'title' => 'Datouk Ninik Mamak',
            'data' => NinikMamaks::with('kenegerian:id,nama_kenegerian')->where('status',1)->get()
        ];
        return view('pages_site.datouk', $this->data);
    }

    public function kenegerian()
    {
        $this->data = [
            'title' => 'Kenegerian',
            'data' => Kenegerian::paginate(6)
        ];
        return view('pages_site.kenegerian', $this->data);
    }

    public function kebudayaan($pages)
    {
        if ($pages == 'adat-istiadat') {
            $this->data = [
                'title' => 'Adat Istiadat',
                'data' => AdatIstiadat::with('kenegerian:id,nama_kenegerian')->where('status',1)->paginate(6)
            ];
            $viewsPages = 'adat_istiadat';
        } else {
            $pages = str_replace('-', '_', $pages);
            $this->data = [
                'title' => ucwords(str_replace('-', ' ', $pages)),
                'data' => InformasiBudaya::where('jenis', $pages)->paginate(6)
            ];
            $viewsPages = 'kebudayaan';
        }

        return view('pages_site.' . $viewsPages, $this->data);
    }
    public function berita()
    {
        $this->data = [
            'title' => 'Berita',
            'data' => Berita::with('user:id,nama_lengkap')->where('status',1)->latest('id')->paginate(12)
        ];
        return view('pages_site.berita', $this->data);
    }

    public function beritaRead($slug)
    {
        $this->data = [
            'title' => 'Baca Berita',
            'data' => Berita::with('user:id,nama_lengkap')->where('slug', $slug)->first(),
            'recent_post' => Berita::limit(6)->where('status',1)->latest('id')->get()

        ];
        return view('pages_site.berita_detail', $this->data);
    }
    public function kontak()
    {
        $this->data = [
            'title' => 'Kontak',
            'data' => InformasiKontak::latest('id')->first(),
        ];
        return view('pages_site.kontak', $this->data);
    }
}
