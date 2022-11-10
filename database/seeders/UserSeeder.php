<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            $faker = Faker::create();
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => bcrypt('12345678')
            ]);
        }
    }
}
