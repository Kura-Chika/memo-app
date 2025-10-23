<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemoRequest;
use App\Services\MemoService;

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
    public function saveMemoAction(MemoRequest $request)
    {
        $validated = $request->validated();
        return $this->memoService->saveMemo($validated);
    }

    /**
     * 既存メモの更新処理
     * 
     * @param \App\Http\Requests\MemoRequest $request バリデーション済み
     * @param int $id メモのID
     */
    public function updateMemoAction(MemoRequest $request, $id)
    {
        $validated = $request->validated();
        return $this->memoService->updateMemo($id, $validated); 
    }
    /**
     * メモの削除処理
     * 
     * @param int $id メモのID
     */
    public function deleteMemoAction($id)
    {
        return $this->memoService->deleteMemo($id);
    }
}