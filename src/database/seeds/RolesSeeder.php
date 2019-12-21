<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'applicant' => [
                'name' => 'applicant',
                'display_name' => 'applicant user',
                'description' => 'applies to be added to events and lists',
            ],
            'organiser' => [
                'name' => 'organiser',
                'display_name' => 'event organiser',
                'description' => 'organises and administers events and lists',
            ],
            'customer' => [
                'name' => 'customer',
                'display_name' => 'customer user',
                'description' => 'not sure yet need to figure this role out'
            ]
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'name' => $role['name'],
                'display_name' => $role['display_name'],
                'description' => $role['description'],
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', now()),
            ]);
        }
    }
}
