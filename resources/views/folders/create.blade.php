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
                            <form action="{{ route('folders.create') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="title">フォルダ名</label>
                                    <input type="text" class="form-controll" name="title" id="title">
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

{{---------------------------------------------
@csrf->「<input type="hidden" name="_token" value="BlpamKIhwFyLHmMLd2EJF9FrMImfSCdd200yi5ws">」
Laravelでは全てのPOSTリクエストに対してCSRFトークンが要求されるため、@csrfを書き忘れるとリクエスト
送信時にエラーとなってしまう。
  --------------------------------------------}}
