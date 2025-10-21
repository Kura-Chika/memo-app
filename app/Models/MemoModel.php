<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MemoModel extends Model
{
    protected $fillable = ['content'];

    /**
     * 現在時刻を基準にした日時情報を種別によって返す
     * 
     * @param int $type 1=今月末の日付, 2=現在時刻の2時間前, 3=来月末の日付
     */

    public static function getDateTimes(int $type){

        $now = Carbon::now();
        switch($type){
            case 1: //今月末の日付
                return $now->copy()->endOfMonth()->format('Y-m-d'); 
            case 2: //現在時刻の2時間前
                return $now->copy()->subHours(2)->format('Y-m-d H:i:s'); 
            case 3: //来月末の日付
                return $now->copy()->addMonthNoOverflow()->endOfMonth()->format('Y-m-d');
            default: //1~3以外が来た場合は現在日時
                return $now;
        }
    }

    protected $table = 'memos'; //Model名変更のため記述
}