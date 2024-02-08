<?php

namespace App\Models;

use App\Models\User;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['name','email','national_id','date_birth','grade_id','classroom_id','section_id','user_id'] ;
    public function grade(){
        return $this->belongsTo(Grade::class);
    }
    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }
    public function section(){
        return $this->belongsTo(Section::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
