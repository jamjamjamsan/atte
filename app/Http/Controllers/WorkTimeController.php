<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Rest;
use App\Models\WorkTime;
use Carbon\Carbon;

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
        if(WorkTime::where("user_id",$user->id)->where("date",$date)){
            return redirect()->with("error","すでに出勤が打刻されています");
        }
        WorkTime::create([
            "user_id" => $user->id,
            "date" => $date,
            "work_start" => $time
        ]);

    }
    public function workEnd(Request $request){
        $user = Auth::user();
        $dt = new Carbon;
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        if (!WorkTime::where("user_id", $user->id)->where("date", $date)) {
            return redirect()->with("error", "すでに出勤が打刻されています");
        }
    }
    public function show(Request $request){
    }
    
}
