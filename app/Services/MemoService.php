<?php

namespace App\Services;

use App\Repositories\MemoRepository;
use Illuminate\Support\Facades\DB;

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
            return $memo;

        } catch (\Exception $e) {
            //============================
            //➂ロールバック処理
            //============================
            DB::rollBack();
            throw $e;
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
                return null;
            }
            
            //============================
            //➁メモ内容の更新処理
            //============================
            $this->memoRepository->update($memo, $validated);

            //============================
            //➂コミット処理
            //============================
            DB::commit();
            return $memo;

        } catch (\Exception $e) {

            //============================
            //➄ロールバック処理
            //============================
            DB::rollBack();
            throw $e;
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
                return false;
            }

            //============================
            //➁メモ削除処理
            //============================
            $this->memoRepository->delete($memo);

            //============================
            //➂コミット処理
            //============================
            DB::commit();
            return true;

        } catch (\Exception $e) {

            //============================
            //➄ロールバック処理
            //============================
            DB::rollBack();
            throw $e;
        }
    }
}