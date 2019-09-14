<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicantDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 14; $i++) {
            DB::table('applicant_details')->insert([
                'applicant_id' => $i,
                'email' => $faker->email,
                'phone' => 012434567,
                'address_1' => $faker->streetName,
                'address_2' => $faker->streetAddress,
                'address_3' => $faker->secondaryAddress,
                'city' => $faker->city,
                'post_code' => $faker->postcode,
                'country' => $faker->countryCode,
            ]);
        }
    }
}
