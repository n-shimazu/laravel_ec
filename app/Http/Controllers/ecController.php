<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Http\Requests\UpdateRequest;
use App\Item;
use App\Result;
use App\Detail;
use \Auth;

class ecController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function display_table()
    {
        return view('ec_tool', [
            'items' => Item::all(),
        ]);
    }

    public function insert_item(ItemRequest $request)
    {

        $item = new Item($request->except('image'));
        $item->save_image($request->file('image'));
        $item->save();

        return redirect('/ec_tool');
    }

    public function delete_item($item_id)
    {
        Item::find($item_id)->delete();
        return redirect('/ec_tool');
    }

    public function switch_status($item_id)
    {
        Item::switch_status_item($item_id);
        return redirect('/ec_tool');
    }


    public function update_stock(UpdateRequest $request)
    {
        Item::update_stock_item($request->item_id, $request->new_stock);
        return redirect('/ec_tool');
    }

    public function display_open_items()
    {
        return view('ec_index',[
            'items' => Item::where('status', 1)->get(),
        ]);
    }
    
    public function display_results()
    {
        return view('ec_result', [
            'results' => Result::where('user_id', Auth::user()->user_id)->latest()->get(),
        ]);
    }

    public function display_detail($result_id)
    {
        return view('ec_detail', [
            'details_data' => Detail::get_details_data($result_id),
        ]);
    }
}