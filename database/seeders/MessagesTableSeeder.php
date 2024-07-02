<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MessagesTableSeeder extends Seeder
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
        for ($i = 0; $i < 25; $i++) {
            $createdAt = $faker->dateTimeThisYear;
            $updatedAt = $faker->dateTimeThisYear($createdAt);
            $messages[] = [
                'percakapan_id' => null,
                'id_user_sender' => 1,
                'id_user_recieve' => 2,
                'body' => $faker->text,
                'subject' => $faker->sentence,
                'is_read' => $faker->boolean,
                'is_stars' => $faker->boolean,
                'is_trash' => $faker->boolean,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ];
        }

        // 25 messages from user 2 to user 1
        for ($i = 0; $i < 25; $i++) {
            $createdAt = $faker->dateTimeThisYear;
            $updatedAt = $faker->dateTimeThisYear($createdAt);
            $messages[] = [
                'percakapan_id' => null,
                'id_user_sender' => 2,
                'id_user_recieve' => 1,
                'body' => $faker->text,
                'subject' => $faker->sentence,
                'is_read' => $faker->boolean,
                'is_stars' => $faker->boolean,
                'is_trash' => $faker->boolean,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ];
        }

        DB::table('pesans')->insert($messages);
    }
}
