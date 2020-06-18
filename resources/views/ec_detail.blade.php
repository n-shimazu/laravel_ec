@extends('layouts.default')

@section('title', '購入明細')
    
@section('content')

<h1>購入明細</h1>
<table>
    <tr>
        <th>商品名</th>
        <th>価格</th>
        <th>数量</th>
        <th>小計</th>
    </tr>
@forelse ($details_data as $detail_data)
    <tr>
        <td>{{ $detail_data['name'] }}</td>
        <td>{{ $detail_data['price'] }}</td>
        <td>{{ $detail_data['amount']}}</td>
        <td>{{ $detail_data['subtotal']}}</td>
    </tr>
@empty
<p>明細はありません</p>
@endforelse
</table>
@endsection