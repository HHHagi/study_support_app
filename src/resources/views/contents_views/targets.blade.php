@extends('layouts.app')


@section('content')
    <section>
        <button type="button" onclick="" data-create="" class="toggle_target_form">新しい目標をつくる</button>
        <button type="button" onclick="">カテゴリ</button>
        <button type="button" onclick="">すべて</button>
        {{-- 目標の入力フォーム --}}
        <div class="toggle-form toggle_target">
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

        @if ($targets->isEmpty())
            {{-- 記事データがDBにない場合の表示内 --}}
            <article>
                まだ目標がありません
            </article>
        @else
            {{-- 記事データがDBにある場合の表示内容 --}}
            @foreach ($targets as $target)
                {{-- @if ($target->user_id === Auth::user()->id) --}}
                <article>
                    {{-- <p>投稿者：{{ $target->user->name }}</p> --}}
                    <div class="frame">
                        @if ($target->is_done === 1)
                        <span><i class="fa-solid fa-square-check"></i></span>
                        @else
                        <span><i class="fa-solid fa-square-full"></i></span>
                        @endif
                        <span>{{ $target->title }}</span>
                        <div class="buttons">
                            <form method="post" action="{{ route('targets.update', $target->id) }}">
                                @csrf
                                @method('PUT')
                                @if ($target->is_done === 1)
                                <button type="submit" name="is_done" value="0" class="btn">復習</button>
                                @else
                                <button type="submit" name="is_done" value="1" class="btn">完了</button>
                                @endif
                            </form>
                        </div>
                        <div class=""><button class="btn toggle_memo_form">メモ</button></div>
                        <div class="">
                            <a href="{{ url('targets/' . $target->id . '/edit') }}" class="btn btn--blue">編集</a>
                        </div>
                        <div class="">
                            <form style="display: inline-block;" method="post"
                                action="{{ route('targets.destroy', $target->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn--orange">削除</button>
                            </form>
                        </div>
                    </div>
                    {{-- メモの入力フォーム --}}
                    <div class="toggle-form toggle_memo">
                        <form method="post" action="{{ route('targets.update', $target->id) }}">
                            @csrf
                            @method('PUT')
                            @error('message')
                                <div>{{ $message }}</div>
                            @enderror
                            <textarea name="memo">{{ old('memo') ?: $target->memo }}</textarea>
                            <input type="submit" value="メモを追加・編集">
                        </form>
                    </div>

                    {{-- @endif --}}
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
    <section>
        <button type="button" onclick="" class="create toggle_idea_form">考察を追加</button>
        <div class="toggle-form toggle_idea">
            <form method="post" action="{{ route('ideas.store') }}">
                @csrf
                <label>考察</label><br>
                <textarea name="idea"></textarea><br>
                <input type="submit">
            </form>
        </div>
    </section>

@endsection
