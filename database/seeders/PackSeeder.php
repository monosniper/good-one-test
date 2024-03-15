<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Pack;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $initial_data = [
            ['Ткань-1', 12, 1500],
            ['Ткань-2', 200, 1600],
            ['Нить', 40, 500],
            ['Нить', 300, 550],
            ['Пуговица', 500, 300],
            ['Замок', 1000, 2000],
        ];

        foreach ($initial_data as $pack) {
            Pack::create([
                'material_id' => Material::where('name', $pack[0])->first()->id,
                'remain' => $pack[1],
                'price' => $pack[2],
            ]);
        }
    }
}
