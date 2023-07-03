@extends('layouts.app')

@section('content')

<main>

  <div class="container my-5 py-5" style="width: 50%">

    <div class="h3">レシピ一覧</div>
    @foreach($recipes as $recipe)
    <div class="recipe-container">
      <!-- レシピ名詳細 -->
      <div class="mt-5 mb-4">
        <p class="">レシピ名</p>
        <span id="name" class="">{{ $recipe['name'] }}</span>
      </div>

      <!-- リンク詳細 -->
      <div class="mb-4">
        <p class="">リンク</p>
        <a href="{{ $recipe['link'] }}" target="_blank" id="link" class="">{{ $recipe['link'] }}</a>
      </div>

      <!-- 評価詳細 -->
      <div class="mb-4">
        <p class="">評価</p>
        {{-- if文作成 --}}
        <p id="rating" class="">{{ $recipe['rating'] }}</p>
      </div>

      <!-- 作成状況詳細 -->
      <div class="mb-4">
        <p class="">作成状況</p>
        @if($recipe['status'] === 1)
        <p id="status" class="">作成済み</p>
        @else
        <p id="status" class="">未作成</p>
        @endif
      </div>

      <!-- 感想詳細 -->
      <div class="mb-4">
        <p class="">感想</p>
        <p id="comment" class="">{{ $recipe['comment'] }}</p>
      </div>

      <!-- 材料詳細 -->
      <div class="mb-4">
        <p class="">材料</p>
        <span id="ingredient" class="">
          @foreach($recipe['ingredients'] as $ingredient)
          {{ $ingredient }}
          @endforeach
        </span>
      </div>

      {{-- 編集、削除ボタン --}}
      <div class="text-right">
        <button type="button" class="btn btn-primary mx-2 btn-sm float-right" onclick="location.href='{{ route('recipe.edit', $recipe['id']) }}'">編集</button>
        <form method="post" action="{{ route('recipe.destroy', $recipe['id']) }}" class="d-inline-block">
          @method('delete')
          @csrf
          <button type="submit" class="btn btn-secondary btn-sm float-right" onclick="return confirm('本当に削除しますか?')">削除</button>
        </form>
      </div>

    </div>
    @endforeach
  </div>
</main>
@endsection
