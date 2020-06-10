<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ecController extends Controller
{
    public function display_table(){
        return view('ec_tool', [
            'title' => '商品管理',
            'message' => 'ここにテーブルを表示',
        ]);
    }
    public function insert_item(Request $request){

        $request->validate([
            'name' => 'required|max:20',
            'price' => 'required|max:1000000',
            'stock' => 'required|max:10000',
            
        ]);

        $filename = '';
        $image = $request->file('image');
        if(isset($image) === true){
            $ext = $image->guessExtension();
            $filename = str_random(20) . ".{$ext}";
            $path = $image->storeAs('photos', $filename, 'public');
        }

        $item = new \App\Message;

        $item->name = $request->name;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->status = $request->status;
        $item->image = $filename;

        $item->save();

        return redirect('/ec_tool');
    }
}