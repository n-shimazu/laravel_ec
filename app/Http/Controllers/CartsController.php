<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Cart;
use App\Item;
use App\Detail;
use App\Result;
use App\Http\Requests\AmountRequest;
use \Auth;

class CartsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function add(Request $request)
    {
        $user_id = Auth::user()->user_id;
        $item_id = $request->item_id;

        $cart = Cart::where('user_id', $user_id)->where('item_id', $item_id)->first();
        
        if (empty($cart) === true) {
            Cart::add_new_item($user_id, $item_id);
        } else {
            $cart->add_amount();
        }
        return redirect('/ec_index');
    }

    public function display_cart()
    {
        $user_id = Auth::user()->user_id;
        $carts_data = [];

        $carts = Cart::where('user_id', $user_id)->get();
        foreach($carts as $cart){
            $carts_data[] = Cart::get_carts_data($cart);
        }

        return view('ec_cart', [
            'carts_data' => $carts_data,
            'sum' => Cart::sum_cart($carts),
        ]);
    }
    public function update_amount(AmountRequest $request)
    {
        
        Cart::change_amount($request->item_id, $request->new_amount);

        return redirect('/ec_cart');
    }
    public function destroy_from_cart(Request $request){
        Cart::where('item_id', $request->item_id)->delete();

        return redirect('/ec_cart');
    }
    public function purchase_item()
    {
        $user_id = Auth::user()->user_id;
        $carts = Cart::where('user_id', $user_id)->get();

        DB::beginTransaction();

        foreach($carts as $cart){
            $error_msgs[] = Item::check_stock($cart);

            Item::deduct_stock($cart);

            $cart->delete();
        }
        $sum = Item::add_up($carts);
            
        $result = Result::create_result($user_id,$sum);
        foreach($carts as $cart){
            Detail::create_details($result->result_id, $cart);
        }

        if (!empty(array_filter($error_msgs))){
            DB::rollBack();

            return view('ec_error', compact('error_msgs'));
        } else{
            DB::commit();

            return view('ec_finish', compact('carts', 'sum'));
        }
    }
}
