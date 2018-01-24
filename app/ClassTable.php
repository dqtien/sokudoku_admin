<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassTable extends Model
{
    use SoftDeletes;
    protected $table = "class";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'author_name', 'name'
    ];

    public function admin()
    {
        return $this->belongsToMany(Admin::class, 'operator_class', 'admin_id', 'class_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, "user_class", "user_id", "class_id");
    }
}
