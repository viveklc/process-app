<?php

namespace App\Models;

use App\Models\Activity\ProcessInstance;
use App\Models\Activity\UserInvite;
use App\Traits\ModelScopes;
use Spatie\Image\Manipulations;
use App\Traits\CreatedUpdatedBy;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity, HasRoles, InteractsWithMedia;
    use CreatedUpdatedBy, ModelScopes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable  = [
        'org_id', 'name', 'username', 'email', 'password', 'phone', 'image_url', 'is_org_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Spatie Activity Log
     */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('User');
    }

    /**
     * for spatie media management
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('User')
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('preview')->fit(Manipulations::FIT_CROP, 300, 300)->nonQueued();
                $this->addMediaConversion('thumb')->fit(Manipulations::FIT_CROP, 50, 50)->nonQueued();
            });

        $this->addMediaCollection('profile_photo')
            ->onlyKeepLatest(6)
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('preview')->fit(Manipulations::FIT_CROP, 300, 300)->nonQueued();
                $this->addMediaConversion('thumb')->fit(Manipulations::FIT_CROP, 50, 50)->nonQueued();
            });
    }

    public function birthday(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Carbon::parse($value)->format(config('app-config.date_format.date')),
        );
    }

    // #TODO #LCNOTE enable this. somehow on API login, this is causing issue
    public function createdAt(): Attribute
    {
        /* return new Attribute(
            get: fn ($value) => Carbon::parse($value)->format(config('app-config.date_format.date').' '.config('app-config.date_format.time')),
        ); */

        return new Attribute(
            get: fn ($value) => $value,
        );
    }

    public function userProfileMedia()
    {
        $medias = $this->getMedia('profile_photo');

        $returnMedias = [];
        foreach ($medias as $media) {
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

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /** Relationship */
    public function otps()
    {
        return $this->hasMany(Otp::class);
    }

    public function userActivities()
    {
        return $this->hasMany(UserActivity::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function userCourses()
    {
        return $this->hasMany(UserCourse::class);
    }

    public function userPayments()
    {
        return $this->hasMany(UserPayment::class);
    }

    public function userDetail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function userMetas()
    {
        return $this->hasMany(UserMeta::class);
    }

    public function userQuizes()
    {
        return $this->hasMany(UserQuiz::class);
    }

    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function userResponses()
    {
        return $this->hasMany(UserResponse::class);
    }

    public function quizLeaderboards()
    {
        return $this->hasMany(QuizLeaderboard::class);
    }

    /**
     * code for process applicaiton
     */

    public function org()
    {
        return $this->belongsTo(Org::class);
    }

    public function userDeptRoles()
    {
        return $this->belongsToMany(Dept::class, 'user_org_roles', 'user_id', 'dept_id')
            ->withPivot('current_role', 'valid_from', 'valid_to');
    }

    public function collegues()
    {
        return $this->hasMany(User::class, 'is_colleague_of_user_id');
    }

    public function reportTo()
    {
        return $this->hasMany(User::class, 'reports_to_user_id');
    }

    public function Invites()
    {
        return $this->hasMany(UserInvite::class, 'invited_by_user_id');
    }

    public function assignedProcessInstance()
    {
        return $this->hasMany(ProcessInstance::class, 'assigned_to_user_id', 'id');
    }
}
