<?php

namespace App\Models\Process;

use App\Models\Activity\ProcessInstance;
use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Process\ProcessDetail;
use App\Models\Process\ProcessRecurrence;
use App\Models\Process\ProcessTeam;
use App\Models\Process\Step;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Process extends Model implements HasMedia
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes, InteractsWithMedia;

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

    public const DURATION_UNITS = [
         'minutes' => 'Minutes',
         'seconds' => 'Seconds',
         'months' => 'Month',
         'days' => 'Day',
         'years' => 'Year',
    ];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Process');
    }

    /** Relationship */
    public function org()
    {
        return $this->belongsTo(Org::class);
    }

    public function processDetails()
    {
        return $this->hasMany(ProcessDetail::class,'process_id');
    }

    public function processInstances(){
        return $this->hasMany(ProcessInstance::class,'process_id')->isActive();
    }

    public function processRecurrences()
    {
        return $this->hasMany(ProcessRecurrence::class);
    }

    public function processTeams()
    {
        return $this->hasMany(ProcessTeam::class,'process_id');
    }

    public function steps()
    {
        return $this->hasMany(Step::class)->isActive();
    }

}
