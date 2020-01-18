<?php

namespace App;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model {
    use  SoftDeletes;

    public $table = "companies";
}
