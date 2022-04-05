<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Rest;
use App\Models\WorkTime;
use Carbon\Carbon;

use function PHPUnit\Framework\isEmpty;

class WorkTimeController extends Controller
{
    public function index(){
        return view("welcome");
    }
    public function workStart(Request $request){
        $user = Auth::user();
        $dt = new Carbon;
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        if(WorkTime::where("user_id",$user->id)->where("date",$date)->value("work_start") !== null){
            return redirect()->back()->with("errors","すでに出勤が打刻されています");
        }
        WorkTime::create([
            "user_id" => $user->id,
            "date" => $date,
            "work_start" => $time
        ]);
        return redirect()->back()->with("errors", "勤務しました");

    }
    public function workEnd(Request $request){
        $user = Auth::user();
        
        $dt = new Carbon;
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        
        if (WorkTime::where("user_id",$user->id)->where("date",$date)->value("work_start") === null) {
            return redirect()->back()->with("errors", "出勤が打刻されていません");
        }
        
        if (empty(WorkTime::where("user_id", $user->id)->where("date", $date)->value("work_end"))) {
            WorkTime::where("user_id", $user->id)->where("date", $date)->update(["work_end" => $time]);
            return redirect()->back()->with("errors", "勤務終了しました");
    } else {
        return redirect()->back()->with("errors","すでに退勤してます");
    }
    }
    public function show(Request $request){
        $user = Auth::user();
        $work = WorkTime::all();
        $rest = Rest::all();
        $dt = new Carbon;
        $date = $dt->toDateString();
        $work_time = WorkTime::whereDate("date", $date)->orderBy("user_id", "asc")->paginate(5);
        return view("show",["today" => $date, "work" => $work_time]);
    }
    
}
//if (WorkTime::where("user_id",$user->id)->where("date",$date)->whereNull("work_end")){
           // WorkTime::where("user_id", $user->id)->where("date", $date)->update(["work_end" => $time]);
           // return redirect()->back()->with("success", "勤務終了しました");