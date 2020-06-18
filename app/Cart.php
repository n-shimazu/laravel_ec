<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'amount',
    ];

    public function item(){
        return $this->belongsTo('App\Item', 'item_id');
    }

    public function user(){
        return $this->belongsTo('\App\User');
    }

    public function add_new_item($user_id, $item_id){
        $this->user_id = $user_id;
        $this->item_id = $item_id;
        $this->amount = 1;

        return $this->save();
    }

    public function add_amount(){
        $amount = $this->amount;
        return $this->update(['amount' => $amount + 1]);
    }

    public function change_amount($item_id, $new_amount){
        $cart = Cart::where('item_id', $item_id)->first();
        return $cart->update(['amount' => $new_amount]);
    }

    // public function get_carts_data($user_id){
    //     $carts = $this::where('user_id', $user_id)->get();
    //     foreach($carts as $cart){
    //         $carts_data[]=[
    //         'item_id'=>$cart->item_id,
    //         'name'=>$cart->item->name,
    //         'price'=>$cart->item->price,
    //         'image'=>$cart->item->image,
    //         'amount'=>$cart->amount,
    //         ];
    //     }
    //     dd($carts_data);
    //     return $carts_data;

    // }
}
