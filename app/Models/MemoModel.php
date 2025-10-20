<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MemoModel extends Model
{
    /**
     * 現在時刻を基準にした日時情報 
     * @return array 日時情報
     */
    
    public static function getDateTimes(){

        $now = Carbon::now();
        return [
            'oneHourAgo' => $now->copy()->subHour()->format('Y-m-d H:i:s'), //現在の1時間前
            'endOfMonth' => $now->copy()->endOfMonth()->format('Y-m-d'), //今月月末
            'startOfNextMonth' => $now->copy()->addMonthNoOverflow()->startOfMonth()->format('Y-m-d'), //来月月初
        ];
    }

    protected $table = 'memos'; //Model名変更のため記述
}