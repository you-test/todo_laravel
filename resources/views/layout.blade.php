<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToDo App</title>
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <header>
        <nav class="my-navbar">
            <a href="/" class="my-navbar-brand">ToDo App</a>
            <div class="my-navbar-control">
                @if(Auth::check())
                    <span class="my-navbar-item">ようこそ、{{ Auth::user()->name }}さん</span>
                    |
                    <a href="#" id="logout" class="my-navbar-item">ログアウト</a>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="my-navbar-item">ログイン</a>
                    |
                    <a href="{{ route('register') }}" class="my-navbar-item">会員登録</a>
                @endif
            </div>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    @if(Auth::check())
        <script>
            document.getElementById('logout').addEventListener('click', function(event) {
                event.preventDefault();
                document.getElementById('logout-form').submit();
            });
        </script>
    @endif
    @yield('scripts')
</body>
</html>


{{--------------------------------------------------------------
    ページごとに変わる部分は@yeildで穴埋め

    Auth::check()  Authクラスのcheckメソッドでログインしているか確認できる　（返値: true/false)
    @if(Auth::check()) ~ @else ~ @endif でログインした場合の要素とログインしていない場合の要素
    を出し分けている。

    Auth::user()　ログイン中のユーザーを取得できる、返値：ログインユーザーの情報が入ったUserモデルのインスタンス

----------------------------------------------------------------}}
