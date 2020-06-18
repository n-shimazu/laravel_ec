@extends('layouts.default')

@section('title', 'お買い上げありがとうございます')

@section('content')

<h1>お買い上げありがとうございます</h1>

<div>
    <p>現在のユーザー名: {{ Auth::user()->name }} </p>
    <form action="{{ url('/logout') }}" method="post">
        {{ csrf_field() }}
        <button type="submit">ログアウト</button>
    </form>
    <a href="/ec_index">商品一覧</a>
</div>

<table>
    <tr>
        <th>商品画像</th>
        <th>商品名</th>
        <th>価格</th>
        <th>数量</th>
    </tr>
@forelse ($carts as $cart)
    <tr>
        <td><img src="{{ asset('storage/photos/' . $cart->item->image) }}"></td>
    <td>{{ $cart->item->name }}</td>
    <td>{{ $cart->item->price }} 円</td>
    <td>{{ $cart->amount }} 個</td>
    </tr>
@empty
    <p>アイテムはありません</p>
@endforelse
</table>
<div>合計: {{ $sum }} 円</div>

@endsection