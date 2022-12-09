<?php

namespace App\Models\Activity;

use App\Models\Process\Step;
use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StepInstance extends Model
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;

    protected $guarded = [];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('StepInstance');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'step_instance_id');
    }


    public function step(){
        return $this->belongsTo(Step::class);
    }

    public function beforeStep(){
        return $this->belongsTo(Step::class,'before_step_id');
    }

    public function afterStep(){
        return $this->belongsTo(Step::class,'after_step_id');
    }
}
