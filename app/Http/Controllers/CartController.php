<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItems;
use App\Models\User;
class CartController extends Controller
{
    public function AddToCart(Request $request){
        if($request->user('api')){
            $this->validate($request, [
                'count' => 'required|integer|min:0',
            ]);
                $user = $request->user('api');
                if ($user) {
                    $cart = CartItems::where(['product_slug' => $request->product_slug, 'user_id' => $user->id])->first();
                    if ($cart) {
                        if($request->count == 0){
                            $cart -> delete();
                            return response()->json([
                                'success' => true,
                                'message' => 'Товар удален из корзины'
                            ]);
                        }
                        elseif($request->count > 0) {
                            $cart->count = $request->count;
                        }
                    } else {
                        $cart = new CartItems;
                        $cart->user_id = $user->id;
                        $cart->product_slug = $request->product_slug;
                        $cart->count = $request->count;
                    }
                    $cart->save();
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Товар добавлен в корзину',
                    'count' => $cart->count
                ]);
        }
        else{
            $request->session()->put('cart.'.$request->product_slug, $request->count);
            if($request->count == 0){
            $request->session()->forget('cart.'.$request->product_slug);
                //var_dump($request->session()->get('cart'));
                return response()->json([
                    'success' => true,
                    'message' => 'Товар удален из корзины'
                ]);
                }
            //var_dump($request->session()->get('cart'));
            return response()->json([
                'success' => true,
                'message' => 'Товар добавлен в корзину',
                'count' => $request->count
            ]);
        }
    }


    public function RemoveAllCartItems(Request $request)
    {

        if ($request->user('api')) {
            $user = $request->user('api')->id;
            $cart = CartItems::where('user_id', $user);
            if ($cart->count() > 0) {
                $cart->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'корзина очищена'
                ]);
            } elseif ($cart->count() == 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'нет товаров в корзине']);
            }
        }
        else {
            //var_dump($request->session()->get('cart'));
            $request->session()->forget('cart');
            return response()->json([
                'success' => true,
                'message' => 'корзина очищена'
            ]);
        }
    }


    public function GetUserCart(Request $request){
        if ($request->user('api')) {
            $user = $request->user('api')->id;
            $userCart = [];
            /*if (isset($request->pageLimit) and !empty($request->pageLimit)) {
                $pageLimit = $request['pageLimit'];
            } else {
                $pageLimit = 15;
            }*/
            $carts['items'] = CartItems::where('user_id', $user)->with("product")->get();   //paginate($pageLimit);
            $carts['success'] = true;
            $sum = $this->getSumCart($request);
            $carts['sumCart'] = $sum;
            return $carts;
        }
        else{
            //var_dump($request->session()->get('cart'));
            $cart = [];
            $sum = 0;
            foreach($request->session()->get('cart') as $key=>$items){
                $price = Product::select('price')->where('slug', $key)->first();
                $cart['items'][] = array('product_slug' => $key,
                'count' => $items,
                'product' => Product::where('slug', $key)->first());

            $sum += $price->price * $items;
            //$carts['sumCart'] = $sum;

            }
            //foreach ()
            $cart['success'] = true;
            $cart['sumCart'] = $sum;
            return $cart;
        }
    }

    protected function getSumCart (Request $request)
    {
        $user = $request->user('api');
        $cart = CartItems::where(['user_id'=>$user->id])->get();
        $full_price = 0;
        foreach ($cart as $carts){
            $full_price += $carts->product->price * $carts->count;
        }
        return $full_price;
    }
}

