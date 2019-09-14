<?php

use Illuminate\Database\Seeder;

class ApplicantListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i <= 28; $i++) {
            DB::table('applicant_lists')->insert([
                'slot_id' => $faker->numberBetween(1, 10),
                'name' => $faker->word(),
                'max_applicants' => $faker->numberBetween(15, 25),
                'created_at' => $faker->dateTimeInInterval('1 day', 'now'),
            ]);
        }
    }
}
