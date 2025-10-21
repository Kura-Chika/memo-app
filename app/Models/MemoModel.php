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
     * 現在時刻を基準にした日時情報を種別によって返す
     * 
     * @param int $type 1=今月末の日付, 2=現在時刻の2時間前, 3=来月末の日付
     */

    public static function getDateTimes(string $type){

        $now = Carbon::now();
        switch($type){
            case MemoConst::DATE_END_OF_THIS_MONTH: //今月末の日付
                return $now->copy()->endOfMonth()->format('Y-m-d'); 
            case MemoConst::DATE_TWO_HOURS_AGO: //現在時刻の2時間前
                return $now->copy()->subHours(2)->format('Y-m-d H:i:s'); 
            case MemoConst::DATE_END_OF_NEXT_MONTH: //来月末の日付
                return $now->copy()->addMonthNoOverflow()->endOfMonth()->format('Y-m-d');
            default: //1~3以外が来た場合は現在日時
                return $now->format('Y-m-d H:i:s');
        }
    }
}