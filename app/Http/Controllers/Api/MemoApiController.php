<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemoModel;
use Illuminate\Http\JsonResponse;

class MemoApiController extends Controller
{
    /**
     * 新しいメモの保存
     * TypeScriptからfetchでPOSTされる
     */
    public function saveMemoAction(Request $request): JsonResponse{
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
    public function deleteMemoAction($id): JsonResponse{
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