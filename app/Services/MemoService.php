<?php

namespace App\Services;

use App\Repositories\MemoRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class MemoService
{
    protected $memoRepository;

    public function __construct(MemoRepository $memoRepository)
    {
        $this->memoRepository = $memoRepository;
    }

    /**
     * メモ新規作成
     */
    public function saveMemo(array $validated)
    {
        DB::beginTransaction(); //トランザクション開始
        try {
            //============================
            //➀メモの作成処理
            //============================
            $memo = $this->memoRepository->save($validated);

            //============================
            //➁コミット処理
            //============================
            DB::commit();

            //============================
            //➂正常レスポンス返却
            //============================
            return response()->json([
                'status_code' => 200,
                'message' => '登録成功',
                'memo' => $memo
            ], 200);

        } catch (\Exception $e) {

            //============================
            //➃ロールバック処理
            //============================
            DB::rollBack();

            //============================
            //➄エラーレスポンス返却
            //============================
            return response()->json([
                'status_code' => 400,
                'message' => '登録失敗: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * メモ更新
     */
    public function updateMemo(int $id, array $validated)
    {
        DB::beginTransaction(); //トランザクション開始
        try {
            //============================
            //➀対象メモの取得
            //============================
            $memo = $this->memoRepository->findById($id);
            if ($memo === null){
                return response()->json([
                    'status_code' => 404,
                    'message' => '該当のメモが見つかりません'
                ],404);
            }
            
            //============================
            //➁メモ内容の更新処理
            //============================
            $this->memoRepository->update($memo, $validated);

            //============================
            //➂コミット処理
            //============================
            DB::commit();
 
            //============================
            //➃正常レスポンス返却
            //============================
            return response()->json([
                'status_code' => 200,
                'message' => '更新成功',
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
                'message' => '更新失敗: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * メモ削除
     */
    public function deleteMemo(int $id)
    {
        DB::beginTransaction(); //トランザクション開始
        try {
            //============================
            //➀対象メモの取得
            //============================
            $memo = $this->memoRepository->findById($id);

            if ($memo === null){
                return response()->json([
                    'status_code' => 404,
                    'message' => '該当のメモが見つかりません'
                ],404);
            }

            //============================
            //➁メモ削除処理
            //============================
            $this->memoRepository->delete($memo);

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
}