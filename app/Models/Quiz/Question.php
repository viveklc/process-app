<?php

namespace App\Models\Quiz;

use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Question extends Model
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;

    protected $guarded = [];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Question');
    }

    /** Relationship */
    public function questionDetails()
    {
        return $this->hasMany(QuestionDetail::class);
    }

    public function quizQuestions()
    {
        return $this->hasOne(QuizQuestion::class);
    }

    public function responses()
    {
        return $this->hasMany(Reponse::class);
    }
}
