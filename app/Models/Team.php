<?php

namespace App\Models;

use App\Models\Activity\ProcessInstance;
use App\Models\Activity\UserInvite;
use App\Models\Process\Process;
use App\Models\Process\ProcessTeam;
use App\Models\Process\Step;
use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelAccessor;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Team extends Model implements HasMedia
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes,ModelAccessor;
    use InteractsWithMedia;

    protected $guarded = [];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Team');
    }

    public function teamUser()
    {
        return $this->belongsToMany(User::class, 'team_users', 'team_id', 'user_id')
            ->withPivot('valid_from', 'valid_to');
    }

    public function invites()
    {
        return $this->hasMany(UserInvite::class, 'team_id');
    }

    public function processInstance()
    {
        return $this->hasMany(ProcessInstance::class, 'team_id');
    }


    public function org(){
        return $this->hasOne(Org::class,'id','org_id');
    }

    public function step(){
        return $this->hasMany(Step::class,'team_id');
    }

    public function teamProcess(){
        return $this->belongsToMany(Process::class,'process_teams','team_id','process_id')
        ->withPivot('valid_from','valid_to')
        ->withTimestamps();
    }
}
