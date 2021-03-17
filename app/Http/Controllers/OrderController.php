<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\orderProduct;
use App\Models\CartItems;
use App\Models\Product;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function addOrder (Request $request)
    {
        if($request->user('api')) {
            $order = new Orders;
            $order->user_id = $request->user('api')->id;
            $order->name = $request->user('api')->name;
            $order->lastname = $request->user('api')->last_name;
            $order->adres = $request->adres;
            $order->phone = $request->user('api')->phone;
            $order->comment = $request->comment;


            $carts = CartItems::where('user_id', $request->user('api')->id)->get();
            $cartProd = [];
            $price = 0;
            foreach ($carts as $cart) {
                $cartProd[] = array("product" => Product::where('slug', $cart->product_slug)->get(),
                    "count" => $cart->count);
            }
            $order->products = json_encode($cartProd);
            $order->save();
            $carts = CartItems::where('user_id', $request->user('api')->id);
            $carts->delete();
            return response()->json(['success' => true]);
        }
        else{

            $order = new Orders;
            $order->user_id = 0;
            $order->name = $request->name;
            $order->lastname = $request->last_name;
            $order->adres = $request->adres;
            $order->phone = $request->phone;
            $order->comment = $request->comment;

            foreach ($request->session()->get('cart') as $key=>$item) {
                $cartProd[] = array("product" => Product::where('slug', $key)->get(),
                    "count" => $item);
            }
            $order->products = json_encode($cartProd);
            $order->save();
            $request->session()->forget('cart');
            return response()->json(['success' => true]);
        }
    }

    public function getOrder(Request $request){
        $user = $request->user('api')->id;
        if(isset($request['order_id']) and !empty($request['order_id'])){
            $id = $request['order_id'];
        }
        else{
            return response()->json(['success'=>false]);
        }
        $order = new Orders;
        $order->where("user_id", $user)->where("id", $id)->get();

        return $order;
    }

    public function getOrders(Request $request){
        $user = $request->user('api')->id;
        if(isset($request['pageLimit']) and !empty($request['pageLimit'])){
            $pageLimit = $request['pageLimit'];
        }
        else{
            $pageLimit = 9;
        }
        $order = new Orders;
        if(isset($request['orderBy']) and !empty($request['orderBy'])){
            $orderBy = $request['orderBy'];
        }
        else{
            $orderBy = 'id';
        }
        if(isset($request['ascDesc']) and !empty($request['ascDesc'])){
            $ascDesc = $request['ascDesc'];
        }
        else{
            $ascDesc = 'asc';
        }
        /*if($request->soft_delete == 1){
            $orders = $order->withTrashed()->where("user_id", $user)->orderBy($orderBy, $ascDesc )->paginate($pageLimit);
        }*/

            $orders = $order->where("user_id", $user)->orderBy($orderBy, $ascDesc )->paginate($pageLimit);

        foreach($orders as $order){
            $order["products"] = json_decode($order["products"]);
        }
        return response()->json($orders);
    }

    public function deleteOrder(Request $request){
        $order = Orders::where('id', $request->order_id)->first();
        $order -> delete();
        return response()->json(['success'=>true]);
    }


}
