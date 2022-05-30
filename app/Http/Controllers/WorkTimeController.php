<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Rest;
use App\Models\WorkTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use function PHPUnit\Framework\isEmpty;



class WorkTimeController extends Controller
{
    public function index(){
        $work_in = false;
        $work_out = false;
        $rest_in = false;
        $rest_out = false;
        $user = Auth::user();
        $dt = new Carbon;
        $date = $dt->toDateString();
        $worktime = WorkTime::where("user_id",$user->id)->where("date",$date)->first();
        //$rest = WorkTime::where("user_id", $user->id)->where("date", $date)->first()->rests;
        $yesterday = Carbon::yesterday()->toDateString();


        
        $pasttime = WorkTime::where("user_id", $user->id)->where("date", $yesterday)->first();
        $pastrest = $pasttime->rests()->whereNull("rest_end")->first();
        $past = WorkTime::where("user_id",$user->id)->where("date","<",$date)->first();
        
        if (isset($pasttime) && $pasttime->work_start !== null && $pasttime->work_end === null && $pasttime->date !== $date) {//退勤が日をまたいだ時の処理
            $pasttime->update([
                "work_end" => "23:59:59"
            ]);
            WorkTime::create([
                "user_id" => $user->id,
                "work_start" => "00:00:00",
                "date" => $date
            ]);
        } elseif(isset($past) && $past->work_start !== null && $past->work_end === null && $past->date !== $date) {
            $errors = "$past->date.の退勤を押されていません";
        }
        if ($worktime !== null) { // 勤務開始ボタンを押した場合
            if ($worktime->work_end === null) { // 勤務終了ボタンを押した場合
                $rest = Rest::where('work_time_id', $worktime->id)->latest()->first();
                if ($rest !== null) { // 休憩開始ボタンを押した場合
                    if ($rest->rest_end !== null) { // 休憩終了ボタンを押した場合
                        $work_out = true;
                        $rest_in = true;
                    } else { // 休憩中の場合
                        $work_out = false;
                        $rest_out = true;
                        // $rest_out = true;
                    }
                } else { // 休憩中ではない場合
                    $work_out = true;
                    $rest_in = true;
                }
            }
        } else { // 当日初めてログインした場合
            $work_in = true;
        }

        $btn = [
            'work_in' => $work_in,
            'work_out' => $work_out,
            'rest_in' => $rest_in,
            'rest_out' => $rest_out,
        ];
        return view('welcome', ['btn' => $btn,"errors" => $errors]);
    }
        
        
        
        
    
    public function workStart(Request $request){//出勤処理
        $user = Auth::user();
        $dt = new Carbon;
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        $btn = [
            "work_in" => false,
            "work_end" => true,
            "rest_in" => true,
            "rest_end" => false,
        ];
        if(WorkTime::where("user_id",$user->id)->where("date",$date)->value("work_start") !== null) {//出勤を日に2度押したときの処理
            return redirect()->back()->with("errors","すでに出勤が打刻されています");
        }
        WorkTime::create([
            "user_id" => $user->id,
            "date" => $date,
            "work_start" => $time
        ]);
        return redirect()->back()->with(["errors" =>"勤務しました", "btn" => $btn]);

    }
    public function workEnd(Request $request){//退勤示処理
        $user = Auth::user();
        
        $dt = new Carbon;
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        $yesterday = Carbon::yesterday()->toDateString();
        
        
        $worktime = WorkTime::where("user_id", $user->id)->where("date", $date)->first();
        $pasttime = WorkTime::where("user_id", $user->id)->where("date",$yesterday)->first();
        $btn = [
            "work_in" => false,
            "work_end" => false,
            "rest_in" => false,
            "rest_end" => false,
        ];
        
        if(isset($pasttime) && $pasttime->work_start !== null && $pasttime->work_end === null && $pasttime->date !== $date) {//日をまたがって勤務した処理
            $pasttime->update([
                "work_end" => "23:59:59"
            ]);
            WorkTime::create([
                "user_id" => $user->id,
                "start_time" => "00:00:00",
                "date" => $date
            ]);
        }
        if (null === WorkTime::where("user_id", $user->id)->where("date", $date)->value("work_start")) {//出勤を押していないのに退勤を押したときの処理
            return redirect()->back()->with("errors", "出勤が押されていません");
        }

        $worktime = WorkTime::where("user_id", $user->id)->where("date", $date)->first()->rests;
        $rest = $worktime->whereNull("rest_end")->first();

        if($rest) {//休憩が終わっていないのに退勤を押したときの処理
            
            return redirect()->back()->with("errors", "休憩が終わっていません");
        }
        //if($worktime->values("rest_start")->count() > $worktime->values("rest_end")->count()){
            //return redirect()->back()->with("errors", "休憩が終わっていません");
        // } else {
            //dd($worktime->values("rest_end")->count());
        //}
        

        
        if (WorkTime::where("user_id",$user->id)->where("date",$date)->value("work_start") === null) {
            return redirect()->back()->with("errors", "出勤が打刻されていません");
        }
        
        if (empty(WorkTime::where("user_id", $user->id)->where("date", $date)->value("work_end"))) {
            WorkTime::where("user_id", $user->id)->where("date", $date)->update(["work_end" => $time]);
            return redirect()->back()->with("errors", $user->name."さんお疲れさまでした!");
    } else {
        return redirect()->back()->with(["errors" => "すでに退勤してます", "btn" => $btn]);
    }
    }
    public function show(Request $request){//当日の出勤一覧を表示処理
        $user = Auth::user();
        $user_id = Auth::id();
        $work = WorkTime::where("user_id",$user_id)->first();
        
        $dt = new Carbon;
        $date = $dt->toDateString();
        $work_time = WorkTime::whereDate("date", $date)->orderBy("user_id", "asc")->paginate(5);
        

        return view("show",["today" => $date, "works" => $work_time]);
    }
    public function back(Request $request) {//前日の日付一覧を表示処理
        
        $dt = new Carbon($request->back);
        $date = $dt->subDay()->format("Y-m-d");
        
        $work_time = WorkTime::whereDate("date", $date)->orderBy("user_id", "asc")->paginate(5);
        
        return view("show", ["today" => $date, "works" => $work_time]);
    }
    public function next(Request $request) {//翌日の日付一覧を表示処理
        $dt = new Carbon($request->next);
        //$dx = $dt->format("Y-m-d");
        $now = new Carbon();
        $today = $now->toDateString();
        $date = $dt->addDay()->format("Y-m-d");
        $work_time = WorkTime::whereDate("date", $date)->orderBy("user_id", "asc")->paginate(5);
        
        return view("show", ["today" => $date, "works" => $work_time]);
        }
    
    public function user() {//ユーザー一覧を表示処理
        $users = User::all();
        
        return view("user", ["users" => $users]);
    }
    public function userPage(Request $request) {//ユーザーごとの出勤一覧を表示処理
        $user = WorkTime::where("user_id",$request->userlist)->get();
        
        return view("userpage",["user" => $user]);

    } 
    }
    

//if (WorkTime::where("user_id",$user->id)->where("date",$date)->whereNull("work_end")){
           // WorkTime::where("user_id", $user->id)->where("date", $date)->update(["work_end" => $time]);
           // return redirect()->back()->with("success", "勤務終了しました");

//$rest = Rest::where("work_time_id",$work->id)->first();