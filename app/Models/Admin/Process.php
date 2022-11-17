<?php

namespace App\Models\Admin;

use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Admin\ProcessDetail;
use App\Models\Admin\ProcessRecurrence;
use App\Models\Admin\ProcessTeam;
use App\Models\Admin\Step;

class Process extends Model
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;

    protected $guarded = [];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Process');
    }

    /** Relationship */
    // public function org()
    // {
    //     return $this->belongsTo(Org::class);
    // }

    public function processDetails()
    {
        return $this->hasMany(ProcessDetail::class);
    }

    public function processRecurrences()
    {
        return $this->hasMany(ProcessRecurrence::class);
    }

    public function processTeams()
    {
        return $this->hasMany(ProcessTeam::class);
    }
    
    public function steps()
    {
        return $this->hasMany(Step::class);
    }

}
