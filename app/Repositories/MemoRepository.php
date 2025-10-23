<?php

namespace App\Repositories;

use App\Models\MemoModel;

class MemoRepository
{
    /**
     * メモ新規作成
     * 
     * @param array $data
     * @return \App\Models\MemoModel
     */
    public function save(array $data)
    {
        return MemoModel::create($data);
    }

    /**
     * メモのIDを取得
     * 
     * @param int $id
     * @return \App\Models\MemoModel
     */
    public function findById(int $id): ?MemoModel
    {
        return MemoModel::find($id);
    }

    /**
     * メモ更新
     * 
     * @param \App\Models\MemoModel $memo
     * @param array $data
     */
    public function update(MemoModel $memo, array $data)
    {
        $memo->update($data);
    }

    /**
     * メモ削除
     * 
     * @param \App\Models\MemoModel $memo
     */
    public function delete(MemoModel $memo)
    {
        $memo->delete();
    }
}