<?php

namespace App\Models\DMS;

use App\Models\User;
use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Activity extends Model
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;

    public $connection = 'mysql2';

    protected $guarded = [];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Activity');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activityDetails()
    {
        return $this->hasMany(ActivityDetail::class,'activity_id');
    }
}
