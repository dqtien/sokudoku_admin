<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = "role_user";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function user()
    {
        return $this->belongsTo(Admin::class);
    }
}
