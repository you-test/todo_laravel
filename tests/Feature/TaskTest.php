<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Requests\CreateTask;
use Carbon\Carbon;

class TaskTest extends TestCase
{
   //テストケースごとにデータベースをリフレッシュしてマイグレーションを再実行する
   use RefreshDatabase;

    //各テストメソッドの実行前に呼ばれる
    public function setUp() :void
    {
        parent::setUp();

        //テストケース実行前にフォルダデータを作成する
        $this->seed('FoldersTableSeeder');
    }

    /**
     * 期限日が日付ではない場合はバリデーションエラー
     * @test
     */
    public function due_date_should_be_date()
    {
        $response = $this->post('/folders/1/tasks/create', [
            'title' => 'Sample task',
            'due_date' => 123, //不正なデータ（数値）
        ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日には日付を入力してください。',
        ]);
    }

    /**
     * 期限日が過去日付の場合はバリデーションエラー
     * @test
     */
    public function due_date_should_not_be_past()
    {
        $response = $this->post('/folders/1/tasks/create', [
            'title' => 'Sample task',
            'due_date' => Carbon::yesterday()->format('Y/m/d'),
        ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日には今日以降の日付を入力してください。',
        ]);
    }
}
