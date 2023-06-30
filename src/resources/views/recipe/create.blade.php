@extends('layouts.app')

@section('content')

<main>

  <div class="container my-5 py-5" style="width: 50%">
      <div class="h3">レシピ登録画面</div>
      <form method="post" action="{{ route('recipe.store') }}">
          @csrf

          <!-- レシピ名入力 -->
          <div class="mt-5">
              <label for="name" class="form-label">レシピ名</label>
              <input id="name" class="block mt-1 form-control" type="text" name="name" required />
          </div>

          <!-- レシピURL入力 -->
          <div class="mt-3">
              <label for="link" class="form-label">レシピURL</label>
              <input id="link" class="block mt-1 w-full form-control" type="text" name="link" required />
          </div>

          <!-- 評価入力 -->
          <div class="mt-3">
              <label for="rating" class="form-label">評価</label>
              {{-- スターで表現する --}}
              {{-- <input id="rating" class="block mt-1 w-full form-control" type="text" name="rating" /> --}}
              <div class="rate-form">
                <input id="star5" type="radio" name="rating" value="5">
                <label for="star5">★</label>
                <input id="star4" type="radio" name="rating" value="4">
                <label for="star4">★</label>
                <input id="star3" type="radio" name="rating" value="3">
                <label for="star3">★</label>
                <input id="star2" type="radio" name="rating" value="2">
                <label for="star2">★</label>
                <input id="star1" type="radio" name="rating" value="1">
                <label for="star1">★</label>
              </div>
          </div>

          <!-- 作成状況入力 -->
          <div class="mt-3">
              <label for="link" class="form-label">作成状況</label>
              {{-- プルダウンで選択制（1.作成済み、2.未作成） --}}
              {{-- <input id="link" class="block mt-1 w-full form-control" type="text" name="link" required /> --}}
              <select class="form-select" name="status" aria-label="Default select example">
                <option selected>作成状況を選択してください</option>
                <option value="1">作成済み</option>
                <option value="2">未作成</option>
              </select>
          </div>

          <!-- コメント入力 -->
          <div class="mt-3">
            <label for="comment" class="form-label">感想</label>
            <textarea name="comment" class="form-control" id="comment" rows="3"></textarea>
          </div>


          <!-- 材料入力(ingredientsテーブル) -->
          <div class="mt-3">
              <label for="name" class="form-label">材料</label>
              {{-- 複数の材料を登録できるようにする --}}
              <input id="name" class="block mt-1 w-full form-control" type="text" name="ingredients[]" required />
          </div>

          <div class="mt-5 text-center">
            <button type="submit" class="btn btn-primary mx-4">登録</button>
            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('recipe.index') }}'">キャンセル</button>
          </div>

      </form>
  </div>

</main>
@endsection
