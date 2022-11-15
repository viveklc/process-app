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

class Course extends Model implements HasMedia
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes, InteractsWithMedia;

    protected $guarded = [];

    protected $appends = [
        'tag_data'
    ];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Course');
    }

    /**
     * for spatie media management
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('Course')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('preview')->fit(Manipulations::FIT_CROP, 300, 300)->nonQueued();
                $this->addMediaConversion('thumb')->fit(Manipulations::FIT_CROP, 50, 50)->nonQueued();
            });
    }

    public function courseMedia()
    {
        $medias = $this->getMedia('Course');

        $returnMedias = [];
        foreach($medias as $media ) {
            $returnMedia = [
                'id' => $media->id,
                'original_url' => $media->original_url,
                'preview_url' => $media->preview_url,
                'thumb_url' => $media->getUrl('thumb'),
                'name' => $media->name,
                'file_name' => $media->file_name,
                'extension' => $media->extension,
                'size' => $media->size,
            ];
            array_push($returnMedias, $returnMedia);
        }
        return $returnMedias;
    }

    public function courseSingleMedia()
    {
        $medias = $this->getMedia('Course');
        if($medias->count()) {
            return $medias[0]->original_url;
        }

        return "";
    }

    /** Relationship */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function levels()
    {
        return $this->hasMany(Level::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function getTagDataAttribute()
    {
        $tagId = $this->getOriginal('tags');
        $tagArray = Tag::whereIn('id', explode(',', $tagId))->pluck('tag_name')->toArray();
        $tagString = implode(', ', $tagArray);
        return $tagString;
    }
}
