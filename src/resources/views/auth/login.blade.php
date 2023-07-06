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

    <div class="container" style="width: 60%">
        <h4 class="text-center mt-3 mb-5">ログイン画面</h4>
        <div class="" style="background-color:#F9F9F9; border:1px solid #c3c3c3; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); padding: 10px 40px;">
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
            <div class="block mt-4 mb-5 d-flex align-items-center">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-gray-600">ログイン保持</span>
                </label>
                <div class="ms-4">
                    <button type="submit" class="btn btn-outline-primary btn-sm">ログイン</button>
                </div>
            </div>
        </form>
        </div>
    </div>


</main>
@endsection
