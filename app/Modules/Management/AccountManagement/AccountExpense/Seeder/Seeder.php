<?php
namespace App\Modules\Management\AccountManagement\AccountExpense\Seeder;

use Illuminate\Database\Seeder as SeederClass;
use Faker\Factory as Faker;

class Seeder extends SeederClass
{
    /**
     * Run the database seeds.
     php artisan db:seed --class="\App\Modules\Management\AccountManagement\AccountExpense\Seeder\Seeder"
     */
    static $model = \App\Modules\Management\AccountManagement\AccountExpense\Models\Model::class;

    public function run(): void
    {
        $faker = Faker::create();
        self::$model::truncate();

        for ($i = 1; $i <= 100; $i++) {
            self::$model::create([                'account_category_id' => null,
                'title' => $faker->text(100),
                'amount' => null,
                'description' => $faker->paragraph,
                'is_approved' => $faker->boolean,
                'user_type' => $faker->randomElement(array (
  0 => 'admin',
  1 => 'employee',
)),
            ]);
        }
    }
}