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
     * メモデータを作成日時の降順で取得
     * MemoModelから日時種別情報を取得
     * Blade(memo.blade.php)へデータを渡す
     */
    public function index()
    {
        //============================
        //➀現在日時の生成
        //============================
        $Timestamp = Carbon::now()->format('Y-m-d H:i:s');

        //==========================================
        //➁MemoModelにTimeStampを渡して日時情報の取得
        //==========================================
        $dates = MemoModel::getDateTimes(MemoConst::DATE_END_OF_NEXT_MONTH, $Timestamp);

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