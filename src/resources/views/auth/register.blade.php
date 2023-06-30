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
        <div class="h3">新規登録画面</div>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- 氏名入力 -->
            <div class="mt-5">
                <label for="name" class="form-label">氏名</label>
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
            <div class="mt-4">
                <input id="payment-1" type="radio" name="payment" value="1" />
                <label for="payment-1" class="form-label">有料会員</label>
                <input id="payment-2" type="radio" name="payment" value="2" />
                <label for="payment-2" class="form-label">無料会員</label>
            </div>
            <div class="block mt-4 d-flex align-items-center">
                <div>
                    <a class="text-decoration-none text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">登録済みの方はこちら</a>
                </div>
                <div class="ms-4">
                    <button type="submit" class="btn btn-primary btn-sm">新規登録</button>
                </div>
            </div>
        </form>
    </div>

</main>
@endsection

{{--



        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('氏名')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('氏名')" required autofocus />
            </div>

            <!-- kana -->
            <div>
                <x-label for="kana" :value="__('フリガナ')" />

                <x-input id="kana" class="block mt-1 w-full" type="text" name="kana" :value="old('フリガナ')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('メールアドレス')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('メールアドレス')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('パスワード')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('パスワード（確認）')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <!-- Payment -->
            <div class="mt-4">
                <x-input id="payment-1" type="radio" name="payment" value="1" />
                <x-label for="payment-1" :value="__('有料会員')" />
                <x-input id="payment-2" type="radio" name="payment" value="2" />
                <x-label for="payment-2" :value="__('無料会員')" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('登録済みの方はこちら') }}
                </a>

                <x-button class="ml-4">
                    {{ __('新規登録') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}
