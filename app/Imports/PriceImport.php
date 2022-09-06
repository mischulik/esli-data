<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PriceImport implements WithMultipleSheets, SkipsUnknownSheets
{
    use Importable;

    public function sheets(): array
    {
        return [
            'Производители' => (new ManufacturersImport),
            'Модели автомобилей' => (new VehiclesImport),
            'Автостёкла и аксессуары' => (new ProductsImport),
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        info("Sheet $sheetName was skipped");
    }
}
