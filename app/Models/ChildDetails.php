<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildDetails extends Model
{
    protected $fillable = [
        'child_master_id',
        'below_18_above_35',
        'medical_condition',
        'take_suppliments',
        'complications_pregnancy',
        'assisted_delivery',
        'hospital_born',
        'before_37',
        'less_than_two_and_half',
        'apgar_below_7',
        'complications_birth',
        'cry_at_birth',
        'delay_time',
        'nicu_stay',
        'breastfeeding_within_1',
        'jaundice_other',
        'hospitalised_year_1',
        'seizures'
    ];

    public function childMaster()
    {
        return $this->belongsTo(ChildMaster::class, 'child_master_id');
    }
}
