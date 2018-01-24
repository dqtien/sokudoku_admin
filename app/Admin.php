<?php
namespace App;

/**
 * Created by PhpStorm.
 * User: Vu Hai
 * Date: 2/22/2017
 * Time: 11:48 AM
 */
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Admin extends Authenticatable
{
    use EntrustUserTrait {
        EntrustUserTrait::restore insteadof SoftDeletes;
    }
    use SoftDeletes;
    use Notifiable;

    protected $table = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password','login_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * This mutator automatically hashes the password.
     *
     * @var string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

    public function adminProfile()
    {
        return $this->hasOne(AdminProfile::class);
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'admin_id', 'role_id');
    }

    public function operator()
    {
        return $this->belongsToMany(ClassTable::class, 'operator_class','admin_id','class_id');
    }
}