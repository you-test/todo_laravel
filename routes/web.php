<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FolderController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function() {
    Route::get('/folders/{id}/tasks', [TaskController::class, 'index'])->name('tasks.index');
    //フォルダ作成ページを表示
    Route::get('/folders/create', [FolderController::class, 'showCreateForm'])->name('folders.create');
    //フォルダ作成処理を実行する
    Route::post('/folders/create', [FolderController::class, 'create']);
    //タスク作成ページを表示
    Route::get('/folders/{id}/tasks/create', [TaskController::class, 'showCreateForm'])->name('tasks.create');
    //タスク作成処理を実行する
    Route::post('/folders/{id}/tasks/create', [TaskController::class, 'create']);
    //タスク編集ページを表示する。
    Route::get('/folders/{id}/tasks/{task_id}/edit', [TaskController::class,  'showEditForm'])->name('tasks.edit');
    //タスク編集処理を実行する。
    Route::post('/folders/{id}/tasks/{task_id}/edit', [TaskController::class, 'edit']);
    //ホーム画面
    Route::get('/', [HomeController::class, 'index'])->name('home');
});


//認証機能
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*------------------------------------------------------------------------
Routeクラスのgetメソッド、postメソッド使用（RouteクラスにはHTTPメソッドに応じたクラスメソッドが用意されている

nameメソッドによるルートの命名はgetのみにしている
->名前を付けて呼び出せるのはURLだけなので、同じURLでHTTPメソッド違いのルートがいくつかある場合
はどれか一つに名前を付ければOK

ルートグループはいくつかのルートに対して一括で機能を追加したときに使用。
今回は認証ミドルウェアを複数のルートに一括して適用するために使用。

ミドルウェアはapp/Http/Kernel.phpというファイルに実際のクラスと名前の定義がある。
このミドルウェアはアクセスしたユーザーの認証状態をチェックして、ログインしていたらそのままコントローラーメソッド
（または次のミドルウェア）に処理を渡します。ログインしていなければログイン画面にリダイレクトさせます。
------------------------------------------------------------------------*/
