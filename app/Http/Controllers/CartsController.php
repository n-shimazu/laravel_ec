<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Item;
use App\Detail;
use App\Result;
use App\Http\Requests\AmountRequest;

class CartsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function add(Request $request)
    {
        $user_id = \Auth::user()->user_id;
        $item_id = $request->item_id;

        $cart = Cart::where('user_id', $user_id)->where('item_id', $item_id)->first();
        
        if (empty($cart) === true) {
            $cart = new Cart;
            $cart->add_new_item($user_id, $item_id);
        } else {
            $cart->add_amount();
        }
        return redirect('/ec_index');
    }

    public function display_cart(){
        $user_id = \Auth::user()->user_id;
        $sum = 0;
        $carts_data = [];

        $carts = Cart::where('user_id', $user_id)->get();
        foreach($carts as $cart){
            $price = $cart->item->price;
            $amount = $cart->amount;
            $sum += ($price * $amount);
            $carts_data[]=[
            'item_id'=>$cart->item_id,
            'name'=>$cart->item->name,
            'price'=>$price,
            'image'=>$cart->item->image,
            'amount'=>$amount,
            ];
        }
        return view('ec_cart', [
            'title' => 'カート一覧',
            'carts_data' => $carts_data,
            'sum' => $sum,
        ]);
    }
    public function update_amount(AmountRequest $request){
        $cart = new Cart;
        $cart->change_amount($request->item_id, $request->new_amount);

        return redirect('/ec_cart');
    }
    public function destroy_from_cart(Request $request){
        $cart = Cart::where('item_id', $request->item_id);
        $cart->delete();

        return redirect('/ec_cart');
    }
    public function purchase_item(){
        $user_id = \Auth::user()->user_id;
        $carts = Cart::where('user_id', $user_id)->get();
        $error_msg = '';
        $sum = 0;


        foreach($carts as $cart){
            $item_id = $cart->item->item_id;
            $amount = $cart->amount;

            $item = Item::where('item_id', $item_id)->first();

            $surplus = ($item->stock) - $amount;
            if($surplus < 0){
                return view('ec_error',[
                    'error_msg' => $item->name,
                ]);
            }else{
                $price = $cart->item->price;
                $amount = $cart->amount;
                $sum += ($price * $amount);

                $item->update(['stock' => $surplus]);
                $cart->delete();
            }
        }

            $result = new Result;
            $result->create_result($user_id,$sum);

            foreach($carts as $cart){
                $details = new Detail;
                $details->create_details($result->result_id, $cart);
            }

        return view('ec_finish', [
            'title' => 'ご購入ありがとうございます',
            'carts' => $carts,
            'sum' => $sum,
        ]);

        // return view('ec_finish', compact('carts', 'sum'));
    }
}
