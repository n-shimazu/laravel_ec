@extends('layouts.default')

@section('title', '購入できませんでした')

@section('content')
<h1>購入できませんでした</h1>
@forelse ($error_msgs as $error_msg)

<p>在庫が足りません: {{ $error_msg }}</p>

@empty
    <p>エラー</p>
@endforelse
@endsection