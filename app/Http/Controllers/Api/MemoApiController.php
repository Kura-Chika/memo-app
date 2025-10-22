<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemoModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MemoApiController extends Controller
{
    /**
     * メモの新規登録処理
     * TypeScriptからfetchでPOSTされる
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveMemoAction(Request $request): JsonResponse
    {
        //============================
        //➀引数チェック(バリデーション)
        //============================
        $request->validate(['content' => 'required']);

        DB::beginTransaction(); //トランザクション開始
        try {
            //============================
            //➁メモの作成処理
            //============================
            $memo = MemoModel::create(['content' => $request->content]);

            //============================
            //➂コミット処理
            //============================
            DB::commit();

            //============================
            //➃正常レスポンス返却
            //============================
            return response()->json([
                'status_code' => 200,
                'message' => '登録成功',
                'memo' => $memo
            ], 200);

        } catch (\Exception $e) {

            //============================
            //➄ロールバック処理
            //============================
            DB::rollBack();

            //============================
            //➅エラーレスポンス返却
            //============================
            return response()->json([
                'status_code' => 400,
                'message' => '登録失敗: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * メモの削除処理
     * 
     * @param int $id メモのID
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMemoAction($id): JsonResponse
    {
        DB::beginTransaction(); //トランザクション開始
        try {
            //============================
            //➀対象メモの取得
            //============================
            $memo = MemoModel::find($id);

            if ($memo === false){
                return response()->json([
                    'status_code' => 404,
                    'message' => '該当のメモが見つかりません'
                ],404);
            }

            //============================
            //➁メモ削除処理
            //============================
            $memo->delete();

            //============================
            //➂コミット処理
            //============================
            DB::commit();

            //============================
            //➃正常レスポンス返却
            //============================
            return response()->json([
                'status_code' => 200,
                'message' => '削除成功',
                'id' => $id
            ], 200);

        } catch (\Exception $e) {

            //============================
            //➄ロールバック処理
            //============================
            DB::rollBack();
            
            //============================
            //➅エラーレスポンス返却
            //============================
            return response()->json([
                'status_code' => 400,
                'message' => '削除失敗: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * 既存メモの更新処理
     * @param \Illuminate\Http\Request $request
     * @param int $id メモのID
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMemoAction(Request $request, $id): JsonResponse
    {
        //============================
        //➀引数チェック(バリデーション)
        //============================
        $request->validate(['content' => 'required']);

        DB::beginTransaction(); //トランザクション開始
        try {

            //============================
            //➁対象メモの取得
            //============================
            $memo = MemoModel::find($id);
            if ($memo === false){
                return response()->json([
                    'status_code' => 404,
                    'message' => '該当のメモが見つかりません'
                ],404);
            }

            //============================
            //➂メモ内容の更新処理
            //============================
            $memo->content = $request->content;
            $memo->save();

            //============================
            //➃コミット処理
            //============================
            DB::commit();
 
            //============================
            //➄正常レスポンス返却
            //============================
            return response()->json([
                'status_code' => 200,
                'message' => '更新成功',
                'memo' => $memo
            ], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status_code' => 400,
                'message' => '更新失敗: ' . $e->getMessage()
            ], 400);
        }
    }
}