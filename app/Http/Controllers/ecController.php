<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Http\Requests\UpdateRequest;
use App\Item;

class ecController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function display_table(){
        $items = Item::all();

        return view('ec_tool', [
            'title' => '商品管理',
            'items' => $items,
        ]);
    }
    public function insert_item(ItemRequest $request){

        $item = new Item($request->except('image'));
        $item->save_image($request->file('image'));
        $item->save();

        return redirect('/ec_tool');
    }

    public function delete_item($id){
        $item = Item::find($id);
        $item->delete();
        return redirect('/ec_tool');
    }

    public function switch_status($id){
        $item = new Item;
        $item->switch_status_item($id);
        return redirect('/ec_tool');
    }


    public function update_stock(UpdateRequest $request){
        $item = new Item;
        $item->update_stock_item($request->item_id, $request->new_stock);
        return redirect('/ec_tool');
    }

    public function display_open_items(){
        $items = Item::where('status', 1)->get();

        return view('/ec_index',[
            'title' => '商品一覧',
            'items' => $items,
        ]);
    }
}