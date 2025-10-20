<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $dates = MemoModel::getDateTimes(); //日時情報をモデルから取得
        return view('memo', compact('memos','dates')); //memosとdatesのデータをBladeに渡す
    }

    /**
     * 新しいメモの保存
     */
    public function store(Request $request){
        $request->validate(['content' => 'required']); //メモ入力フォームが空でないかのチェック
        MemoModel::create(['content' => $request->content]); //新しいメモを追加
        return redirect()->back(); //登録後元のページに戻る
    }

    /**
     * メモの削除
     * 
     * @param int $id メモのid
     */
    public function destroy($id){
        $memo = MemoModel::find($id); //idが一致するメモを取得
        if ($memo){
            $memo->delete(); //idが一致するメモを削除
        }
        return redirect()->back(); //登録後元のページに戻る
    }

}