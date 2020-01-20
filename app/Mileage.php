<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mileage extends Model {
    use HasEmployee;

    protected $guarded = [];

    public $table = "mileages";
    protected $fillable = ['company', 'date', 'vehicle', 'kilometers', 'reasonmileage'];


}
