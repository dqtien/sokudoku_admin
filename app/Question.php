<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    protected $table = "questions";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','question_type_id', 'content', 'level', 'writing', 'line_type'
    ];

    public function question_answer(){
        return $this->hasOne(QuestionAnswer::class,'questions_id','id');
    }

    public function question_type()
    {
        return $this->hasOne(QuestionType::class,'id','question_type_id');
    }

}
