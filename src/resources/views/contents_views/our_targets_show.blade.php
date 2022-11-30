@extends('layouts.app')


@section('content')
    <section class="container mb-4">
        <h3 class="h3-css">目標：{{ $target->title }}</h3>
        <div class="mb-2">
            <button type="button" onclick="location.href='{{ route('our_targets.index') }}' "
                class="btn btn-outline-dark fs-6" data-mdb-ripple-color="dark">みんなの目標へ戻る</button>
            @if ($target->user_id !== $user_id)
                <button type="button" class="toggle_sort_form_copy btn btn-outline-dark fs-6"
                    data-mdb-ripple-color="dark">自分の目標へコピーする </button>
            @endif
        </div>
        {{-- 目標コピーフォーム --}}
        <div class="sort_form mb-3">
            <form method="post" action="{{ route('our_targets.store') }}">
                @csrf
                <input type="hidden" name="target_id" value="{{ $target->id }}">
                <input type="hidden" name="title" value="{{ $target->title }}">
                <input type="hidden" name="public_category_id" value="{{ $target->public_category_id }}">
                {{-- マイカテゴリーを選んでもらう --}}
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
                <input name="limit" type="date">
                <input type="hidden" name="is_private" value="0">
                <input type="hidden" name="is_done" value="2">
                <button type="submit" class="btn btn-outline-dark btn-sm" data-mdb-ripple-color="dark">コピーを実行</button>
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
                        <span>{{ $book->title }}</span>
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
                        <span>{{ $task->title }}</span>
                    </div>
                </article>
            @endforeach
            {{ $tasks->links() }}
        @endif

    </section>

@endsection
