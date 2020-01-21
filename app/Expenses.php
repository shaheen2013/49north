<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
class Expenses extends Authenticatable {
    use Notifiable, HasRoles, HasEmployee;
    use  SoftDeletes;

    public $table = "expenses";
    // protected $fillable = ['company', 'date', 'vehicle', 'kilometers', 'reasonmileage'];

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
