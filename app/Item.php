<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $primaryKey = 'item_id';

    // public function carts(){
    //     return $this->hasMany('App\Cart', 'item_id');
    // }

    public function details(){
        return $this->hasMany('App\Detail', 'item_id');
    }

    protected $fillable = [
        'name',
        'price',
        'stock',
        'status',
    ];
    public function save_image($image){
        $filename = '';
        if(isset($image) === true){
            $ext = $image->guessExtension();
            $filename = str_random(20) . ".{$ext}";
            $image->storeAs('photos', $filename, 'public');
            $this->image = $filename;
        }
        return $filename;
    }

    public static function switch_status_item($item_id)
    {
        $item = Item::find($item_id);
        return $item->update([
            'status' => $item->status == 1 ? 0 : 1,
        ]);
    }

    public static function update_stock_item($item_id, $new_stock)
    {
        return Item::find($item_id)->update(['stock' => $new_stock]);
    }

    public static function check_stock($cart)
    {
        $surplus = ($cart->item->stock) - $cart->amount;
        if($surplus < 0){
            return $cart->item->name;
        }
    }

    public static function add_up($carts)
    {
        $sum = 0;
        foreach($carts as $cart){
            $sum += ($cart->item->price) * $cart->amount;
        }

        return $sum;
    }

    public static function deduct_stock($cart)
    {
        return Item::where('item_id', $cart->item->item_id)
                   ->first()
                   ->update(['stock' => ($cart->item->stock) - $cart->amount]);
    }
}