<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;

class section extends Model
{

use EagerLoadPivotTrait;
     protected $fillable = [
        'letter',
    ];

    use HasFactory;

    public function grades(){
        return $this->belongsToMany(grade::class, 'grade_sections','section_id','grade_id');
    }
    public function users()  {
        return $this->hasMany(userlms::class, 'user_grade_sections','grade_sections','userlms_id', 'section_id');
    } 
}
