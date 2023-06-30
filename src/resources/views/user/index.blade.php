@extends('layouts.app')

@section('content')

<main>
  <div class="container my-5 py-5" style="width: 50%">

      <div class="h3">マイページ詳細</div>
      <!-- 氏名詳細 -->
      <div class="mt-5 mb-4">
        <p class="">氏名</p>
        <p id="name" class="">{{ $user->name }}</p>
      </div>

      <!-- フリガナ詳細 -->
      <div class="mb-4">
        <p class="">フリガナ</p>
        <p id="name" class="">{{ $user->kana }}</p>
      </div>

      <!-- メールアドレス詳細 -->
      <div class="mb-4">
        <p class="">メールアドレス</p>
        <p id="email" class="">{{ $user->email }}</p>
      </div>

      <!-- 会員情報詳細 -->
      <div class="mb-4">
        <p class="">登録プラン</p>
        @if ($user->payment === 1)
        <p id="payment" class="">有料会員</p>
        @else
        <p id="payment" class="">無料会員</p>
        @endif
      </div>

      <!-- 編集、削除ボタン -->
      <div class="mt-5 text-center">
        <div class="d-inline-block">
          <button type="button" class="btn btn-primary mx-3" onclick="location.href='{{ route('user.edit', $user) }}'">編集</button>
          <form method="post" action="{{ route('user.destroy', $user) }}" class="d-inline-block">
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-secondary" onclick="return confirm('本当に削除しますか?')">削除</button>
          </form>
        </div>
      </div>

  </div>
</main>
@endsection
