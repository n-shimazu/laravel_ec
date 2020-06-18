<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;

class Detail extends Model
{
    protected $primaryKey = 'detail_id';

    // public function result(){
    //     return $this->belongsTo('App\Result', 'result_id');
    // }

    public function item(){
        return $this->belongsTo('App\Item', 'item_id');
    }


    public static function create_details($result_id, $cart){
        $details = new Detail;
        $details->result_id = $result_id;
        $details->item_id = $cart->item_id;
        $details->amount = $cart->amount;
        $details->save();
    }

    public static function get_details_data($result_id){
        $details = Detail::where('result_id', $result_id)->get();
        $details_data = [];
        foreach($details as $detail){
            $price = $detail->item->price;
            $amount = $detail->amount;
            $details_data[] = [
                'name' => $detail->item->name,
                'price' => $price,
                'amount' => $amount,
                'subtotal' => $price * $amount,
            ];
        }
        
        return $details_data;
    }

}
