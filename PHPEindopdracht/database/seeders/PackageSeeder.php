<?php

namespace Database\Seeders;

use App\Models\Package;
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
            'name' => rand(10000000, 999999999),
            'status' => 'Aangemeld',
            'sender_adres' => str::random(10),
            'sender_city' => str::random(10),
            'sender_postalcode' => str::random(10),
            'receiver_name' => str::random(10),
            'receiver_adres' => str::random(10),
            'receiver_city' => str::random(10),
            'receiver_postalcode' => str::random(10),
            'users_id' => 1
        ];
        Package::create($sampledata);
        $sampledata = [
            'name' => rand(10000000, 999999999),
            'status' => 'Afgeleverd',
            'sender_adres' => str::random(10),
            'sender_city' => str::random(10),
            'sender_postalcode' => str::random(10),
            'receiver_name' => str::random(10),
            'receiver_adres' => str::random(10),
            'receiver_city' => str::random(10),
            'receiver_postalcode' => str::random(10),
            'users_id' => 1
        ];
        Package::create($sampledata);
        $sampledata = [
            'name' => rand(10000000, 999999999),
            'status' => 'Onderweg',
            'sender_adres' => str::random(10),
            'sender_city' => str::random(10),
            'sender_postalcode' => str::random(10),
            'receiver_name' => str::random(10),
            'receiver_adres' => str::random(10),
            'receiver_city' => str::random(10),
            'receiver_postalcode' => str::random(10),
            'users_id' => 1
        ];
        Package::create($sampledata);
    }
}
