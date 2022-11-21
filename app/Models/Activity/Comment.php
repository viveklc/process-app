<?php

namespace App\Models\Activity;

use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Comment extends Model
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;

    protected $guarded = [];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Comment');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class,'in_reply_to_comment_id');
    }
}
