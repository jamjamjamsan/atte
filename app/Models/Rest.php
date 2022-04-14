<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;
    protected $fillable = ["work_time_id","rest_start","rest_end"];

    public function work() {
        return $this->belongsTo("WorkTime::class");
    }

    public function get_rest(){
        $startTime = strtotime($this->rest_start);
        $endTime = strtotime($this->rest_end);
        $diff = $endTime - $startTime;
        return $diff;
    }
}
