<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

Trait HasEmployee {

    /**
     * @return BelongsTo
     */
    public function employee () {
        return $this->belongsTo(Employee_detail::class, 'emp_id')->withDefault(['firstname' => 'Deleted', 'lastname' => 'User']);
    }
}
