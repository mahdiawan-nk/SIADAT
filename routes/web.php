<?php

use App\Http\Controllers\AdatIstiadatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DatoukNinikMamakController;
use App\Http\Controllers\FrontEndSiteController;
use App\Http\Controllers\InformasiBudayaController;
use App\Http\Controllers\InformasiKontakController;
use App\Http\Controllers\KenegerianController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [FrontEndSiteController::class, 'index'])->name('home');

Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/visi-misi', [FrontEndSiteController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/sejarah', [FrontEndSiteController::class, 'sejarah'])->name('sejarah');
});

Route::prefix('informasi')->name('informasi.')->group(function () {
    Route::get('/ninik-mamak', [FrontEndSiteController::class, 'ninikMamak'])->name('ninik-mamak');
    Route::get('/kenegerian', [FrontEndSiteController::class, 'kenegerian'])->name('kenegerian');
});
Route::get('kebudayaan/{pages}', [FrontEndSiteController::class, 'kebudayaan'])->name('kebudayaan.page');
Route::get('berita', [FrontEndSiteController::class, 'berita'])->name('berita');
Route::get('berita/{slug}', [FrontEndSiteController::class, 'beritaread'])->name('berita.slug');
Route::get('kontak', [FrontEndSiteController::class, 'kontak'])->name('kontak');

Route::get('/register', function () {
    return view('pages_admin.registrasi');
})->name('register');
Route::post('registrasi/save',[AuthController::class,'registrasi'])->name('registrasi.save');
Route::prefix('panel-admin')->name('panel-admin.')->group(function () {
    Route::get('/', function () {
        return view('pages_admin.login');
    })->name('login');

    Route::get('/dashboard', function () {
        return view('pages_admin.dashboard');
    })->name('home')->middleware('auth.web');


    Route::get('berita', function () {
        return view('pages_admin.berita.index');
    })->name('berita')->middleware('auth.web');

    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/visi-misi', function () {
            return view('pages_admin.visi-misi.index');
        })->name('visi-misi')->middleware('auth.web');
        Route::get('/sejarah', function () {
            return view('pages_admin.sejarah.index');
        })->name('sejarah')->middleware('auth.web');
    });

    Route::prefix('informasi')->name('informasi.')->group(function () {
        Route::get('/ninik-mamak', function () {
            return view('pages_admin.ninik-mamak.index');
        })->name('ninik-mamak')->middleware('auth.web');
        Route::get('/kenegerian', function () {
            return view('pages_admin.kenegerian.index');
        })->name('kenegerian')->middleware('auth.web');
    });

    Route::prefix('adat-kebudayaan')->name('adat-kebudayaan.')->group(function () {
        Route::get('/adat-istiadat', function () {
            return view('pages_admin.adat-istiadat.index');
        })->name('adat-istiadat')->middleware('auth.web');
        Route::get('/seni-tari', function () {
            return view('pages_admin.informasi-budaya.index', ['jenis' => 'seni_tari', 'field' => 'Nama Tari', 'title' => 'Data Seni Tari']);
        })->name('seni-tari')->middleware('auth.web');
        Route::get('/seni-musik', function () {
            return view('pages_admin.informasi-budaya.index', ['jenis' => 'seni_musik', 'field' => 'Nama Musik', 'title' => 'Data Seni Musik']);
        })->name('seni-musik')->middleware('auth.web');
        Route::get('/kuliner-khas', function () {
            return view('pages_admin.informasi-budaya.index', ['jenis' => 'kuliner_khas', 'field' => 'Nama Kuliner', 'title' => 'Data Kuliner Khas']);
        })->name('kuliner-khas')->middleware('auth.web');
        Route::get('/peninggalan', function () {
            return view('pages_admin.informasi-budaya.index', ['jenis' => 'peninggalan', 'field' => 'Nama Peninggalan', 'title' => 'Data Peninggalan']);
        })->name('peninggalan')->middleware('auth.web');
    });

    Route::get('kontak', function () {
        return view('pages_admin.kontak.index');
    })->name('kontak')->middleware('auth.web');
    Route::get('pesan', function () {
        return view('pages_admin.pesan.index');
    })->name('pesan')->middleware('auth.web');
    Route::get('manajemen-akun', function () {
        return view('pages_admin.user.index');
    })->name('akun')->middleware('auth.web');
});


Route::post('/flmngr', function () {

    \EdSDK\FlmngrServer\FlmngrServer::flmngrRequest(
        array(
            'dirFiles' => base_path() . '/public/storage/file-manager'
        )
    );
});
Route::prefix('api-resource')->name('api.')->group(function () {
    Route::post('/auth-user', [AuthController::class, '_authenticate'])->name('auth.user');
    Route::get('me', [AuthController::class, 'me'])->name('auth.me');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::put('users/reset-password/{user}', [UserController::class, 'resetPassword'])->name('user.reset.password');
    Route::resource('users', UserController::class, ['except' => ['create', 'edit']]);
    Route::put('berita/persetujuan/{beritum}', [BeritaController::class, 'updatePersetujuan'])->name('berita.persetujuan');
    Route::resource('berita', BeritaController::class, ['except' => ['create', 'edit']]);
    Route::resource('profil', ProfilController::class, ['except' => ['create', 'edit']]);
    Route::resource('filemanager', FileManagerController::class, ['except' => ['create', 'edit']]);
    Route::put('ninik-mamak/persetujuan/{ninik_mamak}', [DatoukNinikMamakController::class, 'updatePersetujuan'])->name('ninik-mamak.persetujuan');
    Route::resource('ninik-mamak', DatoukNinikMamakController::class, ['except' => ['create', 'edit']]);
    Route::resource('kenegerian', KenegerianController::class, ['except' => ['create', 'edit']]);
    Route::put('adat-istiadat/persetujuan/{adat_istiadat}', [AdatIstiadatController::class, 'updatePersetujuan'])->name('adat-istiadat.persetujuan');
    Route::resource('adat-istiadat', AdatIstiadatController::class, ['except' => ['create', 'edit']]);
    Route::resource('informasi-budaya', InformasiBudayaController::class, ['except' => ['create', 'edit']]);
    Route::resource('informasi-kontak', InformasiKontakController::class, ['except' => ['create', 'edit']]);
    Route::post('pesan/delete/batch', [PesanController::class, 'deleteBatch'])->name('pesan.delete.batch');
    Route::resource('pesan', PesanController::class, ['except' => ['create', 'edit']]);
});
