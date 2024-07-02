
## SIADAT V 1.0 
<p><b>
SIADAT adalah sistem terintegrasi yang menyediakan informasi lengkap mengenai adat istiadat dan budaya masyarakat Kampar. Dengan fitur pencarian dan penyimpanan data yang canggih, SIADAT menjadi sumber informasi yang handal.
</b></p>

## Instalasi
- download zip <a href="https://github.com/rahmathidayat9/laraschool/archive/master.zip">disini</a> 
- atau clone : git clone https://github.com/mahdiawan-nk/SIADAT.git

## Setup
- buka direktori project di terminal anda.
- ketikan command : cp .env.example .env (copy paste file .env.example)
- buat database 

Lalu ketik command dibawah ini
- composer install
- php artisan optimize:clear 
- php artisan key:generate (generate app key)
- php artisan migrate (migrasi database)
- php artisan db:seed 
- php artisan storage:link
- php artisan serve

## Login
- link panel admin tambahkan /panel-admin pada url contoh http://127.0.0.1/panel-admin
- Email : admin
- Password : 1234567

## Fitur
# Front / Depan
- Home (Halaman home,menampilkan berita,pengumuman terbaru)
- Profile (Visi Misi dan Sejarah)
- Informasi (Datouk Ninik Mamak dan Kenegerian)
- Adat & Istiadat (Adat Istiadat, Seni Tari, Seni Musik, Kuliner Khas, dan peninggalan)
- Berita (menampilkan seluruh berita yang ada)
- Kontak (menampilkan informasi kontak website)  

# admin
- Autentikasi (menggunakan Auth UI)
- Halaman Dashboard
- Manage User (CRUD)
- Manage Berita (CRUD dan Persetujuan Publish Berita)
- Manage Profil Visi Misi (CRU)
- Manage Profil Sejarah (CRU)
- Manage Informasi Datouk Ninik Mamak (CRUD dan Persetujuan Pengajuan Ninik Mamak)
- Manage Informasi Kenegerian (CRUD)
- Manage Adat Istiadat (CRUD dan Persestujuan Adat Istiadat)
- Manage Seni Tari (CRUD)
- Manage Seni Musik (CRUD)
- Manage Kuliner Khas (CRUD)
- Manage Peninggalan (CRUD)
- Manage Kontak (CRU)
- Perpesanan (Kirim Pesan, Balas Pesan, trash, inbox, Send, Stars, kirim dengan attachment)

# Operator
- Autentikasi (menggunakan Auth UI)
- Halaman Dashboard
- Manage Berita (CRUD)
- Manage Informasi Datouk Ninik Mamak (CRUD dan Persetujuan Pengajuan Ninik Mamak)
- Perpesanan (Kirim Pesan, Balas Pesan, trash, inbox, Send, Stars, kirim dengan attachment)