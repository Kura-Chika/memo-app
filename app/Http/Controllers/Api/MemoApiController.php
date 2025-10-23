<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemoRequest;
use App\Services\MemoService;
use Illuminate\Http\JsonResponse;

class MemoApiController extends Controller
{
    protected $memoService;

    public function __construct(MemoService $memoService)
    {
        $this->memoService = $memoService;
    }
    
    /**
     * メモの新規登録処理
     * TypeScriptからfetchでPOSTされる
     * 
     * @param \App\Http\Requests\MemoRequest $request バリデーション済み
     */
    public function saveMemoAction(MemoRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $memo =  $this->memoService->saveMemo($validated);
        
            //============================
            //➀正常レスポンス返却
            //============================
            return response()->json([
                'status_code' => 200,
                'message' => '登録成功',
                'memo' => $memo
            ], 200);

        } catch (\Exception $e) {

            //============================
            //➁エラーレスポンス返却
            //============================
            return response()->json([
                'status_code' => 400,
                'message' => '登録失敗: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * 既存メモの更新処理
     * 
     * @param \App\Http\Requests\MemoRequest $request バリデーション済み
     * @param int $id メモのID
     */
    public function updateMemoAction(MemoRequest $request, $id): JsonResponse
    {
        try {
            $validated = $request->validated();
            $memo = $this->memoService->updateMemo($id, $validated); 

            if ($memo === null) {
                return response()->json([
                    'status_code' => 404,
                    'message' => '該当のメモが見つかりません'
                ],404);
            }

            //============================
            //➀正常レスポンス返却
            //============================
            return response()->json([
                'status_code' => 200,
                'message' => '更新成功',
                'memo' => $memo
            ], 200);

        } catch (\Exception $e) {
            //============================
            //➁エラーレスポンス返却
            //============================
            return response()->json([
                'status_code' => 400,
                'message' => '更新失敗: ' . $e->getMessage()
            ], 400);

        }
    }
    /**
     * メモの削除処理
     * 
     * @param int $id メモのID
     */
    public function deleteMemoAction($id): JsonResponse
    {
        try {
            $memo = $this->memoService->deleteMemo($id);

            if ($memo === null) {
                return response()->json([
                    'status_code' => 404,
                    'message' => '該当のメモが見つかりません'
                ],404);
            }
            //============================
            //➀正常レスポンス返却
            //============================
            return response()->json([
                'status_code' => 200,
                'message' => '削除成功',
                'id' => $id
            ], 200);

        } catch (\Exception $e) {

            //============================
            //➁エラーレスポンス返却
            //============================
            return response()->json([
                'status_code' => 400,
                'message' => '削除失敗: ' . $e->getMessage()
            ], 400);
        }
    }
}