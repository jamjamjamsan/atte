<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class WorkTime extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "work_start", "work_end","date"];

    public function users() {
        return $this->belongsTo(User::class,"user_id");
    }
    public function rests() {
        return $this->hasMany(Rest::class);
    }
    public function getRest() {
        $sumRest = 0;
        $getRests = $this->rests;
        foreach($getRests as $getRest) {
            $sumRest += $getRest->get_rest();
        }
        
        return gmdate("H:i:s",$sumRest);
    }
    public function workTimes() {
        $endTime = strtotime($this->work_end);
        $startTime = strtotime($this->work_start);
        $getRests = $this->rests;
        $dt = new Carbon;
        $date = $dt->toDateString();
        $user = Auth::user();
        if(WorkTime::where("user_id", $user->id)->where("date", $date)->value("work_end") !== null){
        $workTime = $endTime - $startTime;
        //$diffHour = floor($diff / 3600);
       // $diffMin = floor(($diff / 60) % 60);
       // $diffSec = $diff % 60;
       // $workTime = Carbon::createFromTime($diffHour,$diffMin,$diffSec);
        
        foreach($getRests as $getRest) {
            $workTime -= $getRest->get_rest();
        }
        
        return gmdate("H:i:s", $workTime);
    } else {
            $workTime = strtotime($dt) - $startTime;
            
            foreach ($getRests as $getRest) {
                $workTime -= $getRest->get_rest();
                
            }

            return gmdate("H:i:s", $workTime);
        }
} 
}
