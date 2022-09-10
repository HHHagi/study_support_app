@extends('layouts.app')


@section('content')
    <section>
        <button type="button" onclick="location.href='{{ route('targets.index') }}' ">戻る</button>
        <button type="button" class="toggle_target_form">新しいインプット</button>
        <button type="button" class="toggle_task_form">新しいアウトプット</button>
        <button type="button">マイカテゴリ</button>
        <button type="button">未完了</button>
        <button type="button">重要度</button>
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
        {{-- インプットの入力フォーム --}}
        <div class="toggle-form toggle_target">
            <form method="post" action="{{ route('books.store') }}">
                @csrf
                <input type="hidden" name="target_id" value="{{ $target->id }}"><br>

                <label>インプットしたい内容</label><br>
                @error('title')
                    <li>{{ $message }}</li>
                @enderror
                <textarea name="title"></textarea><br>

                <label>マイカテゴリ</label>
                @error('private_category_id')
                    <li>{{ $message }}</li>
                @enderror
                @if ($private_categories->isEmpty())
                    マイカテゴリがありません
                @else
                    <select name="private_category_id">
                        @foreach ($private_categories as $private_category)
                            <option value={{ $private_category->id }}>{{ $private_category->category }} </option>
                        @endforeach
                @endif
                </select><br>

                <label>今知っていること</label><br>
                @error('first_knowledge')
                    <li>{{ $message }}</li>
                @enderror
                <textarea name="first_knowledge"></textarea><br>

                <label>重要度</label>
                @error('priority')
                    <li>{{ $message }}</li>
                @enderror
                <select name="priority">
                    <option value="1">高い</option>
                    <option value="2">中</option>
                    <option value="3">低い</option>
                </select><br>

                <label>目標期限</label>
                @error('limit')
                    <li>{{ $message }}</li>
                @enderror
                <input name="limit" type="date"><br>

                <input type="submit">
            </form>
        </div>

        {{-- アウトプットの入力フォーム --}}
        <div class="toggle-form toggle_task">
            <form method="post" action="{{ route('tasks.store') }}">
                @csrf
                <input type="hidden" name="target_id" value="{{ $target->id }}"><br>

                <label>アウトプットしたい内容</label><br>
                @error('title')
                    <li>{{ $message }}</li>
                @enderror
                <textarea name="title"></textarea><br>

                <label>マイカテゴリ</label>
                @error('private_category_id')
                    <li>{{ $message }}</li>
                @enderror
                @if ($private_categories->isEmpty())
                    マイカテゴリがありません
                @else
                    <select name="private_category_id">
                        @foreach ($private_categories as $private_category)
                            <option value={{ $private_category->id }}>{{ $private_category->category }} </option>
                        @endforeach
                @endif
                </select><br>

                <label>今知っていること</label><br>
                @error('first_knowledge')
                    <li>{{ $message }}</li>
                @enderror
                <textarea name="first_knowledge"></textarea><br>

                <label>重要度</label>
                @error('priority')
                    <li>{{ $message }}</li>
                @enderror
                <select name="priority">
                    <option value="1">高い</option>
                    <option value="2">中</option>
                    <option value="3">低い</option>
                </select><br>

                <label>目標期限</label>
                @error('limit')
                    <li>{{ $message }}</li>
                @enderror
                <input name="limit" type="date"><br>

                <input type="submit">
            </form>
        </div>


    </section>


    {{-- インプットを表示するエリア --}}
    <section>
        インプット一覧
        {{-- データがDBにない場合の表示内 --}}
        @if ($books->isEmpty())
            <article>
                まだインプットがありません
            </article>
        @else
            {{-- データがDBにある場合の表示内容 --}}
            @foreach ($books as $book)
                <article>
                    <div class="frame">
                        @if (DB::table('book_explanations')->where('id', $book->id)->exists())
                            <span><i class="fa-solid fa-square-full"></i></span>
                        @else
                            <span><i class="fa-solid fa-square-check"></i></span>
                        @endif
                        <span>{{ $book->title }}</span>

                        <div class="buttons">
                            <button class="btn toggle_done_form">
                                @if (DB::table('book_explanations')->where('id', $book->id)->exists())
                                    完了
                                @else
                                    復習
                                @endif
                            </button>
                        </div>

                        <div class=""><button class="btn toggle_memo_form">メモ</button></div>
                        <div class="">
                            <button class="btn btn--blue toggle_target_edit_form">編集</button>
                        </div>
                        <div class="">
                            <form style="display: inline-block;" method="post"
                                action="{{ route('books.destroy', $book->id) }}">
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
                        <form method="post" action="{{ route('books.update', $book->id) }}">
                            @csrf
                            @method('PUT')
                            @error('memo')
                                <div>{{ $message }}</div>
                            @enderror
                            <textarea name="memo">{{ old('memo') ?: $book->memo }}</textarea>
                            <input type="submit" value="メモを追加・編集">
                        </form>
                    </div>

                    {{-- インプット編集フォーム --}}
                    <div class="toggle-form toggle_target">
                        <form method="post" action="{{ route('books.update', $book->id) }}">
                            @csrf
                            @method('PUT')
                            <label>インプットしたい内容</label><br>
                            @error('title')
                                <li>{{ $message }}</li>
                            @enderror
                            <textarea name="title">{{ old('title') ?: $book->title }}</textarea><br>

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

                            <label>重要度</label>
                            @error('priority')
                                <li>{{ $message }}</li>
                            @enderror
                            <select name="priority">
                                <option value="1">高い</option>
                                <option value="2">中</option>
                                <option value="3">低い</option>
                            </select><br>

                            <label>目標期限</label>
                            @error('limit')
                                <li>{{ $message }}</li>
                            @enderror
                            <input name="limit" type="date" value="{{ $target->limit->format('Y-m-d') }}"><br>

                            <button type="submit">編集完了</button>
                        </form>
                    </div>

                    {{-- 完了フォーム --}}
                    <div class="toggle-form toggle_done">
                        <form method="post" action="{{ route('book_explanations.store') }}">
                            @csrf
                            @method('POST')

                            <label>学んだ内容を説明すると</label>
                            @error('content')
                                <li>{{ $message }}</li>
                            @enderror
                            <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                            <input type="hidden" name="book_id" value="{{ $book->id }}"><br>
                            <textarea name="content">{{ old('title') }}</textarea><br>
                            <button type="submit">完了</button>
                        </form>


                        @foreach ($book_explanations as $book_explanation)
                            @if ($book_explanation->book_id === $book->id)
                                @if ($loop->index == 0)
                                    これまで学んだこと
                                @endif
                                <div class="frame">
                                    <li>{{ $book_explanation->content }}</li><br>
                                    <div class="buttons">
                                        <button class="btn btn--blue toggle_book_edit_form">編集</button>
                                    </div>
                                    <div class="">
                                        <form style="display: inline-block;" method="post"
                                            action="{{ route('books.destroy', $book->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn--orange btn_delete">削除</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            {{-- 編集フォーム --}}
                            <div class="toggle-form toggle_book">
                                <form method="post"
                                    action="{{ route('book_explanations.update', $book_explanation->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <textarea name="content" class="">{{ old('title') ?: $book_explanation->content }}</textarea><br>
                                    <button type="submit">編集を完了</button>
                                </form>
                            </div>
                        @endforeach

                    </div>

                </article>
            @endforeach
        @endif
    </section>


    {{-- アウトプットを表示するエリア --}}
    <section>
        アウトプット一覧
        {{-- データがDBにない場合の表示内 --}}
        @if ($tasks->isEmpty())
            <article>
                まだアウトプットがありません
            </article>
        @else
            {{-- データがDBにある場合の表示内容 --}}
            @foreach ($tasks as $task)
                <article>
                    <div class="frame">
                        @if ($task->is_done === 1)
                            <span><i class="fa-solid fa-square-check"></i></span>
                        @else
                            <span><i class="fa-solid fa-square-full"></i></span>
                        @endif
                        <span>{{ $task->title }}</span>
                        <div class="buttons">
                            <form method="post" action="{{ route('tasks.update', $task->id) }}">
                                @csrf
                                @method('PUT')
                                @if ($task->is_done === 1)
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
                                action="{{ route('tasks.destroy', $task->id) }}">
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
                        <form method="post" action="{{ route('tasks.update', $task->id) }}">
                            @csrf
                            @method('PUT')
                            @error('memo')
                                <div>{{ $message }}</div>
                            @enderror
                            <textarea name="memo">{{ old('memo') ?: $task->memo }}</textarea>
                            <input type="submit" value="メモを追加・編集">
                        </form>
                    </div>

                    {{-- アウトプット編集フォーム --}}
                    <div class="toggle-form toggle_target">
                        <form method="post" action="{{ route('tasks.update', $task->id) }}">
                            @csrf
                            @method('PUT')
                            <label>インプットしたい内容</label><br>
                            @error('title')
                                <li>{{ $message }}</li>
                            @enderror
                            <textarea name="title">{{ old('title') ?: $task->title }}</textarea><br>

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

                            <label>重要度</label>
                            @error('priority')
                                <li>{{ $message }}</li>
                            @enderror
                            <select name="priority">
                                <option value="1">高い</option>
                                <option value="2">中</option>
                                <option value="3">低い</option>
                            </select><br>

                            <label>目標期限</label>
                            @error('limit')
                                <li>{{ $message }}</li>
                            @enderror
                            <input name="limit" type="date" value="{{ $target->limit->format('Y-m-d') }}"><br>

                            <button type="submit">編集完了</button>
                        </form>
                    </div>

                </article>
            @endforeach
        @endif

    </section>


    {{-- 考察を表示するエリア --}}
    <section>
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
