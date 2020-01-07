<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Codeofconduct extends Model {
    use  SoftDeletes;

    protected $guarded = [];

    protected $table = "codeofconducts";
}
