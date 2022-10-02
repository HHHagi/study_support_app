@extends('layouts.app')


@section('content')
    <section>
        <button type="button" onclick="location.href='{{ route('our_targets.index') }}' ">みんなの目標をみる</button>
        <button type="button" onclick="location.href='{{ route('targets.index') }}' ">目標一覧へ戻る</button>
        <button type="button" class="toggle_target_form">新しい目標をつくる</button>
        <button type="button" class="toggle_private_category_form">マイカテゴリを作成</button>
        <button type="button" class="toggle_sort_form">ソート</button>

        <h2>自分の目標一覧</h2>

        {{-- マイカテゴリがない初期状態 --}}
        @if (!$private_categories->first())
            <div>
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
        @endif
        {{-- マイカテゴリが存在する場合の処理 --}}
        @if ($private_categories->first())
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
        @endif

        {{-- ソートするフォーム --}}
        <div class="sort_form">
            <form method="post" action="{{ route('targets.index') }}">
                @csrf
                @method('GET')
                <div class="sort-item">
                    <select name="public_category_id" class="sort_public_category">
                        <option value="" selected>公式カテゴリを選択</option>
                        <option value="">すべて</option>
                        @foreach ($public_categories as $public_category)
                            <option value={{ $public_category->id }}>{{ $public_category->category }} </option>
                        @endforeach
                    </select><br>
                </div>

                <div class="sort-item">
                    <select name="private_category_id" class="sort_private_category">
                        <option value="" selected>マイカテゴリーを選択</option>
                        <option value="">すべて</option>
                        @foreach ($private_categories as $private_category)
                            <option value={{ $private_category->id }}>{{ $private_category->category }} </option>
                        @endforeach
                    </select><br>
                </div>

                <div class="sort-item">
                    <select name="is_done" class="sort_is_done">
                        <option value="" selected>完了か未完了を選択</option>
                        <option value="">どちらも</option>
                        <option value="2">未完了</option>
                        <option value="1">完了</option>
                    </select><br>
                </div>

                <button type="submit">ソートを完了</button>
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
                    @if ($private_categories)
                        @foreach ($private_categories as $private_category)
                            <option value={{ $private_category->id }}>{{ $private_category->category }} </option>
                        @endforeach
                    @else
                        マイカテゴリーを作成してください
                    @endif
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
                <input type="checkbox" name="is_private" value="1" checked><br>

                <input type="hidden" name="is_done" value="2"> <br>

                <input type="submit">
            </form>
        </div>

        {{-- マイカテゴリがない初期状態 --}}
        @if (!$private_categories->first())
            <p>最初にマイカテゴリを作成しよう！</p>
        @endif

        @if ($targets->isEmpty())
            {{-- 目標データがDBにない場合の表示内 --}}
            <article>
                まだ目標がありません
            </article>
        @else
            {{-- 目標データがDBにある場合の表示内容 --}}
            @foreach ($targets as $target)
                <article>
                    <div class="frame">
                        {{-- チェックボックスの画像リンク表示 --}}
                        @if ($target->is_done === 1)
                            <form method="post" action="{{ route('targets.update', $target->id) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="is_done" value="2" class="btn">
                                    <span class="material-symbols-outlined">
                                        check_box
                                    </span>
                                </button>
                            </form>
                        @else
                            <form method="post" action="{{ route('targets.update', $target->id) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="is_done" value="1" class="btn">
                                    <span class="material-symbols-outlined">
                                        check_box_outline_blank
                                    </span>
                                </button>
                            </form>
                        @endif
                        {{-- 目標タイトルリンク表示 --}}
                        <span><a href="{{ route('targets.edit', $target->id) }}">{{ $target->title }}</a></span>
                        <div class="buttons">
                            {{-- エラー箇所！ --}}
                            <form method="post" action="{{ route('targets.update', $target->id) }}">
                                @csrf
                                @method('PUT')
                                @if ($target->is_done === 2)
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
                    @if ($target->memo)
                        <div class="toggle-form toggle_memo">
                            <p class="display_toggle">{{ $target->memo }}</p>
                            <button class="edit_memo display_toggle">メモを編集</button>

                            <form class="hide display_toggle2" method="post"
                                action="{{ route('targets.update', $target->id) }}">
                                @csrf
                                <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                                @method('PUT')
                                @error('memo')
                                    <div>{{ $message }}</div>
                                @enderror
                                <textarea name="memo">{{ old('memo') ?: $target->memo }}</textarea>
                                <button type="submit">編集完了</button>
                            </form>
                        </div>
                    @else
                        <div class="toggle-form toggle_memo">
                            <form method="post" action="{{ route('targets.update', $target->id) }}">
                                @csrf
                                <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                                @method('PUT')
                                @error('memo')
                                    <div>{{ $message }}</div>
                                @enderror
                                <textarea name="memo">{{ old('memo') ?: $target->memo }}</textarea>
                                <button type="submit">メモを追加</button>
                            </form>
                        </div>
                    @endif

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
                                        @if ($private_category->id === $target->private_category_id) selected @endif>
                                        {{ $private_category->category }}
                                    </option>
                                @endforeach
                            </select><br>

                            <label>目標期限</label>
                            @if (!$target->limit)
                                期限なし
                            @else
                                @error('limit')
                                    <li>{{ $message }}</li>
                                @enderror
                                <input name="limit" type="date" value="{{ $target->limit->format('Y-m-d') }}"><br>
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

                </article>
            @endforeach
            {{ $targets->links() }}
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
                            <button type="submit">編集完了</button>
                        </form>
                    </div>
                </article>
            @endforeach
            {{ $ideas->links() }}
        @endif
    </section>
@endsection
