<?php

namespace Database\Seeders;

use App\Models\package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sampledata = [
            'name' => str::random(10),
            'status' => 'Aangemeld',
            'sender_adres' => str::random(10),
            'sender_city' => str::random(10),
            'sender_postalcode' => str::random(10),
            'receiver_adres' => str::random(10),
            'receiver_city' => str::random(10),
            'receiver_postalcode' => str::random(10),
        ];
        Package::create($sampledata);
        $sampledata = [
            'name' => str::random(10),
            'status' => 'Afgeleverd',
            'sender_adres' => str::random(10),
            'sender_city' => str::random(10),
            'sender_postalcode' => str::random(10),
            'receiver_adres' => str::random(10),
            'receiver_city' => str::random(10),
            'receiver_postalcode' => str::random(10),
        ];
        Package::create($sampledata);
        $sampledata = [
            'name' => str::random(10),
            'status' => 'Onderweg',
            'sender_adres' => str::random(10),
            'sender_city' => str::random(10),
            'sender_postalcode' => str::random(10),
            'receiver_adres' => str::random(10),
            'receiver_city' => str::random(10),
            'receiver_postalcode' => str::random(10),
        ];
        Package::create($sampledata);
    }
}
