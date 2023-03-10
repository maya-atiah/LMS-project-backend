<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'date',
    ];

    public function Student(){
        return $this->belongsTo(userlms::class,  'studentId','id');
    }

    public function gradeSection(){
        return $this->belongsTo(grade_section::class,  'gradeSectionId','id');
    }

}
