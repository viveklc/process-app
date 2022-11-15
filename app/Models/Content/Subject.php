<?php

namespace App\Models\Content;

use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class Subject extends Model implements HasMedia
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes, InteractsWithMedia;

    protected $guarded = [];

    public const ADDITIONAL_DETAILS = [
        'is_latest' => [
            'value' => 'Is Latest',
            'unit'  =>  'latest'
        ],
        'subject_type' => [
            'value' => 'Subject Type',
            'unit'  =>  'subject'
        ],
    ];

    protected $appends = [
        'tag_data'
    ];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Subject');
    }

    /**
     * for spatie media management
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('Subject')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('preview')->fit(Manipulations::FIT_CROP, 300, 300)->nonQueued();
                $this->addMediaConversion('thumb')->fit(Manipulations::FIT_CROP, 50, 50)->nonQueued();
            });
    }

    /** Relationship */
    public function additionalInfo()
    {
        return $this->belongsToMany(Detail::class, 'sourceable_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function getTagDataAttribute()
    {
        $tagId = $this->getOriginal('tags');
        $tagArray = Tag::whereIn('id', explode(',', $tagId))->pluck('tag_name')->toArray();
        $tagString = implode(', ', $tagArray);
        return $tagString;
    }
}
