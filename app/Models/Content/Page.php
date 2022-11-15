<?php

namespace App\Models\Content;

use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Page extends Model
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;

    protected $guarded = [];

    public const ADDITIONAL_DETAILS = [
        'page_source' => [
            'value' => 'Page Source',
            'unit'  =>  'page'
        ],
    ];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Page');
    }

    /** Relationship */
    public function additionalInfo()
    {
        return $this->belongsToMany(Detail::class, 'sourceable_id', 'id');
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
