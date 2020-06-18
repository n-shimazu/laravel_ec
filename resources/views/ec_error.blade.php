@extends('layouts.default')

@section('title', '購入できませんでした')

@section('content')
<h1>購入できませんでした</h1>
<p>在庫が足りません: {{ $error_msg }}</p>
@endsection