<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemoModel;
use Illuminate\Http\JsonResponse;

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

    /**
     * 新しいメモの保存
     * TypeScriptからfetchでPOSTされる
     */
    public function store(Request $request): JsonResponse{
        $request->validate(['content' => 'required']); //メモ入力フォームが空でないかのチェック
        $memo = MemoModel::create(['content' => $request->content]); //新しいメモを追加
        
        return response()->json([
            'message' => '登録成功',
            'memo' => $memo
        ]);
    }

    /**
     * メモの削除
     * 
     * @param int $id メモのid
     */
    public function destroy($id): JsonResponse{
        $memo = MemoModel::find($id); //idが一致するメモを取得
        if (!$memo){
            return response()->json([
                'message' => '該当のメモが見つかりません'
            ],404);
        }

        $memo->delete(); //idが一致するメモを削除
        return response()->json([
            'message' => '削除成功',
            'id' => $id
        ]);
    }
}