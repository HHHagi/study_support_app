@extends('layouts.app')


@section('content')
    <section>
        <button type="button" onclick="location.href='{{ route('targets.index') }}' ">目標一覧へ戻る</button>
        <button type="button" class="toggle_sort_form">ソート</button>

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

        @if ($targets->isEmpty())
            {{-- 目標データがDBにない場合の表示内 --}}
            <article>
                まだ目標がありません
            </article>
        @else
            {{-- 目標データがDBにある場合の表示内容 --}}
            @foreach ($targets as $target)
                <?php $target_user_id = $target->user_id; ?>
                <?php $target_user = $users->where('id', $target_user_id)->first(); ?>
                {{-- < $target_users = $users->findOrFail($target_user_id); ?> --}}
                {{-- @foreach ($target_users as $target_user) --}}
                <article>
                    <div class="frame">
                        {{-- 目標タイトルリンク表示 --}}
                        <span><a href="{{ route('targets.edit', $target->id) }}">{{ $target->title }}</a></span>
                        <div class="buttons">
                            {{-- <php dd($target); ?>  --}}
{{-- いいね機能を実装していく --}}
                            @if ($target_user_id == $user_id)
                            @else
                            <form method="post" action="{{ route('likes.store') }}" style="display:inline;">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user_id }}">
                                <input type="hidden" name="target_id" value="{{ $target->id }}">
                                <button type="submit" class="btn">
                                {{-- {{ $target->likes->user_id; }} --}}
                                <span class="material-symbols-outlined">
                                    favorite
                                </span>
                                </button>
                            </form>
                            @endif
                            <span>{{ $target_user->name }}</span>
                        </div>


                </article>
                {{-- @endforeach --}}
            @endforeach
            {{ $targets->links() }}
        @endif

    </section>

@endsection
