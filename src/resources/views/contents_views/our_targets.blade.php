@extends('layouts.app')


@section('content')
    <section class="container">
        <button type="button" onclick="location.href='{{ route('targets.index') }}' " class="btn btn-outline-dark fs-6 mt-2"
            data-mdb-ripple-color="dark">自分の目標一覧</button>
        <button type="button" onclick="location.href='{{ route('our_targets.index') }}' "
            class="btn btn-outline-dark fs-6 mt-2" data-mdb-ripple-color="dark">すべてを表示</button>
        <button type="button" class="toggle_sort_form btn btn-outline-dark fs-6 mt-2"
            data-mdb-ripple-color="dark">ソート</button><br>



        {{-- ソートするフォーム --}}
        <div class="sort_form mt-2">
            <form method="get" action="{{ route('our_targets.index') }}">
                @method('GET')
                <div class="sort-item mb-1">
                    <select name="public_category_id" class="sort_public_category">
                        <option value="" selected>公式カテゴリを選択</option>
                        @foreach ($public_categories as $public_category)
                            <option value={{ $public_category->id }}>{{ $public_category->category }} </option>
                        @endforeach
                    </select>
                </div>
                <br>
                <button type="submit" class="btn btn-outline-dark btn-sm" data-mdb-ripple-color="dark">ソートを完了</button>
            </form>
        </div>

        <div class="serch-box">
            <form method="GET" action="{{ route('our_targets.edit', 1) }}">
                <div class="mb-3">
                    <label for="target-serch" class="form-label">目標を検索</label>
                    <textarea type="text" name="target_title" class="target-search-input" id="target-serch"></textarea>
                    <button type="submit" class="btn btn-outline-dark btn-sm" data-mdb-ripple-color="dark">検索を実行</button>
                </div>
            </form>
        </div>

        <h3 class="index-title">みんなの目標一覧</h3>

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
                        <span><a href="{{ route('our_targets.show', $target->id) }}">{{ $target->title }}</a></span>
                        <div class="buttons">
                            {{-- いいね機能 --}}
                            @if ($target_user_id == $user_id)
                            @else
                                @if ($target->is_liked_by_auth_user())
                                    <form method="post" action="{{ route('likes.destroy', $target->id) }}"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                                        <input type="hidden" name="target_id" value="{{ $target->id }}">

                                        <button type="submit" class="btn btn-sm like-button" style="border: none;">
                                            <span class="material-symbols-outlined like-icon"
                                                style=" font-variation-settings:'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 48">
                                                favorite
                                            </span>
                                            {{ $target->likes->count() }}
                                        </button>
                                    </form>
                                @else
                                    <form method="post" action="{{ route('likes.store') }}" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                                        <input type="hidden" name="target_id" value="{{ $target->id }}">
                                        <button type="submit" class="btn btn-sm" style="border: none;">
                                            <span class="material-symbols-outlined">
                                                favorite
                                            </span>
                                        </button>
                                @endif
                                </form>
                            @endif
                        </div>
                        <div class="good-button-right">
                            <span>{{ $target_user->name }}</span>
                        </div>
                </article>
            @endforeach
            {{ $targets->links() }}
        @endif
    </section>
@endsection
