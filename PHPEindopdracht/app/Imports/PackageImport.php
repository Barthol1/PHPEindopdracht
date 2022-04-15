<?php

namespace App\Imports;

use App\Models\package;
use Error;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Symfony\Component\ErrorHandler\Debug;

class PackageImport implements ToModel, WithStartRow, WithCustomCsvSettings
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function model(array $row)
    {
        error_log($row[0]);
        return new package([
            'name' => rand(10000000, 999999999),
            'receiver_name' => $row[0],
            'status' => $row[1],
            'sender_adres' => $row[2],
            'sender_city' => $row[3],
            'sender_postalcode' => $row[4],
            'receiver_adres' => $row[5],
            'receiver_city' => $row[6],
            'receiver_postalcode' => $row[7],
            'users_id' => auth()->user()->id
        ]);
    }
}
