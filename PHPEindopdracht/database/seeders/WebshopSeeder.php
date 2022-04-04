<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('webshops')->insert([
            'name' => 'Pieters Bloemen',
            'adres' => 'Bloemenlaan 43',
            'place' => 'Amsterdam',
            'postalcode' => '8574VV'
        ]);
        DB::table('webshops')->insert([
            'name' => 'Span Moorkoppen',
            'adres' => 'Kerkstraat 45',
            'place' => 'Leerdam',
            'postalcode' => '4646VW'
        ]);
    }
}
