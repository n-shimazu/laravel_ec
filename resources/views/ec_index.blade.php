@extends('layouts.default')

@section('title', $title)

@section('content')

<h1>{{ $title }}</h1>
<p>現在のユーザー名: {{ Auth::user()->name }} </p>
<form action="{{ url('/logout') }}" method="post">
    {{ csrf_field() }}
    <button type="submit">ログアウト</button>
</form>

@foreach($errors->all() as $error)
<p class="error">{{ $error }}</p>
@endforeach

<section>
    <ul>
        @forelse($items as $item)
            <li>
                <div>
                <span><img src="{{ asset('storage/photos/' . $item->image) }}"></span>
                </div>
                <div>
                <span>{{ $item->name }}: </span>
                <span>{{ $item->price }}円</span>
                </div>
                <span>
                    <form method="post" action="{{ url('/ec_index/add/' . $item->id) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        @if(intval($item->stock) > 0)
                            <input type="submit" value="カートに追加する">
                        @else
                            <p>売り切れ</p>
                        @endif
                    </form>
                </span>
            </li>
            
        @empty
            <p>アイテムはありません</p>

        @endforelse
    </ul>

</section>
@endsection