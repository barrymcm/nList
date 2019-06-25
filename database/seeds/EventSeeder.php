<?php

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 5; $i++) {
            DB::table('events')->insert([
                'slots' => $faker->numberBetween(1, 4),
                'category_id' => $faker->numberBetween(1, 6),
                'name' => $faker->word,
                'description' => $faker->sentence(10),
                'created_at' => $faker->dateTimeInInterval('1 day', 'now')
            ]);
        }
    }
}
