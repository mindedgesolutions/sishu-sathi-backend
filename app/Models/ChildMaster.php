<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildMaster extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'dob',
        'gender',
        'blood_group',
        'relationship',
        'mobile',
        'weight',
        'profile_img',
    ];

    public function childDetails()
    {
        return $this->hasOne(ChildDetails::class, 'child_master_id');
    }
}
