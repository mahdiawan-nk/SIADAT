<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Kenegerian;

class KenegerianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $messages = [];

        // 25 messages from user 1 to user 2
        for ($i = 0; $i < 12; $i++) {
            $createdAt = $faker->dateTimeThisYear;
            $updatedAt = $faker->dateTimeThisYear($createdAt);

            Kenegerian::create([
                'nama_kenegerian' => $faker->name(),
                'sejarah' => $faker->sentence(45),
                'foto' => 'static-file/news-sample.jpg',
                'catatan' => $faker->sentence(4),
                'alamat' => $faker->address,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }
    }
}
