@extends('layouts.app')

@section('content')

<div class="container" style="width: 50%">
  <h4 class="text-center mb-4">マイページ詳細画面</h4>

  <div class="" style="background-color:#F9F9F9; border:1px solid #c3c3c3; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); padding: 20px 40px;">
    <!-- 氏名詳細 -->
    <div class="mt-4 mb-4">
      <p class="">氏名：{{ $user->name }}</p>
    </div>

    <!-- フリガナ詳細 -->
    <div class="mb-4">
      <p class="">フリガナ：{{ $user->kana }}</p>
    </div>

    <!-- メールアドレス詳細 -->
    <div class="mb-4">
      <p class="">メールアドレス：{{ $user->email }}</p>
    </div>

    <!-- 会員情報詳細 -->
    <div class="mb-4">
      @if ($user->payment === 1)
      <p class="">登録プラン：有料会員</p>
      @else
      <p class="">登録プラン：無料会員</p>
      @endif
    </div>

    <!-- 編集、削除ボタン -->
    <div class="mt-3 mb-4 text-center">
      <div class="d-inline-block">
        <button type="button" class="btn btn-outline-primary mx-3" onclick="location.href='{{ route('user.edit', $user) }}'">編集</button>
        <form method="post" action="{{ route('user.destroy', $user) }}" class="d-inline-block">
          @method('delete')
          @csrf
          <button type="submit" class="btn btn-outline-danger" onclick="return confirm('本当に削除しますか?')">削除</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
