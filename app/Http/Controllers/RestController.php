<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Rest;
use App\Models\WorkTime;
use Carbon\Carbon;

class RestController extends Controller
{
    public function restStart(){
        $user = Auth::user();
        $dt = new Carbon;
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        $work_time = WorkTime::where("user_id",$user->id)->where("date",$date)->first();
        
        Rest::create(["work_time_id" => $work_time->id,"rest_start" => $time]);
        
        
        return redirect()->back()->with("errors", "休憩開始しました");
        
    }
    public function restEnd(){
        $user = Auth::user();
        $dt = new Carbon;
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        $work_time = WorkTime::where("user_id", $user->id)->where("date", $date)->first();
        $rest = $work_time->rests()->whereNull("rest_end")->first();
        
        Rest::where("id",$rest->id)->update(["rest_end" => $time]);


        return redirect()->back()->with("errors", "休憩開始しました");
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