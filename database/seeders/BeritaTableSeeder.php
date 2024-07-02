<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;
use Faker\Factory as Faker;
class BeritaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 12; $i++) {
            Berita::create([
                'judul'=>$faker->sentence(5),
                'slug'=>$i.'-berita-' . time() . '-' . date('d-m-y'),
                'isi'=>$faker->paragraph(5),
                'thumbnail'=>'static-file/news-sample.jpg', 
                'status'=>0,
                'created_by'=>2,
            ]);
        }
    }
}
