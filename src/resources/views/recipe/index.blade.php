@extends('layouts.app')

@section('content')

<main>

  <div class="container my-3 py-5">
    <h3>レシピ一覧</h3>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      @foreach($recipes as $recipe)
      <div class="col mb-4">
        <div class="card">
          <div class="card-body">

            <!-- レシピ名詳細 -->
            <h5 class="card-text">レシピ名：{{ $recipe['name'] }}</h5>

            <!-- リンク詳細 -->
            <p class="card-text">URL：<a href="{{ $recipe['link'] }}">{{ $recipe['link'] }}</a></p>

            <!-- 評価詳細 -->
            <p class="card-text">評価：{{ $recipe['rating'] }}</p>

            <!-- 作成状況詳細 -->
            <p class="card-text">作成状況：
              @if($recipe['status'] === 1)
              作成済み
              @else
              未作成
              @endif
            </p>

            <!-- 感想詳細 -->
            <p class="card-text">感想：{{ $recipe['comment'] }}</p>

            <!-- 材料詳細 -->
            <p class="card-text">材料：<span class="">{{ implode('　', $recipe['ingredients']) }}</span></p>

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
        </div>
      </div>
      @endforeach
    </div>
  </div>

</main>

@endsection
