<?php

namespace App\Http\Controllers\Web;

use App\Consts\MemoConst;
use App\Http\Controllers\Controller;
use App\Models\MemoModel;
use Carbon\Carbon;

class MemoController extends Controller
{
    /**
     * メモ一覧画面の表示
     * 
     * @return \Illuminate\View\View
     * 
     * 現在日時を基準にTimeStamp生成
     * MemoModelから日時種別情報を取得
     * メモ一覧を取得しBlade(memo.blade.php)へ渡す
     */
    public function index()
    {
        //============================
        //➀現在日時の生成
        //============================
        $timestamp = Carbon::now()->format('Y-m-d H:i:s');

        //==========================================
        //➁MemoModelにTimeStampを渡して日時種別の取得
        //==========================================
        $dates = MemoModel::getDateTimes(MemoConst::DATE_END_OF_NEXT_MONTH, $timestamp);

        //============================
        //➂メモ一覧の取得
        //============================
        $memos = MemoModel::orderBy('created_at', 'desc')->get();

        //============================
        //➃Bladeへデータを渡す
        //============================
        return view('memo', compact('memos','dates'));
    }
}