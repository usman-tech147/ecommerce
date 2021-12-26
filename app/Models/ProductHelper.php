<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductHelper
{

    public $id;
    public $name;
    public $price;
    public $status;
    public $image;
    public $image_product_id;
    public $subcategory;
    public $description;

    public function __construct()
    {

    }

    public function setValues($id, $name, $price, $status, $subcategory, $image_product_id, $image)
    {
//        $this->id = $id;
//        $this->name = $name;
//        $this->price = $price;
//        $this->status = $status;
//        $this->image = $image;
//        $this->image_product_id = $image_product_id;
//        $this->subcategory = $subcategory;
        return [
            "id" => $id,
            "name" => $name,
            "price" => $price,
            "status" => $status,
            "subcategory" => $subcategory,
            "image_product_id" => $image_product_id,
            "image" => $image
        ];
    }

    public function productDetails()
    {
        $productDetails = array();
//
        $products = Product::with('subcategory')->get()->toArray();
//        return $products[0]['subcategory']['name'];
        $totalProducts = count($products);
        $images = DB::table('images')
//            ->select(['id', 'product_id', 'image'])
            ->groupBy('product_id')
            ->get()->toArray();
//
        for($i=0; $i<$totalProducts; $i++)
        {
//            $productHelper = new ProductHelper();
            $obj = $this->setValues($products[$i]['id'],
                $products[$i]['name'],$products[$i]['price'],
                $products[$i]['status'],$products[$i]['subcategory']['name'],
                $images[$i]->product_id,$images[$i]->image);
            array_push($productDetails,$obj);
        }

        return $productDetails;

    }

}