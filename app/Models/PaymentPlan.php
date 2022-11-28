<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PaymentPlan extends Model
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;

    protected $guarded = [];

    public const ADDITIONAL_DETAILS = [
        'plan_type' => [
            'value' => 'Plan Type',
            'type'  =>  'type'
        ],
        'effective_from' => [
            'value' => 'Effective From',
            'type'  =>  'date'
        ],
        'test_field' => [
            'value' => 'Test Field',
            'type'  =>  'test'
        ],
    ];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('PaymentPlan');
    }

    public function planDetails(){
        return $this->hasMany(PlanDetail::class,'plan_id');
    }
}
