<?php

namespace App\Models\DMS;

use App\Models\User;
use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Document extends Model
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;

    public $connection = 'mysql2';
    protected $guarded = [];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Document');
    }

    public function authors(){
        return $this->belongsToMany(User::class,'document_autors','user_id','document_id')
        ->withPivot('is_primary')
        ->withTimestamps();
    }

    public function tags(){
        return $this->belongsToMany(DocTag::class,'document_tags','document_tag_id','document_id')
        ->withTimestamps();
    }

    public function documentTags(){
        return $this->hasMany(DocumentTag::class,'document_id');
    }

    public function comments()
    {
        return $this->hasMany(DocumentComment::class,'document_id');
    }

    public function documentDetail(){
        return $this->hasMany(documentDetail::class,'document_id');
    }

    public function documentVotes(){
        return $this->hasMany(DocumentVote::class,'document_id');
    }

    public function user()
    {
        return $this->hasMany(User::class,'user_id');
    }
}
