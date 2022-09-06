<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;

class StocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        collect([
//            [
//                'shop_id' => 2,
//                'name' => 'Кривой рог',
//            ],
//            [
//                'shop_id' => 4,
//                'name' => 'Ужгород',
//            ],
//            [
//                'shop_id' => 5,
//                'name' => 'Одесса',
//            ],
            [
                'shop_id' => 12,
                'name' => 'Днепр',
            ],
//            [
//                'shop_id' => 13,
//                'name' => 'Львов',
//            ],
//            [
//                'shop_id' => 15,
//                'name' => 'Херсон',
//            ],
//            [
//                'shop_id' => 18,
//                'name' => 'Запорожье',
//            ],
//            [
//                'shop_id' => 31,
//                'name' => 'Луцк',
//            ],
//            [
//                'shop_id' => 21,
//                'name' => 'Харьков',
//            ],
//            [
//                'shop_id' => 24,
//                'name' => 'Ровно',
//            ],
//            [
//                'shop_id' => 25,
//                'name' => 'Чернигов',
//            ],
//            [
//                'shop_id' => 26,
//                'name' => 'Черкассы',
//            ],
            [
                'shop_id' => 1,
                'name' => 'Киев',
            ],
//            [
//                'shop_id' => 33,
//                'name' => 'Житомир',
//            ],
        ])->map(function (array $arrayData) {
            return optional(Stock::query()->firstOrCreate($arrayData) ?? null, function (Stock $stock) {
                return $stock;
            });
        });
    }
}

