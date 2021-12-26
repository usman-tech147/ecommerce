<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('subcategory')->get()->toArray();
        return view('product.index', compact('products'));
    }

    public function getSubcategories(Request $request)
    {
        $cat = Category::with(['subcategories' => function ($query) {
            $query->select(['id', 'name', 'category']);
        }])->where('id', $request->id)->get(['id']);
        return response()->json(['data' => $cat]);
    }

    public function create()
    {
        $categories = DB::table('categories')->get();
        $colors = DB::table('colors')->select(['id', 'name'])->get()->chunk(3);
        $sizes = DB::table('sizes')->select(['id', 'name'])->get();
        $qualities = DB::table('qualities')->select(['id', 'name'])->get();
        $fabrics = DB::table('fabrics')->select(['id', 'name'])->get()->chunk(3);
        return view('product.product',
            compact('categories', 'colors', 'sizes', 'qualities', 'fabrics'));
    }

    public function store(ProductRequest $request)
    {
//        dd($colors);
//        dd($request->input('color-quantity-')[$request->colors[0]]);
        try {
            DB::transaction(function () use ($request) {
                $product = Product::create([
                    'subcategory' => $request->subcategory,
                    'fabric' => $request->pro_fabric,
                    'quality' => $request->pro_quality,
                    'name' => $request->pro_name,
                    'price' => $request->pro_price,
                    'sale_date_before' => $request->sale_date_before,
                    'description' => $request->pro_description,
                    'status' => 0
                ]);

                // single file save in storage
                if ($request->hasFile('pro_image')) {
                    $fileName = Str::random(10) . '.' . $request->file('pro_image')->getClientOriginalName();
                    $request->file('pro_image')->move(public_path('images'), $fileName);
                    $product->image = $fileName;
                }
                $product->save();


                // save data in pivot tables
                $colors = [];
                foreach ($request->colors as $key => $value) {
                    $quantity = [$value => ['in_stock' => $request->input('color-quantity-')[$request->colors[$key]]]];
                    $colors += $quantity;
//                    array_push($colors,$quantity);
                }
//                dd($colors);
                $product->colors()->sync($colors);
                $product->sizes()->sync($request->sizes);

            });
            return redirect()->back()->with('success', 'Product is created successfully!');
        } catch (\Exception $ex) {
            return redirect()->back()->with('failed', $ex->getMessage());
        }

        //            return response()->json(['data' => $product]);
    }

    public function edit($id)
    {
        //get all data for dropdowns, checkboxes and radio buttons
        $categories = DB::table('categories')->get();
        $colors = DB::table('colors')->select(['id', 'name'])->get()->chunk(3);
        $sizes = DB::table('sizes')->select(['id', 'name'])->get();
        $qualities = DB::table('qualities')->select(['id', 'name'])->get();
        $fabrics = DB::table('fabrics')->select(['id', 'name'])->get()->chunk(3);
        // Get product related details

//        $product = Product::with('subcategory', 'fabric', 'quality', 'colors', 'sizes')
//            ->where('id', '=', $id)->get();
        $product = Product::with('subcategory.category')
            ->with('fabric')
            ->with('quality')
            ->with('colors')
            ->with('sizes')
            ->where('id', '=', $id)
            ->get();
        return view('product.product',
            compact('categories', 'colors', 'sizes', 'fabrics', 'qualities', 'product')
        );
    }


    public function update(Request $request)
    {
        $product = Product::find($request->product_id);
        if ($product->image != 'nophoto.png') {
            $path = public_path('/images/' . $product->image);
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $product->subcategory_id = $request->subcategory;
        $product->name = $request->pro_name;
        $product->price = $request->pro_price;
        $product->added_date = $request->added_date;
        $product->description = $request->pro_description;
        $product->quality_id = $request->pro_quality;
        $product->fabric_id = $request->pro_fabric;
        $product->status = 0;
        if ($request->hasFile('pro_image')) {
            $fileName = Str::random(10) . '.' . $request->file('pro_image')->getClientOriginalName();
            $request->file('pro_image')->move(public_path('images'), $fileName);
            $product->image = $fileName;
        } else {
            $product->image = "nophoto.png";
        }

//        save data in pivot tables
        $product->colors()->sync($request->colors);
        $product->sizes()->sync($request->sizes);
        $product->save();

        return response()->json(['data' => $product]);

    }


    public function delete(Request $request)
    {
        $product = Product::find($request->product_id);
        if ($product->image != 'nophoto.png') {
            $path = public_path('/images/' . $product->image);
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $product->delete();

        return response()->json(['id' => $request->product_id]);
    }

    public function show()
    {
        return view('product.show');
    }


//    public function getAllProducts(Request $request)
//    {
//        $draw = $request->draw;
//        $start = $request->start;
//        $length = $request->length;
//
//        $order = $request->order;
//        $columns = $request->columns;
//        $order_arr = $request->order;
//        $search_arr = $request->search;
//
//        $columnIndex = $order[0]['column'];
//        $columnName = $columns[$columnIndex]['data'];
//        $columnSortOrder = $order_arr[0]['dir'];
//
//        $songs = null;
//        $totalRecords = null;
//        $totalRecordsWithFilter = null;
//
//        $searchValue = $search_arr['value'];
//
//        $totalRecords = Song::select('count(*) as allcount')->count();
//
//        $totalRecordsWithFilter = Song::select('count(*) as allcount')
//            ->where('name', 'like', '%' . $searchValue . '%')
//            ->count();
//
//        $songs = Song::orderby($columnName, $columnSortOrder)
//            ->where('songs.name', 'like', '%' . $searchValue . '%')
//            ->select('songs.*')
//            ->skip($start)
//            ->limit($length)
//            ->get();
//
//
//        $data_arr = array();
//
//        foreach ($songs as $song) {
//            $id = $song->id;
//            $serial = str_pad($song->id, 5, '0', STR_PAD_LEFT);
//            $name = $song->name;
//            $song_length = $song->length;
//            $album = $song->album->name;
//
//            $data_arr[] = array(
//                "id" => $id,
//                "Product_no" => $serial,
//                "name" => $name,
//                "length" => $song_length,
//                "album" => $album,
//            );
//        }
//
//        $response = array(
//            "draw" => intval($draw),
//            "iTotalRecords" => $totalRecords,
//            "iTotalDisplayRecords" => $totalRecordsWithFilter,
//            "aaData" => $data_arr
//        );
//
//        echo json_encode($response);
//        exit;
//    }


//    public function edit($id)
//    {
//        //get all data for dropdowns, checkboxes and radio buttons
//        $categories = DB::table('categories')->get();
//        $colors = DB::table('colors')->select(['id', 'name'])->get();
//        $sizes = DB::table('sizes')->select(['id', 'name'])->get();
//        $qualities = DB::table('qualities')->select(['id', 'name'])->get();
//        $fabrics = DB::table('fabrics')->select(['id', 'name'])->get();
//
//        // Get product related details
//        $productDetails = Product::with('subcategory', 'fabric', 'quality', 'colors', 'sizes')
//            ->where('id', '=', $id)->get();
//
//        dd($productDetails->toArray());
//
//        $category = Subcategory::find($productDetails[0]['subcategory']['id'])->category->id;
//
//        $colors_id = array();
//        $sizes_id = array();
//
//        foreach ($productDetails[0]['colors']->toArray() as $color) {
//            array_push($colors_id, $color['id']);
//        }
//
//        foreach ($productDetails[0]['sizes']->toArray() as $size) {
//            array_push($sizes_id, $size['id']);
//        }
//
//        $product = [
//            "id" => $productDetails[0]['id'],
//            "category" => $category,
//            "subcategory_id" => $productDetails[0]['subcategory']['id'],
//            "subcategory_name" => $productDetails[0]['subcategory']['name'],
//            "name" => $productDetails[0]['name'],
//            "price" => $productDetails[0]['price'],
//            "description" => $productDetails[0]['description'],
//            "added_date" => $productDetails[0]['added_date'],
//            "status" => $productDetails[0]['status'],
//            "quality" => $productDetails[0]['quality']['id'],
//            "fabric" => $productDetails[0]['fabric']['id'],
//            "colors" => $colors_id,
//            "sizes" => $sizes_id,
//            "image" => $productDetails[0]['image']
//        ];
//
////        dd($id);
//        return view('product.product',
//            compact('categories', 'colors', 'sizes', 'fabrics', 'qualities', 'product')
//        );
//    }
}