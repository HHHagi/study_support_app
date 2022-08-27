@extends('layouts.app')


@section('content')
    <section>
        <button type="button" onclick="" data-create="" class="create-target">新しい目標をつくる</button>
        <div class="toggle-form">
            <form method="post" action="{{ route('targets.store') }}">
                @csrf

                <label>目標</label><br>
                @error('title')
                    <li>{{ $message }}</li>
                @enderror
                <textarea name="title"></textarea><br>

                <label>一般カテゴリ</label>
                @error('public_category_id')
                    <li>{{ $message }}</li>
                @enderror
                <select name="public_category_id">
                    <option value=1>なんでも</option>
                    <option value=2>心理</option>
                    <option value=3>数学</option>
                </select><br>

                <label>マイカテゴリ</label>
                @error('private_category_id')
                    <li>{{ $message }}</li>
                @enderror
                <select name="private_category_id">
                    <option value=1>なんでも</option>
                    <option value=2>心理</option>
                    <option value=3>数学</option>
                </select><br>

                <label>目標期限</label>
                @error('limit')
                    <li>{{ $message }}</li>
                @enderror
                <input name="limit" type="date"><br>

                <label>公開</label>
                @error('public')
                    <li>{{ $message }}</li>
                @enderror
                <input type="checkbox" name="is_private" value="1"> <br>

                <input type="submit">   

            </form>
        </div>

        <button type="button" onclick="" class="create">考察を追加</button>
        <div class="toggle-form">
            <form>
                <label>考察</label><br>
                <textarea></textarea><br>
                <input type="submit">
            </form>
        </div>

        <button type="button" onclick="">カテゴリ</button>
        <button type="button" onclick="">すべて</button>


        @if ($targets->isEmpty())
            {{-- 記事データがDBにない場合の表示内 --}}
            <article>
                まだ目標がありません
            </article>
        @else
            {{-- 記事データがDBにある場合の表示内容 --}}
            @foreach ($targets as $target)
                <article>
                    <h3>{{ $target->title }}</h3>
                    <p></p>
                    <p>投稿者：{{ $target->user->name }}</p>
                    @if ($target->user_id === Auth::user()->id)
                        <a href="{{ url('targets/' . $target->id . '/edit') }}" class="btn btn--blue">編集</a>
                        <form style="display: inline-block;" method="post"
                            action="{{ route('targets.destroy', $target->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn--orange">削除する</button>
                        </form>
                    @endif
                    {{-- 以下はいいね機能 --}}
                    {{-- <div>
                        @if ($target->is_liked_by_auth_user())
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
                    </div> --}}
                </article>
            @endforeach
        @endif
    </section>

@endsection
