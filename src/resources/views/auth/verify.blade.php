@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">メールアドレス認証を行ってください</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            新規認証メールを再送信しました！
                        </div>
                    @endif

                    お送りした認証メール内のリンクをクリックして認証してください。<br>
                    もし認証メールを受け取っていない場合、
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">こちらをのリンク</button>をクリックして認証メールを受け取ってください。
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
