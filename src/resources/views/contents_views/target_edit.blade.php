@extends('layouts.app')


@section('content')
    <section class="container">
        <h3 class="h3-css">目標：{{ $target->title }}</h3>
        <button type="button" onclick="location.href='{{ route('targets.index') }}' " class="btn btn-outline-dark fs-6"
            data-mdb-ripple-color="dark">目標一覧</button>
        <button type="button" onclick="location.href='{{ route('targets.edit', $target->id) }}' "
            class="btn btn-outline-dark fs-6" data-mdb-ripple-color="dark">すべてを表示</button>
        <button type="button" class="toggle_target_form btn btn-outline-dark fs-6"
            data-mdb-ripple-color="dark">新規インプット</button>
        <button type="button" class="toggle_task_form btn btn-outline-dark fs-6"
            data-mdb-ripple-color="dark">新規アウトプット</button>
        <button type="button" class="toggle_private_category_form btn btn-outline-dark fs-6"
            class="btn btn-outline-dark fs-6" data-mdb-ripple-color="dark">マイカテゴリを作成</button>
        <button type="button" class="toggle_sort_form btn btn-outline-dark fs-6"
            data-mdb-ripple-color="dark">ソート</button><br>

        <div class="serch-box">
            <form method="GET" action="{{ route('targets.edit', $target->id) }}">
                <label>目標を検索
                    <input type="text" name="target_title">
                </label>
                <button type="submit" class="btn btn-outline-dark btn-sm" data-mdb-ripple-color="dark">検索を実行</button>
            </form>
        </div>

        <div class="toggle-form toggle_private_category">
            <form method="post" action="{{ route('private_categories.store') }}" class="mb-2">
                @csrf
                <input type="hidden" name="target_id" value="{{ $target->id }}">
                <label>新規マイカテゴリ名</label><br>
                @error('title')
                    <li>{{ $message }}</li>
                @enderror
                <input name="category">
                <button type="submit" class="btn btn-outline-dark btn-sm" data-mdb-ripple-color="dark">作成</button>
            </form>
        </div>
        {{-- ソートするフォーム --}}
        <div class="sort_form">
            <form method="post" action="{{ route('targets.edit', $target->id) }}">
                @csrf
                @method('GET')
                <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
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
                <div class="sort-item">
                    <select name="priority" class="sort_priority">
                        <option value="" selected>重要度を選択</option>
                        <option value="">すべて</option>
                        <option value="1">高い</option>
                        <option value="2">中</option>
                        <option value="3">低い</option>
                    </select><br>
                </div>
                <button type="submit" class="btn btn-outline-dark fs-6" data-mdb-ripple-color="dark">ソートを完了</button>
            </form>
        </div>


        {{-- インプットの入力フォーム --}}
        <div class="toggle-form toggle_target">
            <form method="post" action="{{ route('books.store') }}">
                @csrf
                <input type="hidden" name="target_id" value="{{ $target->id }}">
                <input type="hidden" name="is_done" value="0">

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
                    </select><br>
                @endif

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

                <button type="submit" class="btn btn-outline-dark btn-sm" data-mdb-ripple-color="dark">作成</button>
            </form>
        </div>

        {{-- アウトプットの入力フォーム --}}
        <div class="toggle-form toggle_task">
            <form method="post" action="{{ route('tasks.store') }}">
                @csrf
                <input type="hidden" name="target_id" value="{{ $target->id }}">
                <input type="hidden" name="is_done" value="0">
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

                <button type="submit" class="btn btn-outline-dark btn-sm" data-mdb-ripple-color="dark">作成</button>
            </form>
        </div>
    </section>


    {{-- インプットを表示するエリア --}}
    <section class="container">
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
                        @if (DB::table('book_explanations')->where('book_id', $book->id)->exists())
                            <span class="material-symbols-outlined">
                                check_box
                            </span>
                        @else
                            <span class="material-symbols-outlined">
                                check_box_outline_blank
                            </span>
                        @endif
                        <span>{{ $book->title }}</span>

                        <div class="buttons">
                            <button class="btn toggle_done_form btn-primary btn-css">
                                @if (DB::table('book_explanations')->where('book_id', $book->id)->exists())
                                    復習
                                @else
                                    完了
                                @endif
                            </button>
                        </div>

                        <div class=""><button class="btn toggle_memo_form btn-primary btn-css">メモ</button></div>
                        <div class="">
                            <button class="btn btn-primary toggle_target_edit_form btn-css">編集</button>
                        </div>
                        <div class="">
                            <form style="display: inline;" method="post"
                                action="{{ route('books.destroy', $book->id) }}">
                                @csrf
                                <input type="hidden" name="target_id" value="{{ $target->id }}">
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary btn_delete btn-css">削除</button>
                            </form>
                        </div>

                        <div style="display: inline;">
                            <?php $book_explanations_count = $book->book_explanations_count; ?>
                            @for ($i = 0; $i < $book_explanations_count; $i++)
                                <span class="material-symbols-outlined">
                                    check_box
                                </span>
                            @endfor
                            @for ($i = 0; $i < 7 - $book_explanations_count; $i++)
                                <span class="material-symbols-outlined">
                                    check_box_outline_blank
                                </span>
                            @endfor
                        </div>

                    </div>
                    {{-- メモの入力フォーム --}}
                    @if ($book->memo)
                        <div class="toggle-form toggle_memo">
                            <p class="display_toggle">{{ $book->memo }}</p>
                            <button class="edit_memo display_toggle btn btn-outline-dark fs-6"
                                data-mdb-ripple-color="dark">メモを編集</button>

                            <form class="hide display_toggle2" method="post"
                                action="{{ route('books.update', $book->id) }}">
                                @csrf
                                <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                                @method('PUT')
                                @error('memo')
                                    <div>{{ $message }}</div>
                                @enderror
                                <textarea name="memo">{{ old('memo') ?: $book->memo }}</textarea>
                                <button type="submit" class="btn btn-outline-dark fs-6"
                                    data-mdb-ripple-color="dark">編集完了</button>
                            </form>
                        </div>
                    @else
                        <div class="toggle-form toggle_memo">
                            <form method="post" action="{{ route('books.update', $book->id) }}">
                                @csrf
                                <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                                @method('PUT')
                                @error('memo')
                                    <div>{{ $message }}</div>
                                @enderror
                                <textarea name="memo">{{ old('memo') ?: $book->memo }}</textarea>
                                <button type="submit" class="btn btn-outline-dark fs-6"
                                    data-mdb-ripple-color="dark">メモを追加</button>
                            </form>
                        </div>
                    @endif

                    {{-- インプット編集フォーム --}}
                    <div class="toggle-form toggle_target">
                        <form method="post" action="{{ route('books.update', $book->id) }}">
                            @csrf
                            <input type="hidden" name="target_id" value="{{ $target->id }}">
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
                                        @if ($private_category->id === $book->private_category_id) selected @endif>{{ $private_category->category }}
                                    </option>
                                @endforeach
                            </select><br>

                            <label>重要度</label>
                            @error('priority')
                                <li>{{ $message }}</li>
                            @enderror
                            <select name="priority">
                                <option value="1" @if ($book->priority == '1') selected @endif>高い</option>
                                <option value="2" @if ($book->priority == '2') selected @endif>中</option>
                                <option value="3" @if ($book->priority == '3') selected @endif>低い</option>
                            </select><br>

                            <button type="submit" class="btn btn-outline-dark btn-sm mb-2"
                                data-mdb-ripple-color="dark">編集完了</button>
                        </form>
                    </div>

                    {{-- 完了の入力フォーム --}}
                    <div class="toggle-form toggle_done">
                        <form method="post" action="{{ route('book_explanations.store') }}">
                            @csrf
                            <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                            @method('POST')

                            <label>学んだ内容を説明すると</label>
                            @error('content')
                                <li>{{ $message }}</li>
                            @enderror
                            <input type="hidden" name="target_id" value="{{ $target->id }}">
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <input type="hidden" name="is_done" value="1">
                            <textarea name="content">{{ old('title') }}</textarea><br>
                            <button type="submit" class="btn btn-outline-dark fs-6"
                                data-mdb-ripple-color="dark">完了</button>
                        </form>

                        @if (DB::table('book_explanations')->where('book_id', $book->id)->exists())
                            これまで学んだこと
                        @endif
                        @foreach ($book_explanations as $book_explanation)
                            @if ($book_explanation->book_id === $book->id)
                                <div class="frame">
                                    <li class="js_count_explanation">{{ $book_explanation->content }}</li><br>
                                    <div class="buttons">
                                        <button class="btn btn-primary toggle_book_edit_form">編集</button>
                                    </div>
                                    <div class="">
                                        <form style="display: inline-block;" method="post"
                                            action="{{ route('book_explanations.destroy', $book_explanation->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-primary btn_delete">削除</button>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            {{-- 編集フォーム --}}
                            <div class="toggle-form toggle_book">
                                <form method="post"
                                    action="{{ route('book_explanations.update', $book_explanation->id) }}">
                                    @csrf
                                    <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                                    @method('PUT')
                                    <textarea name="content" class="">{{ old('title') ?: $book_explanation->content }}</textarea><br>
                                    <button type="submit" class="btn btn-outline-dark fs-6"
                                        data-mdb-ripple-color="dark">編集を完了</button>
                                </form>
                            </div>
                        @endforeach

                        <div class="first-knowledge">最初に知っていたこと
                            <li>{{ $book->first_knowledge }}</li><br>
                        </div>

                    </div>

                </article>
            @endforeach
            {{ $books->links() }}
        @endif
    </section>


    {{-- アウトプットを表示するエリア --}}
    <section class="container">
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
                        @if (DB::table('task_explanations')->where('task_id', $task->id)->exists())
                            <span class="material-symbols-outlined">
                                check_box
                            </span>
                        @else
                            <span class="material-symbols-outlined">
                                check_box_outline_blank
                            </span>
                        @endif
                        <span>{{ $task->title }}</span>
                        {{-- 編集中 --}}
                        <div class="buttons">
                            <button class="btn toggle_done_form btn-primary btn-css">
                                @if (DB::table('task_explanations')->where('task_id', $task->id)->exists())
                                    復習
                                @else
                                    完了
                                @endif
                            </button>
                        </div>

                        <div class=""><button class="btn toggle_memo_form btn-primary btn-css">メモ</button></div>
                        <div class="">
                            <button class="btn btn-primary toggle_target_edit_form btn-css">編集</button>
                        </div>
                        <div class="">
                            <form style="display: inline-block;" method="post"
                                action="{{ route('tasks.destroy', $task->id) }}">
                                @csrf
                                <input type="hidden" name="target_id" value="{{ $target->id }}">
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary btn_delete btn-css">削除</button>
                            </form>
                        </div>

                        <div style="display: inline;">
                            <?php $task_explanations_count = $task->task_explanations_count; ?>
                            @for ($i = 0; $i < $task_explanations_count; $i++)
                                <span class="material-symbols-outlined">
                                    check_box
                                </span>
                            @endfor
                            @for ($i = 0; $i < 7 - $task_explanations_count; $i++)
                                <span class="material-symbols-outlined">
                                    check_box_outline_blank
                                </span>
                            @endfor
                        </div>
                    </div>
                    {{-- メモの入力フォーム --}}
                    @if ($task->memo)
                        <div class="toggle-form toggle_memo">
                            <p class="display_toggle">{{ $task->memo }}</p>
                            <button class="edit_memo display_toggle btn btn-outline-dark fs-6"
                                data-mdb-ripple-color="dark">メモを編集</button>

                            <form class="hide display_toggle2" method="post"
                                action="{{ route('tasks.update', $task->id) }}">
                                @csrf
                                <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                                @method('PUT')
                                @error('memo')
                                    <div>{{ $message }}</div>
                                @enderror
                                <textarea name="memo">{{ old('memo') ?: $task->memo }}</textarea>
                                <button type="submit" class="btn btn-outline-dark fs-6"
                                    data-mdb-ripple-color="dark">編集完了</button>
                            </form>
                        </div>
                    @else
                        <div class="toggle-form toggle_memo">
                            <form method="post" action="{{ route('tasks.update', $task->id) }}">
                                @csrf
                                <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                                @method('PUT')
                                @error('memo')
                                    <div>{{ $message }}</div>
                                @enderror
                                <textarea name="memo">{{ old('memo') ?: $task->memo }}</textarea>
                                <button type="submit" class="btn btn-outline-dark fs-6"
                                    data-mdb-ripple-color="dark">メモを追加</button>
                            </form>
                        </div>
                    @endif

                    {{-- アウトプット編集フォーム --}}
                    <div class="toggle-form toggle_target">
                        <form method="post" action="{{ route('tasks.update', $task->id) }}">
                            @csrf
                            <input type="hidden" name="target_id" value="{{ $target->id }}">
                            @method('PUT')
                            <label>アウトプットしたい内容</label><br>
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
                                        @if ($private_category->id === $task->private_category_id) selected @endif>
                                        {{ $private_category->category }}
                                    </option>
                                @endforeach
                            </select><br>

                            <label>重要度</label>
                            @error('priority')
                                <li>{{ $message }}</li>
                            @enderror
                            <select name="priority">
                                <option value="1" @if ($task->priority == '1') selected @endif>高い</option>
                                <option value="2" @if ($task->priority == '2') selected @endif>中</option>
                                <option value="3" @if ($task->priority == '3') selected @endif>低い</option>
                            </select><br>

                            <button type="submit" class="btn btn-outline-dark btn-sm mb-2"
                                data-mdb-ripple-color="dark">編集完了</button>
                        </form>
                    </div>

                    {{-- 完了フォーム --}}
                    <div class="toggle-form toggle_done">
                        <form method="post" action="{{ route('task_explanations.store') }}">
                            @csrf
                            <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                            @method('POST')

                            <label>学んだ内容を説明すると</label>
                            @error('content')
                                <li>{{ $message }}</li>
                            @enderror
                            <input type="hidden" name="target_id" value="{{ $target->id }}">
                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                            <input type="hidden" name="is_done" value="1">
                            <textarea name="content">{{ old('title') }}</textarea><br>
                            <button type="submit" class="btn btn-outline-dark fs-6"
                                data-mdb-ripple-color="dark">完了</button>
                        </form>

                        @if (DB::table('task_explanations')->where('task_id', $task->id)->exists())
                            これまで学んだこと
                        @endif

                        @foreach ($task_explanations as $task_explanation)
                            @if ($task_explanation->task_id === $task->id)
                                <div class="frame">
                                    <li>{{ $task_explanation->content }}</li><br>
                                    <div class="buttons">
                                        <button class="btn btn-primary toggle_book_edit_form">編集</button>
                                    </div>
                                    <div class="">
                                        <form style="display: inline-block;" method="post"
                                            action="{{ route('task_explanations.destroy', $task_explanation->id) }}">
                                            @csrf
                                            <input type="hidden" name="target_id" value="{{ $target->id }}">
                                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-primary btn_delete">削除</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            {{-- 編集フォーム？ --}}
                            <div class="toggle-form toggle_book">
                                <form method="post"
                                    action="{{ route('task_explanations.update', $task_explanation->id) }}">
                                    @csrf
                                    <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                                    @method('PUT')
                                    <textarea name="content" class="">{{ old('title') ?: $task_explanation->content }}</textarea><br>
                                    <button type="submit" class="btn btn-outline-dark fs-6"
                                        data-mdb-ripple-color="dark">編集を完了</button>
                                </form>
                            </div>
                        @endforeach

                        <div class="first-knowledge">
                            最初に知っていたこと
                            <li>{{ $book->first_knowledge }}</li><br>
                        </div>
                </article>
            @endforeach
            {{ $tasks->links() }}
        @endif

    </section>

@endsection
