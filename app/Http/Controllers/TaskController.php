<?php

namespace App\Http\Controllers;

use App\Models\Folder; //チュートリアルサイトでは "use App\Folder;"
use App\Models\Task; //チュートリアルサイトでは "use App\Task;"
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(int $id)
    {
        // 全てのフォルダを取得する
        $folders = Folder::all();

        // 選ばれたフォルダを取得する
        // findメソッドはプライマリーキーのカラムを条件として1行分のデータを取得
        // 下記ではフォルダテーブルからIDカラム（プライマリーキー）が1である行のデータを検索して返す
        $current_folder = Folder::find($id);

        // 選ばれたフォルダに紐づくタスクを取得する
        // $tasks = Task::where('folder_id', $current_folder->id)->get();
        $tasks = $current_folder->tasks()->get();

        // 使用するテンプレート定義と渡す変数の定義
        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks,
        ]);
    }

    //フォームの表示
    public function showCreateForm(int $id)
    {
        return view('tasks/create', [
            'folder_id' => $id
        ]);
    }
}

/*------------------------------------------------------------------
 #クエリビルダ ・・・SQLを書かなくてもPHP風な記述でデータ操作を表現することができる
                    SQLは裏側で生成されてデータベースに発行される

 whereメソッド・・・データの取得条件。
    第一引数：カラム名、　第二引数：比較する値
    省略しない形：  Task::where('folder_id', '=', $current_folder->id)->get();

 getメソッドで構築されたSQLをデータベースに発行して結果を取得している
    ※get()を書かないと値を取得できない

 #showCreateForm
    ・テンプレートでform要素のaction属性としてタスク作成URL(/folders/{id}/tasks/create)
    をつくるためにフォルダのIDが必要なので、コントローラーメソッドの引数で受け取ってview関数
    でテンプレートに渡している。
--------------------------------------------------------------------*/
