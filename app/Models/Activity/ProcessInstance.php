<?php

namespace App\Models\Activity;

use App\Models\Dept;
use App\Models\Org;
use App\Models\Team;
use App\Models\User;
use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ProcessInstance extends Model
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;

    protected $guarded = [];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('ProcessInstance');
    }

    public function org()
    {
        return $this->belongsTo(Org::class);
    }

    public function dept()
    {
        return $this->belongsTo(Dept::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function assignedToUser()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'process_instances_id', 'id');
    }
}
