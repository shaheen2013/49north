<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paystatement extends Model {
    use HasEmployee;

    public $timestamps = false;

    protected $primaryKey = 'emp_id';

    protected $fillable = ['emp_id', 'pdfname', 'description', 'date', 'created_at'];

}
