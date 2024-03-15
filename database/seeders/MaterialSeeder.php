<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $initial_data = [
            'Ткань-1',
            'Ткань-2',
            'Нить',
            'Пуговица',
            'Замок',
        ];

        foreach ($initial_data as $name) {
            Material::create(['name' => $name]);
        }
    }
}
