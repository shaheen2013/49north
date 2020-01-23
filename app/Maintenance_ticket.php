<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Maintenance_ticket extends Authenticatable {
    use SoftDeletes, Notifiable, HasRoles, HasEmployee;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard = [];

    /* public function setPasswordAttribute($password)
     {
         $this->attributes['password'] = bcrypt($password);
     }*/
}
