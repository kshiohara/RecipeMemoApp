@extends('layouts.app')

@section('content')

<main>

  <div class="container my-5 py-5" style="width: 50%">
      <div class="h3">レシピ登録画面</div>
      <form id="recipe_form" method="post" action="{{ route('recipe.store') }}">
          @csrf

          <!-- レシピ名入力 -->
          <div class="mt-5">
              <label for="name" class="form-label">レシピ名</label>
              <input id="recipe_name" class="block mt-1 form-control" type="text" name="name" placeholder="レシピ名を入力してください" required />
          </div>

          <!-- レシピURL入力 -->
          <div class="mt-3">
              <label for="link" class="form-label">レシピURL</label>
              <input id="link" class="block mt-1 w-full form-control" type="text" name="link" placeholder="URLを入力してください" required />
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
              <select class="form-select" name="status" aria-label="Default select example">
                <option selected>作成状況を選択してください</option>
                <option value="1">作成済み</option>
                <option value="2">未作成</option>
              </select>
          </div>

          <!-- コメント入力 -->
          <div class="mt-3">
            <label for="comment" class="form-label">感想</label>
            <textarea name="comment" class="form-control" id="comment" rows="3" placeholder="レシピの感想を入力してください" ></textarea>
          </div>


          <!-- 材料入力(ingredientsテーブル) -->
          <div class="mt-3">
              <label for="name" class="form-label">材料</label>
              {{-- nameを配列にすることで、複数の材料を登録できるようにする --}}
              <div class="d-flex align-items-center">
                <input id="ingredient_name" class="block mt-1 form-control" type="text" name="ingredients[]" placeholder=材料名を入力してください（複数可） />
                <button type="button" id="add-btn" class="btn btn-warning btn-sm mx-2">＋</button>
              </div>
              <ul id="ingredient-list" class="mt-3 ps-0"></ul>
          </div>

          <div class="mt-5 text-center">
            <button type="submit" class="btn btn-primary mx-4">登録</button>
            <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('recipe.index') }}'">キャンセル</button>
          </div>

      </form>
  </div>

</main>


<script>
  // 材料追加ボタンを押した時
  document.getElementById('add-btn').addEventListener('click', function() {

    // 入力された材料を取得
    const ingredientNameInput = document.getElementById('ingredient_name');
    // trim関数で空白を削除
    const ingredientValue = ingredientNameInput.value.trim();

    // 材料表示エリアに新しい要素を追加
    if (ingredientValue !== ''){
      const ingredientList = document.getElementById('ingredient-list');

      // 新しい要素を作成
      const liElement = document.createElement("li");
      const spanElement = document.createElement('span');
      const iElement = document.createElement("i");

      // クラスを指定
      liElement.setAttribute("class", "ingredient_container");
      liElement.setAttribute("style", "display:inline; border: 1px solid #b2cdde; border-radius: 3px; background-image: linear-gradient(180deg, #cae2f0 0, #c3d9e7); color: #545b67; padding: 2px 8px 0px; margin: 0 5px; list-style: none;");
      spanElement.setAttribute("class", "ingredient_tag");
      iElement.setAttribute("class", "far fa-times-circle");
      iElement.setAttribute("style", "margin-left: 4px");

      // 入力した値をspan要素に挿入
      spanElement.textContent = ingredientValue;

      // input(hidden)を作成してフォームに追加
      const hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'ingredients[]');
      hiddenInput.setAttribute('value', ingredientValue);

      // 要素をappendChildで組み合わせる 左：親、右：子
      liElement.appendChild(hiddenInput);
      liElement.appendChild(spanElement);
      liElement.appendChild(iElement);
      ingredientList.appendChild(liElement);


      // fa-times-circleアイコンをクリックした時に材料リストを削除する
      iElement.addEventListener('click', function() {
        liElement.remove();
      });

      // 入力フォームをクリア
      ingredientNameInput.value = '';
      }
  });

</script>

@endsection
