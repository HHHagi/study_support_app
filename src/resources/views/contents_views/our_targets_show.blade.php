@extends('layouts.app')


@section('content')
    <section>
        <h2>目標：{{ $target->title }}</h2>
        <button type="button" onclick="location.href='{{ route('our_targets.index') }}' ">みんなの目標へ戻る</button>
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
                        <span>{{ $book->title }}</span>
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
                        <span>{{ $task->title }}</span>
                    </div>
                </article>
            @endforeach
            {{ $tasks->links() }}
        @endif

    </section>

@endsection