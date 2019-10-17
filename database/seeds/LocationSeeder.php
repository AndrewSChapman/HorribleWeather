<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = time();

        // BRIGHTON
        DB::table('location')->insert([
            'id' => '46ea1164-8ab0-43e1-8daa-14e0a4d43c75',
            'created_at' => $now,
            'updated_at' => $now,
            'location' => 'Brighton,uk'
        ]);

        // LEEDS
        DB::table('location')->insert([
            'id' => '0e758170-f779-4550-8d30-0cff1259ca11',
            'created_at' => $now,
            'updated_at' => $now,
            'location' => 'Leeds,uk'
        ]);
    }
}
