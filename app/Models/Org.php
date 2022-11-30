<?php

namespace App\Models;

use App\Models\Activity\ProcessInstance;
use App\Models\Activity\UserInvite;
use App\Models\Process\Step;
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

class Org extends Model implements HasMedia
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes, InteractsWithMedia;

    protected $guarded = [];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Org');
    }

    /**
     * for spatie media management
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('Org')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('preview')->fit(Manipulations::FIT_CROP, 300, 300)->nonQueued();
                $this->addMediaConversion('thumb')->fit(Manipulations::FIT_CROP, 50, 50)->nonQueued();
            });
    }

    public function departments()
    {
        return $this->hasMany(Dept::class,'org_id','id');
    }

    public function users()
    {
        return $this->hasMany(User::class,'org_id');
    }

    public function processInstance()
    {
        return $this->hasMany(ProcessInstance::class,'org_id');
    }

    public function invites()
    {
        return $this->hasMany(UserInvite::class,'org_id');
    }

    public function teamOrg(){
        return $this->hasMany(Team::class,'org_id');
    }

    public function steps(){
        return $this->hasMany(Step::class,'org_id');
    }




}
