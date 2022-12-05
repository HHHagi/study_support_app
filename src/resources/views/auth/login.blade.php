@extends('layouts.app')

@section('content')
    <div class="container" style="height: 100%">
        <div class="row pb-3">
            <div class="mx-auto col col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6" style="height: 100%">
                <h1 class="text-center">Study Helper</h1>
                <div class="card mt-3">
                    <div class="card-body text-center">
                        <h2 class="h3 card-title text-center mt-2"></h2>
                        @include('error_card_list')
                        <a href="{{ route('login.{provider}', ['provider' => 'google']) }}" class="btn btn-block btn-danger">
                            <i class="fab fa-google mr-1"></i>Googleでログイン
                          </a>
                        <div class="card-text">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-floating">
                                    <input class="form-control email-login" type="email" id="email" name="email" required
                                        value="{{ old('email') }}" placeholder="name@example.com">
                                    <label for="floatingInput">メールアドレス</label>
                                </div>
                                <div class="form-floating">
                                    <input class="form-control password-login" type="password" id="password" name="password" required
                                        placeholder="Password">
                                    <label for="floatingInput">パスワード</label>
                                </div>
                                {{-- ここから --}}
                                <input type="hidden" name="remember" id="remember" value="on">
                                {{-- ここまで --}}
                                <button class="w-100 btn btn-lg btn-primary button-login" type="submit">ログイン</button>
                            </form>
                            <div class="mt-0">
                                <a href="{{ route('register') }}" class="card-text">ユーザー登録はこちら</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
