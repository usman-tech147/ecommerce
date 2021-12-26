<?php

namespace Database\Seeders;

use App\Models\Quality;
use Illuminate\Database\Seeder;

class QualitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $qualities = [
            [
                'name' => 'high'
            ],
            [
                'name' => 'low'
            ],
            [
                'name' => 'medium'
            ],
        ];

        foreach($qualities as $quality)
        {
            $qual = Quality::create($quality);
            $qual->save();
        }
    }
}
