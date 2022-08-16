@extends('layouts.app')

@section('content')
てすてす！
@foreach($targets as $target )
<article>
    てすてす！！！
    <h3>{{$target->title}}</h3>
    <p>{{$target->message}}</p>
    <p>投稿者：{{$target->user->name}}</p>
    @if($target->user_id === Auth::user()->id )
    <a href="{{ url('targets/'.$target->id.'/edit') }}" class="btn btn--blue">編集</a>
    <form style="display: inline-block;" method="post" action="{{ route('targets.destroy', $target->id) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn--orange">削除する</button>
    </form>
    @endif
    <div>
        @if($target->is_liked_by_auth_user())
        <a href="{{ route('target.unlike', ['id' => $target->id]) }}">
            <i class="fas fa-heart"></i>
        </a>
        <span>{{ $target->likes->count() }}</span>
        @else
        <a href="{{ route('target.like', ['id' => $target->id]) }}">
            <i class="far fa-heart"></i>
        </a>
        <span>{{ $target->likes->count() }}</span>
        @endif
    </div>
</article>
@endforeach

@endsection