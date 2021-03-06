<?php

namespace App\Http\Controllers;

use App\Models\Folder; //チュートリアルサイトでは "use App\Folder;"
use App\Models\Task; //チュートリアルサイトでは "use App\Task;"
use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use function GuzzleHttp\Promise\task;

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

    public function create(int $id, CreateTask $request)
    {
        $current_folder = Folder::find($id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        //$current_folderに紐づくタスクを作成
        $current_folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }

    /**
     * GEt /folders/{id}/tasks/{task_id}/edit
     * 入力フォームの表示
     */
    public function showEditForm(int $id, int $task_id)
    {
        $task = Task::find($task_id);

        //画面が表示された時点でタスクの各項目の値がすでに入っている状態にする
        //input要素のvalueに値を入れるためにタスクを渡す
        return view('tasks/edit',[
            'task' => $task,
        ]);
    }

    public function edit(int $id, int $task_id, EditTask $request)
    {
        //1.リクエストされたIDでタスクデータを取得する。これが編集対象。
        $task = Task::find($task_id);

        //2.編集対象のタスクデータに入力値を詰めてsaveする。
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        //3.編集対象のタスクが属するタスク一覧画面へリダイレクトする。
        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
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
