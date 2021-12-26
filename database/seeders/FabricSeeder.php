<?php

namespace Database\Seeders;

use App\Models\Fabric;
use Illuminate\Database\Seeder;

class FabricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fabrics = [
            [
                'name' => 'cotton'
            ],
            [
                'name' => 'lawn'
            ],
            [
                'name' => 'silk'
            ],
            [
                'name' => 'boski'
            ],
            [
                'name' => 'valvet'
            ],
        ];

        foreach($fabrics as $fabric)
        {
            $fab = Fabric::create($fabric);
            $fab->save();
        }
    }
}
