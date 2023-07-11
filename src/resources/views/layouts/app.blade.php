<!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
      <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <meta name="csrf-token" content="{{ csrf_token() }}">

          <title>{{ config('app.name', 'Laravel') }}</title>

          <!-- Fonts -->
          <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
          <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

          <!-- Scripts -->
          <link rel="stylesheet" href="{{ asset('css/app.css') }}">
          <script src="{{ mix('js/recipe.js') }}" defer></script>
          {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
      </head>
      <body class="font-sans antialiased">
          <div class="vh-100" style="background: #eeeeee;">

              <!-- Page Heading -->
              <header class="bg-white shadow py-3">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 container">
                  <div class="row">
                    <div class="col-3"><a href="/" class="text-black text-decoration-none fs-2">Recipe Memo</a></div>
                    {{-- ユーザーがログインしている場合 --}}
                    @auth
                    {{-- レシピ検索機能 --}}
                    <div class="col-4 mt-1">
                      <form method="GET" action="{{ route('recipe.index') }}">
                        @csrf
                        <input type="search" class="form-control" placeholder="レシピを検索（レシピ、材料を入力）" name="search" value="@if (isset($search)) {{ $search }} @endif">
                      </form>
                    </div>
                    {{-- レシピ登録機能 --}}
                    <div class="col-2 mt-1">
                      <button type="button" class="btn btn-primary" onclick="location.href='{{ route('recipe.create') }}'">レシピ登録</button>
                    </div>

                    <div class="col-3 mt-1">
                      <ul class="list-unstyled list-group list-group-horizontal my-2">
                        <li class="list-unstyled mx-4"><a href='{{ route('user.index') }}' class="text-black text-decoration-none">マイページ</a></li>
                        <li class="list-unstyled">
                          <a href={{ route('logout') }} class="text-black text-decoration-none" onclick="event.preventDefault();document.getElementById('logout-form').submit();">ログアウト</a>
                          <form id='logout-form' action={{ route('logout')}} method="POST" style="display: none;">
                          @csrf
                          </form>
                        </li>
                      </ul>
                    </div>
                    {{-- ユーザーがログインしていない場合 --}}
                    @else
                    {{-- レシピ検索機能 --}}
                    <div class="col-6 mt-1">
                      <form method="GET" action="{{ route('recipe.index') }}">
                        @csrf
                        <input type="search" class="form-control" placeholder="レシピを検索（レシピ、材料を入力）" name="search" value="@if (isset($search)) {{ $search }} @endif">
                      </form>
                    </div>
                    <div class="col-3 mt-1">
                      <ul class="list-unstyled list-group list-group-horizontal my-2">
                        <li class="list-unstyled mx-4"><a href='{{ route('register')}}' class="text-black text-decoration-none fs-6">新規登録</a></li>
                        <li class="list-unstyled"><a href='{{ route('login')}}' class="text-black text-decoration-none fs-6">ログイン</a></li>
                      </ul>
                    </div>
                    @endauth
                  </div>
                </div>
              </header>

              <!-- Page Content -->
              <main class="py-5" style="background: #eeeeee;">
                @yield('content')
              </main>

          </div>
      </body>
  </html>
