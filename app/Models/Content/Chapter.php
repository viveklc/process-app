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

class Chapter extends Model implements HasMedia
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes, InteractsWithMedia;

    protected $guarded = [];

    public const ADDITIONAL_DETAILS = [
        'chapter_type' => [
            'value' => 'Chapter Type',
            'unit'  =>  'chapter'
        ],
        'is_latest' => [
            'value' => 'Is Latest',
            'unit'  =>  'latest'
        ],
    ];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Chapter');
    }

    /**
     * for spatie media management
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('Chapter')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('preview')->fit(Manipulations::FIT_CROP, 300, 300)->nonQueued();
                $this->addMediaConversion('thumb')->fit(Manipulations::FIT_CROP, 50, 50)->nonQueued();
            });
    }

    public function chapterMedia()
    {
        $medias = $this->getMedia('Chapter');

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

    public function chapterSingleMedia()
    {
        $medias = $this->getMedia('Chapter');
        if($medias->count()) {
            return $medias[0]->original_url;
        }

        return "";
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

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }
}
