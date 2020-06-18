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


    public function create_details($result_id, $cart){
        $this->result_id = $result_id;
        $this->item_id = $cart->item_id;
        $this->amount = $cart->amount;
        $this->save();
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
