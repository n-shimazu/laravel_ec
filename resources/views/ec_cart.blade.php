@extends('layouts.default')

@section('title', 'カート')

@section('content')
<h1>カート</h1>
<div>
    <p>現在のユーザー名: {{ Auth::user()->name }} </p>
    <form action="{{ url('/logout') }}" method="post">
        {{ csrf_field() }}
        <button type="submit">ログアウト</button>
    </form>
</div>
<div>
    <a href="/ec_index">商品一覧</a>
</div>


@foreach($errors->all() as $error)
<p class="error">{{ $error }}</p>
@endforeach

<table>
    <tr>
        <th>商品画像</th>
        <th>商品名</th>
        <th>価格</th>
        <th>数量</th>
        <th>操作</th>
    </tr>
    @forelse($carts_data as $cart_data)
    <tr>
        <td><img src="{{ asset('storage/photos/' . $cart_data['image']) }}"></td>
        <td>{{ $cart_data['name'] }}</td>
        <td>{{ $cart_data['price'] }} 円</td>
        <td>
            <form method="post" action="{{ url('/ec_cart/update/' . $cart_data['item_id']) }}">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <input type='number' name='new_amount' value="{{ $cart_data['amount'] }}">
                <input type="hidden" name="item_id" value="{{ $cart_data['item_id'] }}">
                <input type="submit" value="変更">
            </form>
        </td>
        <td>
            <form method="post" action="{{ url('/ec_cart/delete/' . $cart_data['item_id']) }}">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <input type="hidden" name="item_id" value="{{ $cart_data['item_id'] }}">
                <input type="submit" value="削除">
            </form>
        </td>
    </tr>

    @empty
    <p>アイテムはありません</p>

    @endforelse
</table>
<div>
    <p>合計: {{ $sum }}円</p>
    <form method="post" action="/ec_finish">
        {{ csrf_field() }}
        <input type="submit" value="購入する">
    </form>
</div>
@endsection