<?php

namespace Database\Seeders;

use App\Actions\Download\ElsiePriceDownloadAction;
use App\Imports\PriceImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
//        $this->call(StocksSeeder::class);
//
//        optional(ElsiePriceDownloadAction::make()->handle() ?? null, function (string $filename) {
//            $this->command->getOutput()->title('Starting price import');
//            Excel::import(new PriceImport, $filename);
//            $this->command->getOutput()->info('Price import completed');
//        });
    }
}
