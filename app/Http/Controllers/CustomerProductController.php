<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Fabric;
use App\Models\Product;
use App\Models\Quality;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class CustomerProductController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        $qualities = Quality::all();
        $fabrics = Fabric::all();
//        $products = Product::paginate(3);

        $products = Product::all();


        return view('Customer.customer_products', compact('colors', 'sizes', 'qualities', 'fabrics', 'categories', 'products'));
    }

    public function filterProduct(Request $request)
    {
//        $data = collect();
        $products = collect();
        $colorProductsData = collect();
        $sizeProductsData = collect();
        $qualityProductsData = collect();
        $fabricProductsData = collect();
        $colorProducts = null;
        $sizeProducts = null;
        $qualityProducts = null;
        $fabricProducts = null;

        if ($request->has('colors')) {
            $colorProducts = Color::with('products')
                ->whereIn('id', $request->colors)
                ->get();
        }

        if ($request->has('sizes')) {
            $sizeProducts = Size::with('products')
                ->whereIn('id', $request->sizes)
                ->get();
        }

        if($request->has('qualities')){
            $qualityProducts = Quality::with('products')
                ->whereIn('id',$request->qualities)
                ->get();
        }

        if($request->has('fabrics')){
            $fabricProducts = Fabric::with('products')
                ->whereIn('id',$request->fabrics)
                ->get();
        }

        if($colorProducts){
            $colorProductsData = $colorProducts->pluck('products');
        }
        if($sizeProducts){
            $sizeProductsData = $sizeProducts->pluck('products');
        }
        if($qualityProducts){
            $qualityProductsData = $qualityProducts->pluck('products');
        }
        if($fabricProducts){
            $fabricProductsData = $fabricProducts->pluck('products');
        }

        $data = $colorProductsData->concat($sizeProductsData)
            ->concat($qualityProductsData)->concat($fabricProductsData);


        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[$i]); $j++) {
                $products->add($data[$i][$j]);
            }
        }
        $products = $products->unique('id');
        $html = $this->returnHtml($products);
        return response()->json(['data' => $html]);

    }

    /**
     * @param $products
     */
    public function returnHtml($products)
    {
        $template = "";
        foreach ($products->chunk(3) as $productChunk) {
            $template .= '<div class="card-deck mb-3 mt-3 row">';
            foreach ($productChunk as $product) {
                $template .= '<div class="card col-md-4">
                                <img class="card-img-top" src="' . asset('/images/' . $product->image) . '"
                                     width="90" height="150"
                                     alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title"><strong> Name: </strong> ' . $product->name . ' </h5>
                                    <p class="card-text">';
                $template .= '<strong> Colors: </strong>';
                foreach ($product->colors as $color) {
                    $template .= $color->name;
                    $template .= ',';
                }
                $template .= '<br>';
                $template .= '<strong> Sizes: </strong>';
                foreach ($product->sizes as $size) {
                    $template .= $size->name;
                    $template .= ',';
                }
                $template .= '<br>';
                $template .='<strong> ID: </strong>';
                $template .= $product->id;
                $template .= '<br>';
                $template .='<strong> Quality: </strong>';
                $template .= $product->quality->name;
                $template .= '<br>';
                $template .='<strong> Fabric: </strong>';
                $template .= $product->fabric->name;
                $template .= '<br>';
                $template .= '<strong> Description: </strong>
                                        ' . $product->description . ' <br>
                                        <strong>Category: </strong>
                                        ' . $product->subcategory->category->name . '<br>
                                        <strong>Subcategory: </strong>
                                        ' . $product->subcategory->name . '
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <label class="text-muted"><strong> Price: </strong>' . $product->price . '</label>
                                    <button class="btn btn-sm btn-warning float-right"> Add To Cart</button>
                                </div>
                            </div>';
            }
            $template .= '</div>';
        }

        return $template;
    }

}
