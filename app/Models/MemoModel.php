<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Consts\MemoConst;

class MemoModel extends Model
{
    protected $fillable = ['content'];
    protected $table = 'memos'; //Model名変更のため記述

    /**
     * 現在時刻を基準にした日時情報を日時種別によって返す
     * 
     * @param string $type 日時種別
     * @param string $timestamp 呼び元で生成したタイムスタンプ
     * @return string 日時(YYYY-MM-DD HH:mm:ss形式)
     */

    public static function getDateTimes($type, $timestamp = null){

        $now = $timestamp ? Carbon::parse($timestamp) : Carbon::now(); //呼び元から渡されたTimeStampを使用
        switch($type){
            case MemoConst::DATE_END_OF_THIS_MONTH: //今月末
                return $now->copy()->endOfMonth()->format('Y-m-d H:i:s'); 
            case MemoConst::DATE_TWO_HOURS_AGO: //現在時刻の2時間前
                return $now->copy()->subHours(2)->format('Y-m-d H:i:s'); 
            case MemoConst::DATE_END_OF_NEXT_MONTH: //来月末
                return $now->copy()->addMonthNoOverflow()->endOfMonth()->format('Y-m-d H:i:s');
            default: //上記以外が来た場合は現在日時
                return $now->format('Y-m-d H:i:s');
        }
    }
}