<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mileage extends Model {
    use HasEmployee;

    protected $guarded = [];

    protected $dates = ['date'];

}
