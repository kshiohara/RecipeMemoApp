<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">トップページへ戻る</a>
                {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

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
</x-guest-layout>
