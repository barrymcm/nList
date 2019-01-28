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

        for ($a = 28; $a < 59; $a++) {

            for ($i = 1; $i < 15; $i++) {
                DB::table('applicants')->insert([
                    'list_id' => $a,
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'dob' => $faker->date(),
                    'gender' => $faker->randomElement(['male', 'female']),
                    'created_at' => $faker->dateTimeThisMonth('now')
                ]);
            }

        }
    }
}
