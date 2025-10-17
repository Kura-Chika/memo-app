<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;
    
    protected $fillable = ['content'];

    public static function getOneHourAgo(){
        $oneHourAgo = new \DateTime();
        $oneHourAgo->modify('-1 hour');
        return $oneHourAgo->format('Y-m-d H:i:s');
    }
}
