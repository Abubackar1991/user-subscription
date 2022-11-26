<?php

namespace Database\Seeders;
use App\Models\Plan;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    $datarole = [
            [
                'id' => '1',
                'plan_name' => 'Free',
                'days' => '10',
                'created' => date('Y-m-d H:i:s')
            ],[
                'id' => '2',
                'plan_name' => 'Silver',
                'days' => '100',
                'created' => date('Y-m-d H:i:s')
            ],[
                'id' => '3',
                'plan_name' => 'Gold',
                'days' => '500',
                'created' => date('Y-m-d H:i:s')
            ]
        ];
        Plan::insert($datarole);
    }
}
