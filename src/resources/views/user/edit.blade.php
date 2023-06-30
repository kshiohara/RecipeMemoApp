
@extends('layouts.app')

@section('content')

@error('email')
<p>{{$message}}</p>
@enderror

<main>
  <div class="container my-5 py-5" style="width: 50%">
      <div class="h3">マイページ編集画面</div>

      {{-- 第一引数：user.updateへのルーティング、第二引数：ルートに渡すパラメーター --}}
      <form method="post" action="{{ route('user.update', $user) }}">
        {{-- @methodで送信形式をpatchに指定 --}}
        @method('patch')
        @csrf

        <!-- 氏名入力 -->
        <div class="mt-5">
          <label for="name" class="form-label">氏名</label>
          <input id="name" class="block mt-1 form-control" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus/>
        </div>
        <!-- フリガナ入力 -->
        <div class="mt-3">
          <label for="kana" class="form-label">フリガナ</label>
          <input id="kana" class="block mt-1 form-control" type="text" name="kana" value="{{ old('kana', $user->kana) }}" required autofocus/>
        </div>
        <!-- メールアドレス入力 -->
        <div class="mt-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input id="email" class="block mt-1 form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required autofocus/>
        </div>
        <!-- 登録プラン入力 -->
        <div class="mt-3 mb-4">
          <p>登録プラン</p>
          @if ($user->payment === 1)
            <input id="payment-1" type="radio" name="payment" value="1" checked />
            <label for="payment-1" class="form-label">有料会員</label>
            <input id="payment-2" type="radio" name="payment" value="2" />
            <label for="payment-2" class="form-label">有料会員</label>
          @else
            <input id="payment-1" type="radio" name="payment" value="1" />
            <label for="payment-1" class="form-label">有料会員</label>
            <input id="payment-2" type="radio" name="payment" value="2" checked />
            <label for="payment-2" class="form-label">有料会員</label>
          @endif
        </div>
        <!-- 登録、キャンセルボタン -->
        <div class="text-center">
          <button type="submit" class="btn btn-primary">登録</button>
          <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('user.index') }}'">キャンセル</button>
        </div>
      </form>
  </div>
</main>
@endsection
