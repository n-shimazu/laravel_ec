<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Http\Requests\UpdateRequest;
use App\Item;
use App\Result;
use App\Detail;

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

    public function delete_item($item_id){
        $item = Item::find($item_id);
        $item->delete();
        return redirect('/ec_tool');
    }

    public function switch_status($item_id){
        $item = new Item;
        $item->switch_status_item($item_id);
        return redirect('/ec_tool');
    }


    public function update_stock(UpdateRequest $request){
        $item = new Item;
        $item->update_stock_item($request->item_id, $request->new_stock);
        return redirect('/ec_tool');
    }

    public function display_open_items(){
        $items = Item::where('status', 1)->get();

        return view('ec_index',[
            'title' => '商品一覧',
            'items' => $items,
        ]);
    }
    public function display_results(){
        $user = \Auth::user();
        $results = Result::where('user_id', $user->user_id)->latest()->get();

        return view('ec_result', [
            'results' => $results,
        ]);
    }

    public function display_detail($result_id){
        $user_id = \Auth::user()->user_id;
        return view('ec_detail', ['details_data' => Detail::get_details_data($result_id)]);
    }
}