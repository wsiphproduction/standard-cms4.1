<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DentistsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dentists')->insert([
            'first_name' => Str::random(10),
            'middle_name' => Str::random(10),
            'last_name' => Str::random(10),
            'region' => Str::random(10),
            'province' => Str::random(10),
            'city' => Str::random(10),
            'full_address' => Str::random(10),
            'specialization' => Str::random(10),
            'contact_number' => mt_rand(999,9999)

        ]);
    }
}
