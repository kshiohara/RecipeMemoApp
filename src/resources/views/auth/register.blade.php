@extends('layouts.app')

@section('content')

<div class="container" style="width: 60%">
    <h4 class="text-center mt-3 mb-5">新規登録画面</h4>
    <!-- Validation Errors -->
    @if($errors->any())
        <div class="mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="" style="background-color:#F9F9F9; border:1px solid #c3c3c3; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); padding: 10px 40px;">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- 氏名入力 -->
        <div class="mt-5">
            <label for="name" class="form-label">氏名</label>
            <div class="d-flex align-items-center">
            <input id="name" class="block mt-1 form-control" type="text" name="name" value="{{ old('name') }}" required autofocus/>
        </div>

        <!-- フリガナ入力 -->
        <div class="mt-3">
            <label for="kana" class="form-label">フリガナ</label>
            <input id="kana" class="block mt-1 form-control" type="text" name="kana" value="{{ old('kana') }}" required autofocus/>
        </div>

        <!-- メールアドレス入力 -->
        <div class="mt-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input id="email" class="block mt-1 form-control" type="email" name="email" value="{{ old('email') }}" required autofocus/>
        </div>

        <!-- パスワード入力 -->
        <div class="mt-3">
            <label for="password" class="form-label">パスワード</label>
            <input id="password" class="block mt-1 w-full form-control" type="password" name="password" required/>
        </div>

        <!-- パスワード（確認）入力 -->
        <div class="mt-3">
            <label for="password_confirmation" class="form-label">パスワード（確認用）</label>
            <input id="password_confirmation" class="block mt-1 w-full form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
        </div>

        <!-- 会員情報 -->
        <div class="mt-3 mb-4">
            <p>登録プラン</p>
            <input id="payment-1" type="radio" name="payment" value="1"/>
            <label for="payment-1" class="form-label">有料会員</label>
            <input id="payment-2" type="radio" name="payment" value="2" checked />
            <label for="payment-2" class="form-label">無料会員</label>
        </div>
        <div class="block my-4 d-flex align-items-center">
            <div>
                <a class="text-decoration-none text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">登録済みの方はこちら</a>
            </div>
            <div class="ms-4">
                <button type="submit" class="btn btn-outline-primary">新規登録</button>
            </div>
        </div>
    </form>
    </div>
</div>

@endsection
