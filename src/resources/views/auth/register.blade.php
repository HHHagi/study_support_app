@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row pb-3">
            <div class="mx-auto col col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6">
                <h1 class="text-center">Study Helper</h1>
                <div class="card mt-3">
                    <div class="card-body text-center">
                        <h2 class="h3 card-title text-center">ユーザー登録</h2>
                        @include('error_card_list')
                        <div class="card-text">
                            {{-- ここから --}}
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-floating">
                                    <input class="form-control" type="text" id="name" name="name" required
                                        value="{{ old('name') }}" placeholder="ユーザー名">
                                    <label for="floatingInput">ユーザー名</label>
                                    {{-- <small>英数字3〜16文字(登録後の変更はできません)</small> --}}
                                </div>
                                <div class="form-floating">
                                    <input class="form-control" type="text" id="email" name="email" required
                                        value="{{ old('email') }}" placeholder="メールアドレス">
                                    <label for="floatingInput">メールアドレス</label>
                                </div>
                                <div class="form-floating">
                                    <input class="form-control" type="password" id="password" name="password" required
                                        placeholder="パスワード">
                                    <label for="floatingInput">パスワード</label>
                                </div>
                                <div class="form-floating">
                                    <input class="form-control" type="password" id="password_confirmation"
                                        name="password_confirmation" required placeholder="パスワード（確認）">
                                    <label for="floatingInput">パスワード(確認)</label>
                                </div>
                                <button class="w-100 btn btn-lg btn-primary button-login" type="submit">登録</button>
                            </form>
                            {{-- ここまで --}}

                            <div class="mt-0">
                                <a href="{{ route('login') }}" class="card-text">ログインはこちら</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
