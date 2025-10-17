<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;

class MemoController extends Controller
{
    public function index(){
        $memos = Memo::orderBy('created_at', 'desc')->get(); //メモ一覧取得
        $oneHourAgo = Memo::getOneHourAgo(); //現在日時の1時間前を取得
        return view('memo', compact('memos','oneHourAgo'));
    }

    public function store(Request $request){
        $request->validate(['content' => 'required']);
        Memo::create(['content' => $request->content]);
        return redirect()->back();
    }

    public function destroy($id){
        $memo = Memo::find($id);
        if ($memo){
            $memo->delete();
        }
        return redirect()->back();
    }

}