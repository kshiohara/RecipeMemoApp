@extends('layouts.app')

@section('content')


<div class="container pt-4" style="width: 60%;">
  <h4 class="text-center mb-5">レシピ編集画面</h4>

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
    {{-- 第一引数：user.updateへのルーティング、第二引数：ルートに渡すパラメーター --}}
    <form method="post" action="{{ route('recipe.update', $recipe) }}">
      {{-- @methodで送信形式をpatchに指定 --}}
      @method('patch')
      @csrf

      <!-- レシピ名 -->
      <div class="mt-5">
        <label for="name" class="form-label">レシピ名</label>
        <input id="name" class="block mt-1 form-control" type="text" name="name" value="{{ old('name', $recipe->name) }}" autofocus/>
      </div>

      <!-- リンク -->
      <div class="mt-3">
        <label for="link" class="form-label">レシピURL</label>
        <input id="link" class="block mt-1 form-control" type="text" name="link" value="{{ old('link', $recipe->link) }}" autofocus/>
      </div>

        <!-- 評価 -->
      <div class="mt-3">
        <label for="rating" class="form-label">評価</label>
        <div class="rate-form">
        {{-- @forを使用して★5個分のループを作成 --}}
          @for ($i = 1; $i <= 5; $i++)
            <label for="star{{ $i }}" class="fs-5" style="color: {{ $i <= $recipe->rating ? 'rgb(255, 131, 0)' : '#c0c0c0' }};" onclick="setRating({{ $i }})">★</label>
            <input id="star{{ $i }}" type="radio" name="rating" value="{{ $i }}" class="d-none" {{ $i == $recipe->rating ? 'checked' : '' }}>
          @endfor
        </div>
      </div>

      <!-- 作成状況 -->
      <div class="mt-3">
        <label for="status" class="form-label">作成状況</label>
        @if($recipe->status === 1)
        <select class="form-select" name="status" aria-label="Default select example">
          <option>作成状況を選択してください</option>
          <option value="1" selected>作成済み</option>
          <option value="2">未作成</option>
        </select>
        @else
        <select class="form-select" name="status" aria-label="Default select example">
          <option>作成状況を選択してください</option>
          <option value="1">作成済み</option>
          <option value="2" selected>未作成</option>
        </select>
        @endif
      </div>

      <!-- 感想 -->
      <div class="mt-3">
        <label for="comment" class="form-label">感想</label>
        <textarea id="comment" class="block mt-1 form-control" type="text" name="comment" autofocus >{{ old('comment', $recipe->comment) }}</textarea>
      </div>

      <!-- 材料 -->
      <div class="mt-3">
        <label for="name" class="form-label">材料</label>
        <div class="d-flex align-items-center">
          <input id="ingredient_name" class="block mt-1 form-control" type="text" name="ingredients[]" placeholder=材料名を入力してください（複数可） />
          <button type="button" id="add-btn" class="btn btn-secondary btn-sm mx-2">＋</button>
        </div>
        <ul id="ingredient-list" class="mt-3 ps-0 d-flex flex-wrap">
          @foreach($recipe['ingredients'] as $ingredient)
          <li class="ingredient_container mb-2" style="display:inline; border: 1px solid #b2cdde; border-radius: 3px; background-image: linear-gradient(180deg, #cae2f0 0, #c3d9e7); color: #545b67; padding: 2px 8px 0px; margin: 0 5px; list-style: none;">
            <input type="hidden" name="ingredients[]" value="{{ $ingredient['name'] }}">
            <span class="">{{ $ingredient['name'] }}</span>
            <i class="far fa-times-circle remove_btn" style="margin-left: 4px"></i>
          </li>
          @endforeach
        </ul>

      <!-- 登録、キャンセルボタン -->
      <div class="text-center my-4">
          <button type="submit" class="btn btn-outline-primary mx-4">登録</button>
          <button type="button" class="btn btn-outline-secondary" onclick="location.href='{{ route('recipe.index') }}'">キャンセル</button>
        </div>
      </div>
    </form>
  </div>
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

  // 材料の削除アイコンを押した時
  document.querySelectorAll('.remove_btn').forEach(function(icon) {
    icon.addEventListener('click', function (){
      // 親要素のliを取得して、削除
      const parentElement = this.parentElement;
      parentElement.remove();
    })
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
