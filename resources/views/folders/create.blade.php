<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=devece-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="id=edge">
    <title>ToDo App</title>
    {{-- 読み込むcssにはassetを使う --}}
    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
</head>
<body>
    <header>
        <nav class="my-navbar">
            <a href="/" class="my-navbar-brand">ToDo App</a>
        </nav>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col col-md-offset-3 col-mi-6">
                    <nav class="panel panel-default">
                        <div class="panel-heading">ファルダを追加する</div>
                        <div class="panel-body">
                            {{-- エラーメッセージ --}}
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('folders.create') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="title">フォルダ名</label>
                                    <input type="text" class="form-controll" name="title" id="title" value="{{ old('title') }}">
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">送信</button>
                                </div>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

{{----------------------------------------------------------------------------------------------------
@csrf->「<input type="hidden" name="_token" value="BlpamKIhwFyLHmMLd2EJF9FrMImfSCdd200yi5ws">」
Laravelでは全てのPOSTリクエストに対してCSRFトークンが要求されるため、@csrfを書き忘れるとリクエスト
送信時にエラーとなってしまう。

#バリデーションでのエラーメッセージ表示
    ・ルール違反があったときには自動的に入力画面にリダイレクトされる
    ・違反内容は$errors変数につめてテンプレートに渡される。
    ・@if($errors->any())でルール違反があったか確認
    ・@foreach($errors->all() as $message)でエラーを列挙

#フォームのvalueに指定したold関数
    ・入力値はセッションに一時的に保存される
    ・old関数はそのセッション値を取得する。
    ・引数は取得したい入力欄のname属性
  ----------------------------------------------------------------------------------------------------}}
