@extends('layouts.app')


@section('content')
    <section>
        <h2>目標：{{ $target->title }}</h2>
        <button type="button" onclick="location.href='{{ route('targets.index') }}' ">目標一覧へ戻る</button>
        <button type="button" class="toggle_target_form">新しいインプット</button>
        <button type="button" class="toggle_task_form">新しいアウトプット</button>
        <button type="button" class="toggle_private_category_form">マイカテゴリを作成</button>
        <button type="button" class="toggle_sort_form">ソート</button>
        <div class="toggle-form toggle_private_category">
            <form method="post" action="{{ route('private_categories.store') }}">
                @csrf
                <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                <label>新規マイカテゴリ名</label><br>
                @error('title')
                    <li>{{ $message }}</li>
                @enderror
                <input name="category">
                <button type="submit">作成</button>
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
                <button type="submit">ソートを完了</button>
            </form>
        </div>


        {{-- インプットの入力フォーム --}}
        <div class="toggle-form toggle_target">
            <form method="post" action="{{ route('books.store') }}">
                @csrf
                <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                <input type="hidden" name="is_done" value="0"><br>

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

                <button type="submit">作成</button>
            </form>
        </div>

        {{-- アウトプットの入力フォーム --}}
        <div class="toggle-form toggle_task">
            <form method="post" action="{{ route('tasks.store') }}">
                @csrf
                <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                <input type="hidden" name="is_done" value="0"><br>

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

                <button type="submit">作成</button>
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
                            <button class="btn toggle_done_form">
                                @if (DB::table('book_explanations')->where('book_id', $book->id)->exists())
                                    復習
                                @else
                                    完了
                                @endif
                            </button>
                        </div>

                        <div class=""><button class="btn toggle_memo_form">メモ</button></div>
                        <div class="">
                            <button class="btn btn--blue toggle_target_edit_form">編集</button>
                        </div>
                        <div class="">
                            <form style="display: inline;" method="post" action="{{ route('books.destroy', $book->id) }}">
                                @csrf
                                <input type="hidden" name="target_id" value="{{ $target->id }}">
                                @method('DELETE')
                                <button type="submit" class="btn btn--orange btn_delete">削除</button>
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
                            <button class="edit_memo display_toggle">メモを編集</button>

                            <form class="hide display_toggle2" method="post" action="{{ route('books.update', $book->id) }}">
                                @csrf
                                <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                                @method('PUT')
                                @error('memo')
                                <div>{{ $message }}</div>
                                @enderror
                                <textarea name="memo">{{ old('memo') ?: $book->memo }}</textarea>
                                <button type="submit">編集完了</button>
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
                                <button type="submit">メモを追加</button>
                            </form>
                        </div>
                    @endif

                    {{-- インプット編集フォーム --}}
                    <div class="toggle-form toggle_target">
                        <form method="post" action="{{ route('books.update', $book->id) }}">
                            @csrf
                            <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
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

                            <button type="submit">編集完了</button>
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
                            <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                            <input type="hidden" name="book_id" value="{{ $book->id }}"><br>
                            <input type="hidden" name="is_done" value="1"><br>
                            <textarea name="content">{{ old('title') }}</textarea><br>
                            <button type="submit">完了</button>
                        </form>


                        @foreach ($book_explanations as $book_explanation)
                            @if ($book_explanation->book_id === $book->id)
                                これまで学んだこと
                                <div class="frame">
                                    <li class="js_count_explanation">{{ $book_explanation->content }}</li><br>
                                    <div class="buttons">
                                        <button class="btn btn--blue toggle_book_edit_form">編集</button>
                                    </div>
                                    <div class="">
                                        <form style="display: inline-block;" method="post"
                                            action="{{ route('book_explanations.destroy', $book_explanation->id) }}">
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
                                    <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                                    @method('PUT')
                                    <textarea name="content" class="">{{ old('title') ?: $book_explanation->content }}</textarea><br>
                                    <button type="submit">編集を完了</button>
                                </form>
                            </div>
                        @endforeach

                    </div>

                </article>
            @endforeach
            {{ $books->links() }}
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
                            <button class="btn toggle_done_form">
                                @if (DB::table('task_explanations')->where('task_id', $task->id)->exists())
                                    復習
                                @else
                                    完了
                                @endif
                            </button>
                        </div>

                        <div class=""><button class="btn toggle_memo_form">メモ</button></div>
                        <div class="">
                            <button class="btn btn--blue toggle_target_edit_form">編集</button>
                        </div>
                        <div class="">
                            <form style="display: inline-block;" method="post"
                                action="{{ route('tasks.destroy', $task->id) }}">
                                @csrf
                                <input type="hidden" name="target_id" value="{{ $target->id }}">
                                @method('DELETE')
                                <button type="submit" class="btn btn--orange btn_delete">削除</button>
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
                    @if($task->memo)
                    <div class="toggle-form toggle_memo">
                        <p class="display_toggle">{{ $task->memo }}</p>
                        <button class="edit_memo display_toggle">メモを編集</button>

                        <form class="hide display_toggle2" method="post" action="{{ route('tasks.update', $task->id) }}">
                            @csrf
                            <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                            @method('PUT')
                            @error('memo')
                            <div>{{ $message }}</div>
                            @enderror
                            <textarea name="memo">{{ old('memo') ?: $task->memo }}</textarea>
                            <button type="submit">編集完了</button>
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
                            <button type="submit">メモを追加</button>
                        </form>
                    </div>
                    @endif

                    {{-- アウトプット編集フォーム --}}
                    <div class="toggle-form toggle_target">
                        <form method="post" action="{{ route('tasks.update', $task->id) }}">
                            @csrf
                            <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
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

                            <button type="submit">編集完了</button>
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
                            <input type="hidden" name="target_id" value="{{ $target->id }}"><br>
                            <input type="hidden" name="task_id" value="{{ $task->id }}"><br>
                            <input type="hidden" name="is_done" value="1"><br>
                            <textarea name="content">{{ old('title') }}</textarea><br>
                            <button type="submit">完了</button>
                        </form>


                        @foreach ($task_explanations as $task_explanation)
                            @if ($task_explanation->task_id === $task->id)
                                これまで学んだこと
                                <div class="frame">
                                    <li>{{ $task_explanation->content }}</li><br>
                                    <div class="buttons">
                                        <button class="btn btn--blue toggle_book_edit_form">編集</button>
                                    </div>
                                    <div class="">
                                        <form style="display: inline-block;" method="post"
                                            action="{{ route('task_explanations.destroy', $task_explanation->id) }}">
                                            @csrf
                                            <input type="hidden" name="target_id" value="{{ $target->id }}">
                                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                                            @method('DELETE')
                                            <button type="submit" class="btn btn--orange btn_delete">削除</button>
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
                                    <button type="submit">編集を完了</button>
                                </form>
                            </div>
                        @endforeach

                </article>
            @endforeach
            {{ $tasks->links() }}
        @endif

    </section>

@endsection
