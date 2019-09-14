<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['sport', 'news', 'music', 'business', 'motoring'];
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 5; $i++) {
            DB::table('categories')->insert([
                'name' => $categories[$i],
                'description' => $faker->sentence(15),
                'created_at' => $faker->dateTimeInInterval('1 day', 'now'),
            ]);
        }
    }
}
