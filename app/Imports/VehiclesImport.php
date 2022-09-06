<?php

namespace App\Imports;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class VehiclesImport implements ToModel, WithHeadingRow, WithUpserts, SkipsEmptyRows, WithValidation, SkipsOnFailure, WithStartRow
{
    use SkipsErrors;
    use SkipsFailures;

    /**
     * @param array $row
     *
     * @return Model|Vehicle|null
     */
    public function model(array $row)
    {
        if (str_contains($row['model'], 'Нераспознанное') || str_contains($row['tipy_kuzova'], 'Нераспознанное')) {
            return null;
        }

        if (empty($row['god_nacala_vypuska']) || empty($row['tipy_kuzova'])) {
            return null;
        }

        return optional(Vehicle::query()->firstOrCreate([
                'code' => $row['kod_modeli'],
            ], [
                'name' => $row['model'],
                'bodytypes' => explode(',', $row['tipy_kuzova']),
                'year_start' => $row['god_nacala_vypuska'],
                'year_end' => $row['god_okoncaniya_vypuska'],
                'full_name' => $this->getFullName($row),
            ]) ?? null, function (Vehicle $vehicle) {

            if ($vehicle->code === '3985') {
                $vehicle->update([
                    'code' => '39B5',
                ]);
            }

            return $vehicle;
        });
    }

    public function headingRow(): int
    {
        return 7;
    }

    public function uniqueBy(): string
    {
        return 'code';
    }

    public function rules(): array
    {
        return [
            'model' => [
                'required',
            ],
            'tipy_kuzova' => [
                'nullable',
            ],
            'god_nacala_vypuska' => [
                'nullable',
            ],
            'god_okoncaniya_vypuska' => [
                'nullable',
            ],
            'kod_modeli' => [
                'required',
            ],
        ];
    }

    public function startRow(): int
    {
        return 9;
    }

    public function getFullName(array $row): string
    {
        return implode(' ', [
            $row['model'],
            '(' . $row['tipy_kuzova'] . ')',
            '(' . implode('-', [
                $row['god_nacala_vypuska'] ?? '',
                $row['god_okoncaniya_vypuska'] ?? '',
            ]) . ')',
        ]);
    }

}
