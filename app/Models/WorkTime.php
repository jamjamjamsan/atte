<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
