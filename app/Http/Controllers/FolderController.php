<?php

namespace App\Http\Controllers;

use App\Models\Folder;  // チュートリアルサイトの解説ではuse App\Folder
use Illuminate\Http\Request;

class FolderController extends Controller
{
    // フォーム画面を返す
    public function showCreateForm()
    {
        return view('folders/create');
    }

    // フォルダ作成のルート
    public function create(Request $request) //Requestクラスのインスタンスを受け入れる記述
    {
        // フォルダモデルのインスタンスを作成する
        $folder = new Folder();

        // タイトルに入力値を代入する
        $folder->title = $request->title;

        // インスタンスの状態をデータベースに書き込む
        $folder->save();

        // フォルダを作成できたら、そのフォルダに対応するタスク一覧画面に遷移
        return redirect()->route('tasks,index', [
            'id' => $folder->id
        ]);
    }
}

/*----------------------------------------------------------------------
何を基準にコントローラーを分けるかの決まりは特にない
今回は処理の主体ごとにコントローラーを作成
    フォルダの作成->フォルダコントローラー
    タスクの編集　->タスクコントローラー

createメソッドの引数にRequestクラスのインスタンスを渡すことで、
コントローラーメソッドが呼び出されるときにLaravelがリクエストの情報を
Requestクラスのインスタンス$requestにつめて引数として渡してくれる
->Requestクラスのインスタンスにはリクエストヘッダや送信元IPなど色々な情報が含まれる
->その中にフォームの入力値も入っている($request->title)
->リクエスト中の入力値は上記の様にプロパティとして取得できる

<データベースへの書き込み手順>
1．モデルクラスのインスタンスを作成する。
2．インスタンスのプロパティに値を代入する。
3．saveメソッドを呼び出す。

これにより、モデルクラスが表すテーブルに対してINSERTが実行される。
モデルクラスのプロパティに代入した値が各カラムに書き込まれる。

<リダイレクト処理>
・画面を作る必要ないのでviewメソッドは呼ばない
・代わりにredirectメソッドを呼ぶ
・リダイレクト先を指定するために、routeメソッドを呼び出している
-----------------------------------------------------------------------*/
