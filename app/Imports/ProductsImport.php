<?php

namespace App\Imports;

use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ProductsImport implements WithHeadingRow, WithUpserts, WithStartRow, SkipsOnFailure, SkipsOnError, SkipsEmptyRows, ToModel
{
    use SkipsFailures, SkipsErrors;

    public function headingRow(): int
    {
        return 7;
    }

    public function startRow(): int
    {
        return 9;
    }

    public function uniqueBy(): string
    {
        return 'elsie_code';
    }

    public function model(array $row)
    {
        if (is_null($row['kod_skladskoi']) && is_null($row['naimenovanie']) && is_null($row['razmer']) && is_string($row['kod_elsi'])) {
            return null;
        }

        if (is_string($row['kod_elsi']) && is_string($row['naimenovanie'])) {
            if (str_starts_with($row['kod_elsi'], '3985')) {
                $row['kod_elsi'] = str_replace('3985', '39B5', $row['kod_elsi']);
            }

            $parsed = Product::parseCode($row['kod_elsi']);

            return Product::query()->firstOrCreate([
                'elsie_code' => $row['kod_elsi'],
            ], [
                'name' => $row['naimenovanie'],
                'size' => $row['razmer'],
                'stock_code' => $row['kod_skladskoi'],
                'manufacturer_id' => $parsed['manufacturer_code']
                    ? optional(Product::suggestedManufacturer($parsed['manufacturer_code']) ?? null, function (Manufacturer $manufacturer) {
                        return $manufacturer->id;
                    })
                    : null,
                'vehicle_id' => $parsed['vehicle_code']
                    ? optional(Vehicle::query()->firstWhere('code', '=', $parsed['vehicle_code']) ?? null, function (Vehicle $vehicle) {
                        return $vehicle->id;
                    })
                    : null,
            ]);
        }
        return null;
    }
}
