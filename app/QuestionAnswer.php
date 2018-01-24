<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionAnswer extends Model
{
    use SoftDeletes;
    protected $table = "question_answer";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'questions_id', 'content'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
