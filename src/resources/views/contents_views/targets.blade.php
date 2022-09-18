@extends('layouts.app')


@section('content')
    <section>
        <button type="button" class="toggle_target_form">新しい目標をつくる</button>
        <button type="button">公式カテゴリ</button>
        <button type="button">マイカテゴリ</button>
        <button type="button">すべて</button>
        <button type="button" class="toggle_private_category_form">マイカテゴリを作成</button>
        <div class="toggle-form toggle_private_category">
            <form method="post" action="{{ route('private_categories.store') }}">
                @csrf
                <label>新規マイカテゴリ名</label><br>
                @error('title')
                    <li>{{ $message }}</li>
                @enderror
                <input name="category">
                <button type="submit">作成</button>
            </form>
        </div>
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
                    @foreach ($public_categories as $public_category)
                        <option value={{ $public_category->id }}>{{ $public_category->category }} </option>
                    @endforeach
                </select><br>

                <label>マイカテゴリ</label>
                @error('private_category_id')
                    <li>{{ $message }}</li>
                @enderror
                <select name="private_category_id">
                    @foreach ($private_categories as $private_category)
                        <option value={{ $private_category->id }}>{{ $private_category->category }} </option>
                    @endforeach
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
                <input type="hidden" name="is_private" value="0"> <br>
                <input type="checkbox" name="is_private" value="1"> <br>

                <input type="submit">
            </form>
        </div>

        @if ($targets->isEmpty())
            {{-- 目標データがDBにない場合の表示内 --}}
            <article>
                まだ目標がありません
            </article>
        @else
            {{-- 目標データがDBにある場合の表示内容 --}}
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
                        <span><a href="{{ route('targets.edit', $target->id) }}">{{ $target->title }}</a></span>
                        <div class="buttons">
{{-- エラー箇所！ --}}
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
                            <button class="btn btn--blue toggle_target_edit_form">編集</button>
                        </div>
                        <div class="">
                            <form style="display: inline-block;" method="post"
                                action="{{ route('targets.destroy', $target->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn--orange btn_delete">削除</button>
                            </form>
                        </div>
                        <div>
                            @if ($target->limit !== null)
                            {{ $target->limit->format('Y/m/d') }}まで
                            @else
                            @endif
                        </div>
                    </div>
                    {{-- メモの入力フォーム --}}
                    <div class="toggle-form toggle_memo">
                        <form method="post" action="{{ route('targets.update', $target->id) }}">
                            @csrf
                            @method('PUT')
                            @error('memo')
                                <div>{{ $message }}</div>
                            @enderror
                            <textarea name="memo">{{ old('memo') ?: $target->memo }}</textarea>
                            <input type="submit" value="メモを追加・編集">
                        </form>
                    </div>

                    {{-- 目標の編集フォーム --}}
                    <div class="toggle-form toggle_target">
                        <form method="post" action="{{ route('targets.update', $target->id) }}">
                            @csrf
                            @method('PUT')
                            <label>目標</label><br>
                            @error('title')
                                <li>{{ $message }}</li>
                            @enderror
                            <textarea name="title">{{ old('title') ?: $target->title }}</textarea><br>

                            <label>一般カテゴリ</label>
                            @error('public_category_id')
                                <li>{{ $message }}</li>
                            @enderror
                            <select name="public_category_id">
                                @foreach ($public_categories as $public_category)
                                    <option value="{{ $public_category->id }}"
                                        @if ($public_category->id === $target->public_category_id) selected @endif>{{ $public_category->category }}
                                    </option>
                                @endforeach
                            </select><br>

                            <label>マイカテゴリ</label>
                            @error('private_category_id')
                                <li>{{ $message }}</li>
                            @enderror
                            <select name="private_category_id">
                                @foreach ($private_categories as $private_category)
                                    <option value="{{ $private_category->id }}"
                                        @if ($private_category->id === $target->private_category_id) selected @endif>{{ $private_category->category }}
                                    </option>
                                @endforeach
                            </select><br>

                            <label>目標期限</label>
                             @if($target->limit)
                            期限なし
                            @else
                            @error('limit')
                                <li>{{ $message }}</li>
                            @enderror
                            {{-- <input name="limit" type="date" value="{{ $target->limit->format('Y-m-d') }}"><br> --}}
                             @endif
                            <label>公開</label>
                            @error('public')
                                <li>{{ $message }}</li>
                            @enderror
                            <input type="hidden" name="is_private" value="0"> <br>
                            <input type="checkbox" name="is_private" value="1"> <br>

                            <button type="submit">編集完了</button>
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
        
{{-- エラー箇所！バリデーションを設定すること --}}
        <button type="button" onclick="" class="create toggle_idea_form">考察を追加</button>
        <div class="toggle-form toggle_idea">
            <form method="post" action="{{ route('ideas.store') }}">
                @csrf
                @error('idea')
                <li>{{ $message }}</li>
                @enderror
                <label>考察</label><br>
                <textarea name="idea"></textarea><br>
                <input type="submit">
            </form>
        </div>
        @if ($ideas->isEmpty())
            {{-- 考察データがDBにない場合 --}}
            <article>
                まだ考察がありません
            </article>
        @else
            {{-- 考察データがDBにある場合 --}}
            @foreach ($ideas as $idea)
                <article>
                    <div class="frame">
                        <span>{{ $idea->idea }}</span>
                        <div class="buttons">
                            <button class="btn btn--blue toggle_idea_edit_form">編集</button>
                            <form style="display: inline-block;" method="post"
                                action="{{ route('ideas.destroy', $idea->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn--orange btn_delete">削除</button>
                            </form>
                        </div>
                    </div>
                    {{-- 考察の編集フォーム --}}
                    <div class="toggle-form toggle_idea">
                        <form method="post" action="{{ route('ideas.update', $idea->id) }}">
                            @csrf
                            @method('PUT')
                            <label>考察</label><br>
                            <textarea name="idea">{{ old('idea') ?: $idea->idea }}</textarea><br>
                            <button type="submit">編集を完了</button>
                        </form>
                    </div>
                </article>
            @endforeach
        @endif
    </section>
@endsection
