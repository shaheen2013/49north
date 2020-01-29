<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee_detail extends Model {
    protected $guarded = [];
    use SoftDeletes;
    protected $fillable = [
        'firstname',
        'lastname',
        'dob',
        'personalemail',
        'phone_no',
        'address',
        'workemail',
        'profile_pic',
        'marital_status',
        'no_ofchildren',
        'family_inarea',
        'familycircumstance',
        'prsnl_belief',
        'known_medical_conditions',
        'allergies',
        'dietary_restrictions',
        'known_health_concerns',
        'aversion_phyactivity',
        'emergency_contact_name',
        'reltn_emergency_contact',
        'emergency_contact_phone',
        'emergency_contact_email',
        'company_id'
    ];

    /**
     * @return HasOne
     */
    public function user () {
        return $this->hasOne(User::class, 'id', 'id');
    }

    /**
     * @return string
     */
    public function getNameAttribute () {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * @return HasOne
     */
    public function activeAgreement () {
        return $this->hasOne(Agreement::class,'emp_id')->where('status','A')->whereNull('parent_id');
    }

    public function personalPlan(){
        return $this->hasMany('App\PersonalDevelopmentPlan', 'emp_id', 'id');
    }
    
    /**
     * @return HasOne
     */
    public function activeCodeofconduct () {
        return $this->hasOne(Codeofconduct::class,'emp_id')->where('status','A');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
