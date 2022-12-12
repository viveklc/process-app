<?php

namespace App\Models\Activity;

use App\Models\Dept;
use App\Models\Org;
use App\Models\Process\Process;
use App\Models\Process\Step;
use App\Models\Team;
use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class StepInstance extends Model implements HasMedia
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes, InteractsWithMedia;

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

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function org(){
        return $this->belongsTo(Org::class);
    }

    public function dept(){
        return $this->belongsTo(Dept::class);
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
