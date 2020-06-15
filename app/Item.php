<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function carts(){
        return $this->hasMany('App\Cart');
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

    public function switch_status_item($item_id){
        $item = $this::find($item_id);
        return $item->update([
            'status' => $item->status == 1 ? 0 : 1,
        ]);
    }

    public function update_stock_item($item_id, $new_stock){
        $item = $this::find($item_id);
        return $item->update(['stock' => $new_stock]);
    }
}
