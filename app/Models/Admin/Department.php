<?php

namespace App\Models\Admin;

use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Department extends Model
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;

    protected $guarded = [];


    public const ADDITIONAL_DETAILS = [
        'department_type' => [
            'value' => 'Department Type',
            'unit'  =>  'department'
        ],
        'department_space' => [
            'value' => 'Department Space',
            'unit'  =>  'space'
        ],
    ];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Department');
    }

    /** Relationship */
    public function additionalInfo()
    {
        return $this->belongsToMany(Detail::class, 'sourceable_id', 'id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
