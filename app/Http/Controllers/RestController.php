<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Rest;
use App\Models\WorkTime;
use Carbon\Carbon;

class RestController extends Controller
{
    public function restStart(){//休憩開始処理
        $user = Auth::user();
        $dt = new Carbon;
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        $work_time = WorkTime::where("user_id",$user->id)->where("date",$date)->first();
        $work_end = WorkTime::where("user_id", $user->id)->where("date", $date)->value("work_end");
        $work_start = WorkTime::where("user_id", $user->id)->where("date", $date)->value("work_start");
        $btn = [
            "work_in" => false,
            "work_end" => false,
            "rest_in" => false,
            "rest_end" => true,
        ];
        if($work_end) {//退勤しているのに休憩開始ボタンを押したときの処理
            return redirect()->back()->with("errors","すでに退勤しています");
        } elseif($work_start === null) {//出勤していないのに休憩終了ボタンを押したときの処理
            return redirect()->back()->with("errors", "出勤が押されていません");
        } else {
            Rest::create(["work_time_id" => $work_time->id, "rest_start" => $time]);


            return redirect()->back()->with(["errors" => "休憩開始しました", "btn" => $btn]);
        }
        
        
    }
    public function restEnd(){//休憩終了処理
        $user = Auth::user();
        $dt = new Carbon;
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        $work_time = WorkTime::where("user_id", $user->id)->where("date", $date)->first();
        if($work_time === null) {//出勤していないのに休憩終了ボタンを押したときの処理
            return redirect()->back()->with("errors", "出勤ボタンが押されていません");
        }
        $rest = $work_time->rests()->whereNull("rest_end")->first();
        $work_end = WorkTime::where("user_id", $user->id)->where("date", $date)->value("work_end");
        $btn = [
            "work_in" => false,
            "work_end" => true,
            "rest_in" => true,
            "rest_end" => false,
        ];
        if($work_end) {//退勤しているのに休憩終了ボタンを押したときの処理
            return redirect()->back()->with("errors", "すでに退勤しています");
        } elseif ($rest === null) {//休憩していないのに休憩終了ボタンを押したときの処理
            return redirect()->back()->with("errors", "休憩開始ボタンが押されていません");
        } else {
            Rest::where(
                "id",
                $rest->id
            )->update(["rest_end" => $time]);


            return redirect()->back()->with(["errors" => "休憩終了しました","btn" => $btn]);
        }
            //Rest::where("id", $rest->id)->update(["rest_end" => $time]);


            //return redirect()->back()->with("errors", "休憩終了しました");
        
        //Rest::where("id",$rest->id)->update(["rest_end" => $time]);


        //return redirect()->back()->with("errors", "休憩終了しました");
    }
}


//$rest_start = Rest::where("date",$date)->value("rest_start")->get();
//$rest_end = Rest::where("date",$date)->value("rest_end")->get();
//if (count($rest_start) === count($rest_end)) {
//Rest::where("date", $date)->create([
// "work_time_id" => $work_time->id,
//"rest_start" => $time
//]);
//} elseif (count($rest_start) >= count($rest_end)) {
//return redirect()->back()->with("error", "");
//}
//[$work_time = WorkTime::where("user_id", $user->id)->where("date", $date);
//$rest_start = Rest::where("date", $date)->value("rest_start")->get();
//$rest_end = Rest::where("date", $date)->value("rest_end")->get();
//if (count($rest_start) >= count($rest_end)) {
//Rest::where("date", $date)->update([
//"work_time_id" => $work_time->id,
//"rest_end" => $time
//]);
//} elseif (count($rest_start) === count($rest_end)) {
//return redirect()->back()->with("error", "");
//}]
//if ($rest === null) {
    //return redirect()->back()->with("errors",
       // "休憩開始ボタンが押されていません"
    //);
//} else {
    //Rest::where("id",
      //  $rest->id
    //)->update(["rest_end" => $time]);


   // return redirect()->back()->with("errors", "休憩終了しました");
//}