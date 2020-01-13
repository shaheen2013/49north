<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mileage extends Model {
    protected $guarded = [];

    protected $dates = ['date'];
    /**
     * @return BelongsTo
     */
    public function employee () {
        return $this->belongsTo(Employee_detail::class,'emp_id')
            ->withDefault(['firstname' => 'Deleted', 'lastname' => 'User']);
    }
}
