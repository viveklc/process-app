<?php

namespace App\Models\Process;

use App\Models\Dept;
use App\Models\Org;
use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Process\Process;
use App\Models\Team;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Step extends Model implements HasMedia
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;
    use InteractsWithMedia;

    protected $guarded = [];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Step');
    }


    /** Relationship */
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

    public function afterStep(){
        return $this->belongsTo(Step::class,'after_step_id');
    }

    public function beforeStep(){
        return $this->belongsTo(Step::class,'before_step_id');
    }

}
