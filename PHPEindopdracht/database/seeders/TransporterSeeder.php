<?php

namespace Database\Seeders;

use App\Models\Transporter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransporterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transporter::create(['name' => 'DHL'])->save();
        Transporter::create(['name' => 'UPS'])->save();
    }
}
