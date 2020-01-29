<?php

namespace App;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class PersonalDevelopmentPlan extends Model
{
    use SoftDeletes, SearchTrait;
    public $table = "personal_development_plans";
    protected $fillable = ['emp_id', 'title', 'description', 'start_date', 'end_date', 'comment'];

    public function employee(){
        return $this->belongsTo('App\Employee_detail', 'emp_id', 'id');
    }
}
