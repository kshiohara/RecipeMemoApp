@extends('layouts.app')

@section('content')

<div class="container pt-4" style="width: 60%">
  <h4 class="text-center mb-5">レシピ登録画面</h4>

  {{-- 無料会員が5個以上レシピを登録した際のメッセージ --}}
  @if(session('message'))
    <div class="text-danger fw-bold">
      {{ session('message')}}
    </div>
  @endif

  {{-- バリデーションエラーメッセージ --}}
  <div>
    @if ($errors->any())
    <ul>
      @foreach ($errors->all() as $error)
        <li class="text-danger fw-bold">{{ $error }}</li>
      @endforeach
    </ul>
    @endif
  </div>

  <div class="mb-5" style="background-color: #F9F9F9; padding: 20px 60px; border:1px solid #ddd; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
    <form id="recipe_form" method="post" action="{{ route('recipe.store') }}">
        @csrf

        <!-- レシピ名入力 -->

        <div class="mt-5">
          <label for="name" class="form-label">レシピ名</label>
          <input id="recipe_name" class="block mt-1 form-control" type="text" name="name" placeholder="レシピ名を入力してください" />
        </div>

        <!-- レシピURL入力 -->
        <div class="mt-3">
          <label for="link" class="form-label">レシピURL</label>
          <input id="link" class="block mt-1 w-full form-control" type="text" name="link" placeholder="URLを入力してください" />
        </div>

        <!-- 評価入力 -->
        <!-- 評価 -->
        <div class="mt-3">
          <label for="rating" class="form-label">評価</label>
          <div class="rate-form">
            {{-- @forを使用して★5個分のループを作成 --}}
            @for ($i = 1; $i <= 5; $i++)
            <label for="star{{ $i }}" class="fs-5" style="color: #c0c0c0;" onclick="setRating({{ $i }})">★</label>
            <input id="star{{ $i }}" type="radio" name="rating" value="{{ $i }}" class="d-none">
            @endfor
          </div>
        </div>

        <!-- 作成状況入力 -->
        <div class="mt-3">
          <label for="status" class="form-label">作成状況</label>
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
            <button type="button" id="add-btn" class="btn btn-secondary btn-sm mx-2">＋</button>
          </div>
          <ul id="ingredient-list" class="mt-3 ps-0 d-flex flex-wrap"></ul>
        </div>

        <div class="my-4 text-center">
          <button type="submit" class="btn btn-outline-primary mx-4">登録</button>
          <button type="button" class="btn btn-outline-secondary" onclick="location.href='{{ route('recipe.index') }}'">キャンセル</button>
        </div>

      </form>
    </div>
</div>



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
      liElement.setAttribute("class", "ingredient_container mb-2");
      liElement.setAttribute("style", "display:inline; border: 1px solid #b2cdde; border-radius: 3px; background-image: linear-gradient(180deg, #cae2f0 0, #c3d9e7); color: #545b67; padding: 2px 8px 0px; margin: 0 5px; list-style: none;");
      // spanElement.setAttribute("class", "ingredient_tag");
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


  // スターレーティング用
  function setRating(rating) {
    let selectedStar = document.getElementById(`star${rating}`);
    let prevStars = selectedStar.previousElementSibling;
    let nextStars = selectedStar.nextElementSibling;
    selectedStar.checked = true;

    if (selectedStar.style.color == 'rgb(255, 131, 0)') {
      selectedStar.style.color = '#c0c0c0';
      while (nextStars) {
        nextStars.style.color = '#c0c0c0';
        nextStars = nextStars.nextElementSibling;
      };
    } else {
      selectedStar.style.color = '#FF8300';
      while (prevStars) {
        prevStars.style.color = '#FF8300';
        prevStars = prevStars.previousElementSibling;
      };
    };
  };


</script>

@endsection
