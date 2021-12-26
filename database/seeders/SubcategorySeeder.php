<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = [
            [
                'category' => 1,
                'name' => 'men shalwar qamiz',
            ],
            [
                'category' => 1,
                'name' => 'men kurta pajama',
            ],
            [
                'category' => 2,
                'name' => 'women shalwar qamiz',
            ],
            [
                'category' => 3,
                'name' => 'kids shalwar qamiz',
            ],
            [
                'category' => 1,
                'name' => 'men suit',
            ],
            [
                'category' => 3,
                'name' => 'kids suit',
            ],
            [
                'category' => 3,
                'name' => 'kids wedding clothes',
            ],
            [
                'category' => 2,
                'name' => 'women wedding special',
            ]
        ];

        foreach($subcategories as $subcategory)
        {
            $subcat = Subcategory::create($subcategory);
            $subcat->save();
        }
    }
}
