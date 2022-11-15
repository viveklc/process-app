<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Tag extends Model
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;

    protected $guarded = [];

    public const TAG_TYPES = [
        'language' => 'Language',
        'interest' => 'Interest',
        'gender' => 'Gender',
        'looking_for' => 'Looking for',
        'education' => 'Education',
        'sports' => 'Sports',
    ];

    public const ADDITIONAL_DETAILS = [
        'is_searchable' => [
            'value' => 'Searchable',
            'unit'  =>  'is'
        ],
    ];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Tag');
    }

    /** Reltionship */
    public function additionalInfo()
    {
        return $this->belongsToMany(Detail::class, 'sourceable_id', 'id');
    }
}
