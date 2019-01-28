<?php

use Illuminate\Database\Seeder;

class SlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i <= 9; $i++) {
            DB::table('slots')->insert([
                'event_id' => $faker->numberBetween(1, 5),
                'name' => $faker->sentence(2),
                'slot_capacity' => $faker->numberBetween(10, 15),
                'start_date' => $faker->dateTimeThisMonth('+ 5 days', '+ 40 days'),
                'end_date' => $faker->dateTimeInInterval('+ 50 days', '+ 100 days'),
                'created_at' => $faker->dateTimeInInterval('-1 day', 'now'),
            ]);
        }
    }
}
