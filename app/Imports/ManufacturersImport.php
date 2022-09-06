<?php

namespace App\Imports;

use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class ManufacturersImport implements ToModel, WithHeadingRow, WithUpserts, WithValidation, SkipsEmptyRows, SkipsOnFailure
{
    use SkipsFailures;
    use SkipsErrors;

    protected array $flags = [
        'Европа' => 'eu',
        'Россия' => 'ru',
        'Украина' => 'ua',
        'Китай' => 'cn',
    ];

    /**
     * @param array $row
     *
     * @return Manufacturer|Model|null
     */
    public function model(array $row)
    {
        return new Manufacturer([
            'code_suffix' => trim($row['rassirenie_koda_elsi'], '-'),
            'name' => $row['brend'] ?? null,
            'country' => $row['proizvoditel'] ?? null,
            'country_code' => optional($row['proizvoditel'] ?? null, function (string  $country) {
                return $this->flags[$country] ?? 'xx';
            }),
        ]);
    }

    public function headingRow(): int
    {
        return 7;
    }

    public function uniqueBy(): string
    {
        return 'code_suffix';
    }

    public function rules(): array
    {
        return [
            'rassirenie_koda_elsi' => [
                'required',
            ],
            'brend' => [
                'required',
            ],
            'proizvoditel' => [
                'required',
            ],
        ];
    }
}
