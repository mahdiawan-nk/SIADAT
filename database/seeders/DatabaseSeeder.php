<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(KenegerianTableSeeder::class);
        sleep(2);
        User::create([
            'nama_lengkap'=>'administrator',
            'username'=>'admins',
            'role'=>1,
            'email'=>'administrator@mail.com',
            'password'=>Hash::make('12345678'),
        ],[
            'nama_lengkap'=>'operator 1',
            'username'=>'operator 1',
            'role'=>2,
            'id_kenegerian'=>1,
            'email'=>'operator1@mail.com',
            'password'=>Hash::make('12345678'),
        ]);
        sleep(2);
        $this->call(BeritaTableSeeder::class);

    }
}
