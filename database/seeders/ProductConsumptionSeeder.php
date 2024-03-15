<?php

namespace Database\Seeders;

use App\Models\Consumption;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductConsumptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $initial_data = [
            ['Брюки', [
                ['Ткань-1', 1.4],
                ['Нить', 10],
                ['Замок', 1],
            ]],
            ['Рубашка', [
                ['Ткань-2', 0.8],
                ['Нить', 10],
                ['Пуговица', 5],
            ]],
        ];

        foreach ($initial_data as $product) {
            $product_ = Product::create([
                'name' => $product[0],
            ]);

            foreach ($product[1] as $consumption) {
                Consumption::create([
                    'product_id' => $product_->id,
                    'material_id' => Material::where('name', $consumption[0])->first()->id,
                    'count' => $consumption[1]
                ]);
            }
        }
    }
}
