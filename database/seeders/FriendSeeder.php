<?php

namespace Database\Seeders;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FriendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        for ($i = 0; $i < 100; $i++) {
            $accepted = $faker->randomElement([true, false]);
            Friend::create([
                'user_id' => User::all()->random()->id,
                'friend_id' => User::all()->random()->id,
                'accepted' => $accepted
            ]);
        }
    }
}
