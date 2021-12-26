<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = [
            [
                'name' => 'small'
            ],
            [
                'name' => 'large'
            ],
            [
                'name' => 'medium'
            ],
        ];

        foreach($sizes as $size)
        {
            $si = Size::create($size);
            $si->save();
        }
    }
}
