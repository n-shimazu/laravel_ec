<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'amount',
    ];

    public function item()
    {
        return $this->belongsTo('App\Item','item_id');
    }

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public static function add_new_item($user_id, $item_id)
    {
        $cart = new Cart;
        $cart->user_id = $user_id;
        $cart->item_id = $item_id;
        $cart->amount = 1;

        return $cart->save();
    }

    public function add_amount()
    {
        $amount = $this->amount;
        return $this->update(['amount' => $amount + 1]);
    }

    public static function change_amount($item_id, $new_amount)
    {
        $cart = Cart::where('item_id', $item_id)->first();
        return $cart->update(['amount' => $new_amount]);
    }

    public static function get_carts_data($cart)
    {
        $price = $cart->item->price;
        $amount = $cart->amount;
        return array(
        'item_id'=>$cart->item_id,
        'name'=>$cart->item->name,
        'price'=>$price,
        'image'=>$cart->item->image,
        'amount'=>$amount,
        );
    }
    public static function sum_cart($carts)
    {
        $sum = 0;
        foreach($carts as $cart){
            $sum += $cart->item->price * $cart->amount;
        }
        return $sum;
    }
}
