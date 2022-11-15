<?php

namespace App\Models\Quiz;

use App\Traits\CreatedUpdatedBy;
use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Quiz extends Model
{
    use HasFactory, LogsActivity;
    use CreatedUpdatedBy, ModelScopes;

    protected $guarded = [];

    /** Spatie Activity Log */
    public function getActivitylogOptions(): LogOptions // spatie model log options
    {
        return LogOptions::defaults()->logAll()->useLogName('Quiz');
    }

    /** Relationship */
    public function quizDetails()
    {
        return $this->hasMany(QuizDetail::class);
    }

    public function quizLeaderboard()
    {
        return $this->hasOne(QuizLeaderboard::class);
    }

    public function quizQuestions()
    {
        return $this->hasMany(QuizQuestion::class);
    }
}
