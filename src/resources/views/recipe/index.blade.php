@extends('layouts.app')

@section('content')

<main>

  <div class="container my-3 py-5">
    <h5 class="mb-4">レシピ一覧</h5>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      @foreach($recipes as $recipe)
      <div class="col mb-4">
        <div class="card" style="height: 300px;">
          <div class="card-body overflow-auto">

            <!-- レシピ名詳細 -->
            <p class="card-text">レシピ名：{{ $recipe['name'] }}</p>

            <!-- リンク詳細 -->
            {{-- <p class="card-text">URL：<a href="{{ $recipe['link'] }}">{{ $recipe['link'] }}</a></p> --}}
            <!-- リンク詳細 -->
            <p class="card-text d-flex align-items-center">URL：<a href="{{ $recipe['link'] }}" class="text-truncate d-inline-block" style="max-width: 100%" target="_blank">{{ $recipe['link'] }}</a></p>


            <!-- 評価詳細 -->
            @if ($recipe['rating'] == 1)
              <p class="card-text">評価：<span style="color: rgb(255, 131, 0)">★</span><span style="color: #c0c0c0">★★★★</span></p>
            @elseif ($recipe['rating'] == 2)
              <p class="card-text">評価：<span style="color: rgb(255, 131, 0)">★★</span><span style="color: #c0c0c0">★★★</span></p>
            @elseif ($recipe['rating'] == 3)
              <p class="card-text">評価：<span style="color: rgb(255, 131, 0)">★★★</span><span style="color: #c0c0c0">★★</span></p>
            @elseif ($recipe['rating'] == 4)
              <p class="card-text">評価：<span style="color: rgb(255, 131, 0)">★★★★</span><span style="color: #c0c0c0">★</span></p>
            @elseif ($recipe['rating'] == 5)
              <p class="card-text">評価：<span style="color: rgb(255, 131, 0)">★★★★★</span></p>
            @else
              <p class="card-text">評価：　未評価</p>
            @endif


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
            @if ($recipe['ingredients'])
            <p class="card-text d-flex flex-wrap">材料：
              {{-- <span class="d-flex flex-wrap"> --}}
                @foreach ($recipe['ingredients'] as $ingredient)
                <span style="display:inline; border: 1px solid #b2cdde; border-radius: 3px; background-image: linear-gradient(180deg, #cae2f0 0, #c3d9e7); color: #545b67; padding: 2px 6px 0px; margin: 0 8px 6px 0; list-style: none; font-size: 11px">{{ $ingredient }}</span>
                @endforeach
              {{-- </span> --}}
            </p>
            @else
            <p class="card-text">材料： 登録なし</p>
            @endif

            {{-- 編集、削除ボタン --}}
            {{-- userが存在、かつrecipeのuser_idとログインユーザーのidが一致する場合のみ処理 --}}
            @auth
              @if ($user->id == $recipe['user_id'])
              <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-outline-primary mx-2 btn-sm float-right" onclick="location.href='{{ route('recipe.edit', $recipe['id']) }}'">編集</button>
                <form method="post" action="{{ route('recipe.destroy', $recipe['id']) }}" class="d-inline-block">
                  @method('delete')
                  @csrf
                  <button type="submit" class="btn btn-outline-danger btn-sm float-right" onclick="return confirm('本当に削除しますか?')">削除</button>
                </form>
              </div>
              @endif
            @endauth
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

</main>

@endsection
