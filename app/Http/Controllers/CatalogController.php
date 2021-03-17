<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Characteristics;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class CatalogController extends Controller
{
    public function categories (Request $request){
        $categories = Category::whereNull('category_id')
            ->with('childrenCategories')
            ->get();
        return $categories;
    }

    public function getProducts(Request $request)
    {
        //var_dump($request->filter);
       $product = DB::table('products')->join('characteristics', 'products.slug', '=', 'characteristics.product_slug');


       if (isset($request['filter']) and !empty($request['filter'])) {


            foreach ($request->filter as $value) {
                if(is_array($value['val']) and count($value['val']) == 2){
                    if($value['val']['min'] >= $value['val']['max']){
                        return response()->json([
                            'success' => false,
                            'message' => 'Некорректное значение фильтра'
                        ]);
                    }
                    $product->whereBetween($value['column'], [$value['val']['min'], $value['val']['max']]);
                }
                elseif(count($value['val']) == 1) {
                    $product->where($value['column'], $value['val']['min']);
                }
            }
       }

        return $product->get();
    }



    public function getProduct (Request $request)
    {
        return $product = DB::table('products')->join('characteristics', 'products.slug', '=', 'characteristics.product_slug')->where('slug', $request['slug'])->get();
         //$product = Product::;
    }

    public function addCharacteristics (Request $request){
        $char = Characteristics::where('product_slug', $request->product_slug);
        //return $char;
        if($char->count() > 0){

            if($request->ch1) {
                Characteristics::where('product_slug', $request->product_slug)->update(['ch1' => $request->ch1]);
            }
            if($request->ch2) {
                Characteristics::where('product_slug', $request->product_slug)->update(['ch2' => $request->ch2]);
            }
            if($request->ch3) {
                Characteristics::where('product_slug', $request->product_slug)->update(['ch3' => $request->ch3]);
            }
            if($request->ch4) {
                Characteristics::where('product_slug', $request->product_slug)->update(['ch4' => $request->ch4]);
            }
            if($request->ch5) {
                Characteristics::where('product_slug', $request->product_slug)->update(['ch5' => $request->ch5]);
            }
            return response()->json([
                'success' => true
            ]);
        }
        else{
            $char = new Characteristics;
            $char -> product_slug = $request->product_slug;
            $char ->ch1 = $request->ch1;
            $char ->ch2 = $request->ch2;
            $char ->ch3 = $request->ch3;
            $char ->ch4 = $request->ch4;
            $char ->ch5 = $request->ch5;
            $char->save();
            return response()->json([
                'success' => true
            ]);

        }

    }
}


