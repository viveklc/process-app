<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Dept extends Model
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;

    protected $guarded = [];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Dept');

    }

    public function org()
    {
        return $this->belongsTo(Org::class);
    }

    public function deptUsers()
    {
        return $this->belongsToMany(User::class,'dept_users','dept_id','user_id')
        ->withPivot('valid_from','valid_to');
    }


}
