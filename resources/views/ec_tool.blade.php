@extends('layouts.default')

@section('title', $title)

@section('content')

    <h1>{{ $title }}</h1>

    @foreach($errors->all() as $error)
    <p class="error">{{ $error }}</p>
    @endforeach

    <form method="post" action="{{ url("/insert") }}" enctype="multipart/form-data">
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
    @forelse($items as $item)
        <table>
            <tr>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>操作</th>
            </tr>
            <tr>
                <td><img src="{{ asset('storage/photos/' . $item->image) }}"></td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->stock }}</td>
                <td>
                    <form method="post" action="{{ url('/ec_tool/' . $item->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <input type="submit" value="削除">
                    </form>
                </td>
            </tr>
        </table>

    @empty
        <p>アイテムはありません</p>

    @endforelse
@endsection
        