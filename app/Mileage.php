<?php

namespace App;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mileage extends Model {
    use HasEmployee;
    use  SoftDeletes;

    protected $guarded = [];

    public $table = "mileages";
    protected $fillable = ['company', 'date', 'vehicle', 'kilometers', 'reasonmileage'];


}
