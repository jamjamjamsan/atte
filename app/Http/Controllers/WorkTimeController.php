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
            return redirect()->back()->with("errors", $user->name."さんお疲れさまでした!");
    } else {
        return redirect()->back()->with("errors","すでに退勤してます");
    }
    }
    public function show(Request $request){
        $user = Auth::user();
        $user_id = Auth::id();
        $work = WorkTime::where("user_id",$user_id)->first();
        $rest = Rest::where("work_time_id","$work->id")->first();
        $dt = new Carbon;
        $date = $dt->toDateString();
        $work_time = WorkTime::whereDate("date", $date)->orderBy("user_id", "asc")->paginate(5);
        

        return view("show",["today" => $date, "works" => $work_time]);
    }
    public function back(Request $request) {
        
        $dt = new Carbon($request->back);
        $date = $dt->subDay()->format("Y-m-d");
        
        
        $work_time = WorkTime::whereDate("date", $date)->orderBy("user_id", "asc")->paginate(5);
        return view("show", ["today" => $date, "works" => $work_time]);
    }
    public function next(Request $request) {
        $dt = new Carbon($request->next);
        //$dx = $dt->format("Y-m-d");
        $now = new Carbon();
        $today = $now->toDateString();
        $date = $dt->addDay()->format("Y-m-d");
        $work_time = WorkTime::whereDate("date", $date)->orderBy("user_id", "asc")->paginate(5);
        return view("show", ["today" => $date, "works" => $work_time]);
        }
        
    }
    

//if (WorkTime::where("user_id",$user->id)->where("date",$date)->whereNull("work_end")){
           // WorkTime::where("user_id", $user->id)->where("date", $date)->update(["work_end" => $time]);
           // return redirect()->back()->with("success", "勤務終了しました");