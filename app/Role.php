<?php
namespace App;
/**
 * Created by PhpStorm.
 * User: Hai Vu
 * Date: 12/27/2016
 * Time: 11:21 PM
 */
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public function permission(){
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }
}