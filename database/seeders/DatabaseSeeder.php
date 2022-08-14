<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Random;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed categories
     */
    private function seedCategories($total)
    {
        $tableName = 'category';
        $data = [];

        try {
            for ($i = 1; $i <= $total; $i++) {
                $data[] = [
                    'name' => fake()->streetName()
                ];

                if ($i == $total || $i % 1000 === 0) {
                    DB::beginTransaction();
                    DB::table($tableName)->insert($data);
                    DB::commit();

                    $data = [];
                }
            }

            return true;
        }
        catch (\Exception $e) {
            DB::rollback();
        }
    }

    /**
     * Seed products
     */
    private function seedProducts($total)
    {
        $tableName = 'product';
        $data = [];

        $idCategory = DB::table('category')
            ->selectRaw('max(id) as max, min(id) as min')
            ->first();

        try {
            for ($i = 1; $i <= $total; $i++) {
                $fkCategory = rand($idCategory->min, $idCategory->max);
                $unitPrice = fake()->randomFloat(null, 10000, 30000000);
                $discount = [0, 10, 0, 20, 0, 30][rand(0, 5)];
                $data[] = [
                    'name' => str_replace("\n", ', ', fake()->address()),
                    'unit_price' => $unitPrice,
                    'discount_price' => $unitPrice - $unitPrice * ($discount / 100),
                    'category_id' => $fkCategory,
                    'short_description' => fake()->paragraph(),
                ];

                if ($i == $total || $i % 1000 === 0) {
                    DB::beginTransaction();
                    DB::table($tableName)->insert($data);
                    DB::commit();

                    $data = [];
                }
            }

            return true;
        }
        catch (\Throwable $e) {
            DB::rollback();
        }
    }

    /**
     * Seed products
     */
    private function seedProductFactors($startFrom, $total)
    {
        $tableName = 'product_factor';
        $data = [];

        try {
            for ($i = 1; $i <= $total; $i++) {
                $views = rand(1, 100000);
                $ratings = rand(1, 100000);
                $avgRating = rand(10, 50)/10;
                $sales = rand(0, 100000);
                $recentSales = rand(0, $sales*(rand(0, 30)/100));
                $data[] = [
                    'product_id' => $i + $startFrom,
                    'views' => $views,
                    'ratings' => $ratings,
                    'avg_rating' => $avgRating,
                    'sales' => $sales,
                    'recent_sales' => $recentSales,
                ];

                if ($i == $total || $i % 1000 === 0) {
                    DB::beginTransaction();
                    DB::table($tableName)->insert($data);
                    DB::commit();

                    $data = [];
                }
            }

            return true;
        }
        catch (\Throwable $e) {
            DB::rollback();
        }
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->seedProductFactors(904000, 96000);
    }
}
