<?php

namespace App\Models\DMS;

use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DocumentTag extends Model
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;

    public $connection = 'mysql2';
    protected $guarded = [];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('DocumentTag');
    }
}
