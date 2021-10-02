<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFolder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    //リクエスト内容に基づいた権限チェックのために使用するもの
    //今回はこの機能を使用しないのでtrueを返す（＝リクエストを受け付ける）
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //入力欄ごとにチェックするルールを定義する
        return [
            'title' => 'required|max:20', //複数ルールは|で区切る
        ];
    }

    //エラーメッセージのtitle部分が定義できる
    public function attributes()
    {
        return [
            'title' => 'フォルダ名',
        ];
    }
}


/*-----------------------------------------------------------------------
#ruleメソッド
    ・配列のキーが入力欄　->HTML側でのinput要素のname属性に対応
    ・値の部分でルールを指定。必須入力を意味するrequiredを指定している。
    ・デフォルトでたくさんのルールがある　->マニュアル参照
------------------------------------------------------------------------*/
