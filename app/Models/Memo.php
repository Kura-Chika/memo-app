<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Memo extends Model
{
    use HasFactory;
    
    protected $fillable = ['content'];

    public static function getDateTimes(){

        $now = Carbon::now();
        return [
            'oneHourAgo' => $now->copy()->subHour()->format('Y-m-d H:i:s'), //現在の1時間前
            'endOfMonth' => $now->copy()->endOfMonth()->format('Y-m-d'), //今月月末
            'startOfNextMonth' => $now->copy()->addMonthNoOverflow()->startOfMonth()->format('Y-m-d'), //来月月初
        ];
    }
}