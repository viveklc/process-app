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
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Step extends Model implements HasMedia
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes, InteractsWithMedia;

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

}
