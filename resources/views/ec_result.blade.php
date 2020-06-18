@extends('layouts.default')

@section('title', '購入履歴一覧')

@section('content')

<h1>購入履歴一覧</h1>
    
<table>
    <tr>
        <th>注文番号</th>
        <th>購入日時</th>
        <th>合計金額</th>
        <th>詳細</th>
    </tr>
@forelse ($results as $result)
    <tr>
        <td>{{ $result->result_id }}</td>
        <td>{{ $result->created_at }}</td>
        <td>{{ $result->sum }}</td>
        <td>
            <form action="{{ url('/ec_detail/' . $result->result_id) }}" method="get">
                {{ csrf_field() }}
            <input type="hidden" name="result_id" value="{{ $result->result_id }}">
                <input type="submit" value="詳細へ">
            </form>
        </td>
    </tr>
@empty
    <p>注文履歴はありません</p>
@endforelse
</table>
@endsection