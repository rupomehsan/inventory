<?php
namespace App\Modules\Management\WarehouseManagement\WarehouseSwapProduct\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="\App\Modules\Management\WarehouseManagement\WarehouseSwapProduct\Seeder\Seeder"
     */
    static $model = \App\Modules\Management\WarehouseManagement\WarehouseSwapProduct\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'from_warehouse_id' => null,
                'to_warehouse_id' => null,
                'quantity' => null,
            ]);
        }
    }
}