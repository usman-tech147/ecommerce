<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            [
                'name' => 'white'
            ],
            [
                'name' => 'black'
            ],
            [
                'name' => 'blue'
            ],
            [
                'name' => 'red'
            ],
            [
                'name' => 'gray'
            ],
            [
                'name' => 'brown'
            ],
            [
                'name' => 'skin white'
            ],
            [
                'name' => 'pink'
            ],
        ];

        foreach($colors as $color)
        {
            $col = Color::create($color);
            $col->save();
        }
    }
}
