@extends('layouts.app')

@section('content')

<main>

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

    <div class="container my-5 py-5" style="width: 50%">
        <h5>ログイン画面</h5>
        <form method="post" action="{{ route('login') }}">
            @csrf

            <!-- メールアドレス入力 -->
            <div class="mt-5 mb-4">
                <label for="email" class="form-label">メールアドレス</label>
                <input id="email" class="block mt-1 form-control" type="email" name="email" value="{{ old('email') }}" required autofocus/>
            </div>

            <!-- パスワード入力 -->
            <div>
                <label for="password" class="form-label">パスワード</label>
                <input id="password" class="block mt-1 w-full form-control" type="password" name="password" required autocomplete="current-password" />
            </div>

            <!-- ログイン保持 -->
            <div class="block mt-4 d-flex align-items-center">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-gray-600">ログイン保持</span>
                </label>
                <div class="ms-4">
                    <button type="submit" class="btn btn-primary btn-sm">ログイン</button>
                </div>
            </div>
            <!-- パスワード忘れた場合 -->
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="text-decoration-none text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        パスワードを忘れた場合はこちら
                    </a>
                @endif
            <!-- ログインボタン -->
            </div>
        </form>
    </div>


</main>
@endsection
