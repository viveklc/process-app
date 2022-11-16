<?php

namespace App\Models;

use App\Models\Activity\ProcessInstance;
use App\Models\Activity\UserInvite;
use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Org extends Model
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;

    protected $guarded = [];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Org');
    }

    public function departments()
    {
        return $this->hasMany(Dept::class,'org_id','id');
    }

    public function users()
    {
        return $this->hasMany(User::class,'org_id');
    }

    public function HasProcessInstance()
    {
        return $this->hasMany(ProcessInstance::class,'org_id');
    }

    public function Hasinvites()
    {
        return $this->hasMany(UserInvite::class,'org_id');
    }
}
