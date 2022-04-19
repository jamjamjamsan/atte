<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkTime;

class Rest extends Model
{
    use HasFactory;
    protected $fillable = ["work_time_id","rest_start","rest_end"];

    public function work() {
        return $this->belongsTo("WorkTime::class");
    }

    public function rest(){
        $startTime = strtotime($this->rest_start);
        $endTime = strtotime($this->rest_end);
        $diff = $endTime - $startTime;
        $diffHour = floor($diff / 3600);
        $diffMin = floor(($diff / 60) % 60);
        $diffSec = $diff % 60;
        $diffRest = $diffHour. ":".$diffMin.":".$diffSec;
        $diff = Carbon::createFromTime($diffHour,$diffMin,$diffSec);
        dd($diff);
        return $diffRest;
    }
    public function get_rest()
    {
        $startTime = strtotime($this->rest_start);
        $endTime = strtotime($this->rest_end);
        if($endTime !== false) {
            $diff = $endTime - $startTime;
            
            
            return $diff; 
        } else{
            $user = Auth::user();
            $dt = new Carbon;
            $date = $dt->toDateString();
            $time = $dt->toTimeString();

            $diff = strtotime($dt) - $startTime;
            
            return $diff; 
        }
       
        }
       
    }

