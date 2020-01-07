<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agreement extends Model {
    use  SoftDeletes;

    public $table = "agreements";

    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function amendments () {
        // don't need to add "where status = 'D' because it's irrelavent.  If the status changes to D, so will the parent, so no need to look for it
        return $this->hasMany(Agreement::class, 'parent_id')->orderBy('created_at');
    }
}
