<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee_detail extends Model
{
    protected $guarded = [];
    use SoftDeletes;
}
