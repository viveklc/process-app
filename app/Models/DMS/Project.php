<?php

namespace App\Models\DMS;

use App\Models\User;
use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Project extends Model
{
    use HasFactory;
    use CreatedUpdatedBy, ModelScopes;

    public $connection = 'mysql2';

    protected $guarded = [];

    public const ADDITIONAL_DETAILS = [
        'project_type' => [
            'value' => 'Project Type',
            'type'  =>  'text'
        ],
        'start_from' => [
            'value' => 'Start From',
            'type'  =>  'date'
        ],
        'end_from' => [
            'value' => 'End Date',
            'type'  =>  'date'
        ],
        'project_description' => [
            'value' => 'Description',
            'type' => 'text'
        ]
    ];

    public const PROJECT_STATUS = [
        'active','in-active','completed','in progress'
    ];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Project');
    }

    public function projectUsers()
    {
        return $this->belongsToMany(User::class, 'project_users')
            ->withPivot('user_role', 'status')
            ->withTimestamps();
    }

    public function projectDetails()
    {
        return $this->hasMany(ProjectDetail::class,'project_id');
    }

    public function documents(){
        return $this->hasMany(Document::class,'project_id')->isActive();
    }

    public function projectInvites(){
        return $this->hasMany(Invite::class,'project_id');
    }


}
