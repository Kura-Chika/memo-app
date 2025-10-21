<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MemoModel;

class MemoController extends Controller
{
    /**
     * メモ一覧画面の表示
     * 
     * メモデータを作成日時の降順で取得
     * 日時情報をMemoModelから取得
     */
    public function index(){
        $memos = MemoModel::orderBy('created_at', 'desc')->get(); //メモ一覧取得
        $dates = MemoModel::getDateTimes(3); //対象の日時情報をMemoModelから取得
        return view('memo', compact('memos','dates')); //memosとdateのデータをBladeに渡す
    }
}