<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicantSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 0; $i < 5; $i++) {
            DB::table('applicants')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'dob' => $faker->date(),
                'gender' => $faker->randomElement(['male', 'female']),
                'created_at' => $faker->dateTimeThisMonth('now')
            ]);
        }
    }
}
