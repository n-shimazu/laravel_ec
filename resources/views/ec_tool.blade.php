@extends('layouts.default')

@section('title', '商品管理')

@section('content')

    <h1>商品管理</h1>

    <p>現在のユーザー名: {{ Auth::user()->name }} </p>
    <form action="{{ url('/logout') }}" method="post">
        {{ csrf_field() }}
        <button type="submit">ログアウト</button>
    </form>

    @foreach($errors->all() as $error)
    <p class="error">{{ $error }}</p>
    @endforeach
    <section>
        <form method="post" action="{{ url('/insert') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

            <div>
                <label>
                    商品名:
                    <input type="text" name="name">
                </label>
                <label>
                    価格:
                    <input type="number" name="price">
                </label>
                <label>
                    在庫数:
                    <input type="number" name="stock">
                </label>
            </div>
            <div>
                <label>
                    商品画像:
                    <input type="file" name="image">
                </label>
            </div>
            <div>
                <label>
                    ステータス:
                    <select name="status">
                        <option value="1">公開</option>
                        <option value="0">非公開</option>
                    </select>
                </label>
            </div>
            <div>
                <input type="submit" value="商品追加">
            </div>
        </form>
    </section>

    <section>
        <table>
            <tr>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>操作</th>
            </tr>
    @forelse($items as $item)
                <tr>
                    <td><img src="{{ asset('storage/photos/' . $item->image) }}"></td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>
                        <form method="post" action="{{ url('/ec_tool/update/' . $item->item_id) }}">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <input type='number' name='new_stock' value="{{ $item->stock }}">
                            <input type="hidden" name="item_id" value="{{ $item->item_id }}">
                            <input type="submit" value="変更">
                        </form>
                    </td>
                    <td>
                        <form method="post" action="{{ url('/ec_tool/delete/' . $item->item_id) }}">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <input type="hidden" name="item_id" value="{{ $item->item_id }}">
                            <input type="submit" value="削除">
                        </form>
                        <form method="post" action="{{ url('/ec_tool/switch/' . $item->item_id) }}">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <input type="hidden" name="item_id" value="{{ $item->item_id }}">
                            <input type="submit" value="{{$item->status==1 ? '非公開にする' : '公開にする'}}">
                        </form>
                    </td>
                </tr>

        @empty
            <p>アイテムはありません</p>

        @endforelse
        </table>    
        </section>
@endsection
        