<?php

use Illuminate\Database\Seeder;

class EventOrganisers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $organisers = [
            'uci', 'dundrum housing coop', 'misc events',
            'bray wheelers', 'carlow cc', 'tiernans cc', 'wesportcc'
        ];

        foreach($organisers as $organiser) {
            DB::table('event_organisers')->insert([
                    'name' => $organiser,
                    'description' => $faker->sentence(10),
                    'created_at' => $faker->dateTimeInInterval('1 day', 'now')
                ]
            );
        }
    }
}
