@extends('layouts.default')

@section('title', $title)

@section('content')

    <h1>{{ $title }}</h1>

    <form method="post" action="{{ url("/messages") }}" enctype="multipart/form-data">
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
        