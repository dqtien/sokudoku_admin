<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminProfile extends Model
{
    use SoftDeletes;
    protected $table = "admin_profile";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name','user_id', 'avatar'
    ];


    public function adminUser()
    {
        return $this->belongsTo(Admin::class);
    }
}
